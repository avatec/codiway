<?php

namespace Database\Factories;

use App\Models\Github;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Github>
 */
class GithubFactory extends Factory
{
    protected $model = Github::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'url' => $this->faker->url(),
        ];
    }
}
