<?php

namespace Database\Factories;

use App\Models\Artifact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'paid_amount' => fake()->randomFloat(2, 2),
            'artifact_id' => Artifact::factory()->create(),
            'user_id' => User::factory()->create(),
        ];
    }

    public function byUser(User $user): AssetFactory
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}
