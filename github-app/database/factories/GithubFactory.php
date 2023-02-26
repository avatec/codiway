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

    protected static $correctUrls = [
        'https://github.com/smarty-php/smarty',
        'https://github.com/laravel/sail',
        'https://github.com/twigphp/Twig'
    ];

    protected static $incorrectUrls = [
        'https://github.com/twigphp/1',
        'https://github.com'
    ];

    public function definition()
    {
        $url = $this->faker->randomElement(array_merge(self::$correctUrls, self::$incorrectUrls));
        return [
            'name' => $this->faker->name(),
            'url' => $url
        ];
    }
}
