<?php

use App\Models\Catalog;
use App\Models\User;

describe('index', function () {
    it('returns a list of catalogs', function () {
        $user = User::factory()->create();
        Catalog::factory()->count(5)->create();

        $this
            ->actingAs($user)
            ->get(route('catalogs.index'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    });

    it('throws unauthentication error', function () {
        $this
            ->getJson(route('catalogs.index'))
            ->assertUnauthorized();
    });
});

describe('show', function () {
    it('returns an catalog', function () {
        $user = User::factory()->create();
        $catalog = Catalog::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('catalogs.show', $catalog))
            ->assertSuccessful()
            ->assertJsonFragment([
                'id' => $catalog->id,
                'title' => $catalog->title,
                'artifact_label' => $catalog->artifact_label,
                'artifact_plural_label' => $catalog->artifact_plural_label,
            ]);
    });

    it('throws unauthentication error', function () {
        $catalog = Catalog::factory()->create();

        $this
            ->getJson(route('catalogs.show', $catalog))
            ->assertUnauthorized();
    });
});

describe('store', function () {
    it('creates an catalog', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $title = fake()->text(20);
        $artifactLabel = fake()->word();
        $artifactPlural = fake()->word();

        $this
            ->actingAs($user)
            ->post(route('catalogs.store'), [
                'title' => $title,
                'artifact_label' => $artifactLabel,
                'artifact_plural_label' => $artifactPlural,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('catalogs', [
            'title' => $title,
            'artifact_label' => $artifactLabel,
            'artifact_plural_label' => $artifactPlural,
        ]);
    });

    it('throws unauthentication error', function () {
        $this
            ->postJson(route('catalogs.store'), [])
            ->assertUnauthorized();

        $this->assertDatabaseEmpty('catalogs');
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();

        $this
            ->actingAs($user)
            ->postJson(route('catalogs.store'), [])
            ->assertForbidden();

        $this->assertDatabaseEmpty('catalogs');
    });
});

describe('update', function () {
    it('updates an catalog', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $catalog = Catalog::factory()->create();
        $newTitle = fake()->text(20);

        $this
            ->actingAs($user)
            ->putJson(route('catalogs.update', $catalog), [
                'title' => $newTitle,
                'artifact_label' => $catalog->artifact_label,
                'artifact_plural_label' => $catalog->artifact_plural_label,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('catalogs', [
            'id' => $catalog->id,
            'artifact_label' => $catalog->artifact_label,
            'artifact_plural_label' => $catalog->artifact_plural_label,
        ]);
    });

    it('throws unauthentication error', function () {
        $catalog = Catalog::factory()->create();

        $this
            ->putJson(route('catalogs.update', $catalog), [])
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();
        $catalog = Catalog::factory()->create();

        $this
            ->actingAs($user)
            ->putJson(route('catalogs.update', $catalog), [])
            ->assertForbidden();
    });
});

describe('destroy', function () {
    it('deletes an catalog', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $catalog = Catalog::factory()->create();

        $this->assertDatabaseHas('catalogs', [
            'id' => $catalog->id,
            'deleted_at' => null,
        ]);

        $this
            ->actingAs($user)
            ->deleteJson(route('catalogs.destroy', $catalog))
            ->assertSuccessful();

        $this->assertDatabaseHas('catalogs', [
            'id' => $catalog->id,
            'deleted_at' => now()->toDateTimeString(),
        ]);
    });

    it('throws unauthentication error', function () {
        $catalog = Catalog::factory()->create();

        $this
            ->deleteJson(route('catalogs.destroy', $catalog))
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();
        $catalog = Catalog::factory()->create();

        $this
            ->actingAs($user)
            ->deleteJson(route('catalogs.destroy', $catalog))
            ->assertForbidden();

        $this->assertDatabaseHas('catalogs', ['id' => $catalog->id]);
    });
});
