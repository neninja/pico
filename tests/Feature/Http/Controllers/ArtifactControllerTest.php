<?php

use App\Models\Artifact;
use App\Models\Catalog;
use App\Models\User;

describe('index', function () {
    it('returns a list of artifacts', function () {
        $user = User::factory()->create();
        Artifact::factory()->count(5)->create();

        $this
            ->actingAs($user)
            ->get(route('artifacts.index'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    });

    it('throws unauthentication error', function () {
        $this
            ->getJson(route('artifacts.index'))
            ->assertUnauthorized();
    });
});

describe('show', function () {
    it('returns an artifact', function () {
        $user = User::factory()->create();
        $artifact = Artifact::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('artifacts.show', $artifact))
            ->assertSuccessful()
            ->assertJsonFragment([
                'id' => $artifact->id,
                'title' => $artifact->title,
                'order' => $artifact->order,
                'catalog_id' => $artifact->catalog_id,
            ]);
    });

    it('throws unauthentication error', function () {
        $artifact = Artifact::factory()->create();

        $this
            ->getJson(route('artifacts.show', $artifact))
            ->assertUnauthorized();
    });
});

describe('store', function () {
    it('creates an artifact', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $catalog = Catalog::factory()->create();
        $title = fake()->text(20);
        $order = fake()->numberBetween(0, 100);

        $this
            ->actingAs($user)
            ->post(route('artifacts.store'), [
                'catalog_id' => $catalog->id,
                'title' => $title,
                'order' => $order,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('artifacts', [
            'catalog_id' => $catalog->id,
            'title' => $title,
            'order' => $order,
        ]);
    });

    it('throws unauthentication error', function () {
        $this
            ->postJson(route('artifacts.store'), [])
            ->assertUnauthorized();

        $this->assertDatabaseEmpty('artifacts');
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();

        $this
            ->actingAs($user)
            ->postJson(route('artifacts.store'), [])
            ->assertForbidden();

        $this->assertDatabaseEmpty('artifacts');
    });
});

describe('update', function () {
    it('updates an artifact', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $artifact = Artifact::factory()->create();
        $newTitle = fake()->text(20);
        $newOrder = fake()->numberBetween(0, 100);

        $this
            ->actingAs($user)
            ->putJson(route('artifacts.update', $artifact), [
                'title' => $newTitle,
                'order' => $newOrder,
                'catalog_id' => $artifact->catalog_id,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('artifacts', [
            'id' => $artifact->id,
            'title' => $newTitle,
            'order' => $newOrder,
        ]);
    });

    it('throws unauthentication error', function () {
        $artifact = Artifact::factory()->create();

        $this
            ->putJson(route('artifacts.update', $artifact), [])
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();
        $artifact = Artifact::factory()->create();

        $this
            ->actingAs($user)
            ->putJson(route('artifacts.update', $artifact), [])
            ->assertForbidden();
    });
});

describe('destroy', function () {
    it('deletes an artifact', function () {
        $user = User::factory()->isAdminOrContributor()->create();
        $artifact = Artifact::factory()->create();

        $this->assertDatabaseHas('artifacts', [
            'id' => $artifact->id,
            'deleted_at' => null,
        ]);

        $this
            ->actingAs($user)
            ->deleteJson(route('artifacts.destroy', $artifact))
            ->assertSuccessful();

        $this->assertDatabaseHas('artifacts', [
            'id' => $artifact->id,
            'deleted_at' => now()->toDateTimeString(),
        ]);
    });

    it('throws unauthentication error', function () {
        $artifact = Artifact::factory()->create();

        $this
            ->deleteJson(route('artifacts.destroy', $artifact))
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->isCollector()->create();
        $artifact = Artifact::factory()->create();

        $this
            ->actingAs($user)
            ->deleteJson(route('artifacts.destroy', $artifact))
            ->assertForbidden();

        $this->assertDatabaseHas('artifacts', ['id' => $artifact->id]);
    });
});
