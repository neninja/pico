<?php

use App\Models\Artifact;
use App\Models\Asset;
use App\Models\User;

describe('index', function () {
    it('returns a list of assets', function () {
        $user = User::factory()->create();
        Asset::factory()->count(3)->create();
        Asset::factory()->byUser($user)->count(5)->create();

        $this
            ->actingAs($user)
            ->get(route('assets.index'))
            ->assertSuccessful()
            ->assertJsonCount(5, 'data');
    });

    it('throws unauthentication error', function () {
        $this
            ->getJson(route('assets.index'))
            ->assertUnauthorized();
    });
});

describe('show', function () {
    it('returns an assets', function () {
        $user = User::factory()->create();
        $asset = Asset::factory()->byUser($user)->create();

        $this
            ->actingAs($user)
            ->get(route('assets.show', $asset))
            ->assertSuccessful()
            ->assertJsonFragment([
                'id' => $asset->id,
                'paid_amount' => $asset->paid_amount,
            ])
            ->assertJsonPath('data.artifact.id', $asset->artifact->catalog_id);
    });

    it('throws unauthentication error', function () {
        $asset = Asset::factory()->create();

        $this
            ->getJson(route('assets.show', $asset))
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $user = User::factory()->create();
        Asset::factory()->byUser($user)->create();
        $asset = Asset::factory()->create();

        $this
            ->getJson(route('assets.show', $asset))
            ->assertUnauthorized();
    });
});

describe('store', function () {
    it('creates an asset', function () {
        $existentUsers = User::factory()->count(5)->create();
        $user = fake()->randomElement($existentUsers);
        $artifact = Artifact::factory()->create();
        $paidAmount = fake()->randomFloat(2, 2);

        $this
            ->actingAs($user)
            ->post(route('assets.store'), [
                'paid_amount' => $paidAmount,
                'artifact_id' => $artifact->id,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('assets', [
            'paid_amount' => $paidAmount,
            'user_id' => $user->id,
            'artifact_id' => $artifact->id,
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
    it('updates an asset', function () {
        $user = User::factory()->create();
        $paidAmount = fake()->randomFloat(2, 2);
        $asset = Asset::factory()->byUser($user)->create();

        $this
            ->actingAs($user)
            ->putJson(route('assets.update', $asset), [
                'paid_amount' => $paidAmount,
                'artifact_id' => $asset->artifact->id,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'paid_amount' => $paidAmount,
            'artifact_id' => $asset->artifact->id,
        ]);
    });

    it('throws unauthentication error', function () {
        $asset = Asset::factory()->create();

        $this
            ->putJson(route('assets.update', $asset), [])
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $asset = Asset::factory()->create();
        $anotherUser = User::factory()->create();

        $this
            ->actingAs($anotherUser)
            ->putJson(route('assets.update', $asset), [])
            ->assertNotFound();
    });
});

describe('destroy', function () {
    it('deletes an assets', function () {
        $user = User::factory()->create();
        $asset = Asset::factory()->byUser($user)->create();

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'deleted_at' => null,
        ]);

        $this
            ->actingAs($user)
            ->deleteJson(route('assets.destroy', $asset))
            ->assertSuccessful();

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'deleted_at' => now()->toDateTimeString(),
        ]);
    });

    it('throws unauthentication error', function () {
        $asset = Asset::factory()->create();

        $this
            ->deleteJson(route('assets.destroy', $asset))
            ->assertUnauthorized();
    });

    it('throws unauthorization error', function () {
        $asset = Asset::factory()->create();
        $anotherUser = User::factory()->create();

        $this
            ->actingAs($anotherUser)
            ->deleteJson(route('assets.destroy', $asset))
            ->assertNotFound();

        $this->assertDatabaseHas('assets', ['id' => $asset->id]);
    });
});
