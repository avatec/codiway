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
        'https://github.com/TicketSwap/omnipay-przelewy24',
        'https://github.com/smarty-php/smarty',
        'https://github.com/laravel/sail',
        'https://github.com/twigphp/Twig',
        'https://github.com/WordPress/WordPress',
    ];

    protected static $incorrectUrls = [
        'https://github',
        'github.com',
        'www.github.com',
        'http://github.com',
        'ftp://github.com',
    ];

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'url' => $this->faker->randomElement(array_merge(self::$correctUrls, self::$incorrectUrls))
        ];
    }
}
