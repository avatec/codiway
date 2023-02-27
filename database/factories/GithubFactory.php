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
            'url' => $url,
            'rank' => $this->faker->randomElement([1,2,3,4]),
            'stats' => json_encode([
                'stars' => 10,
                'followers' => 20,
                'forks' => 30,
                'releases' => 40,
                'last_release_date' => '2023-02-27',
                'open_pull_requests' => 5,
                'closed_pull_requests' => 10,
                'latest_pull_request' => 'http://github.com/smarty-php/smarty/pulls/123',
                'latest_merge_pull_request' => 'http://github.com/smarty-php/smarty/pulls/456'
            ])
        ];
    }
}
