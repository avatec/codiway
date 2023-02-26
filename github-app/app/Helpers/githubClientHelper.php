<?php namespace App\Helpers;

use Github\Client;
use Illuminate\Support\Facades\Cache;

class GithubClientHelper
{
    private Client $client;
    private Cache $cache;

    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    public function getStats( string $url )
    {
        $path = parse_url($url, PHP_URL_PATH);
        $parts = explode('/', trim($path, '/'));

        $owner = $parts[0];
        $repo = $parts[1];

        $cacheKey = 'github_stats_' . $owner . '_' . $repo;
        // W tym miejsu można dodać czas cache do konfiguracji
        // $cacheTime = config('cache.github_stats_cache_time');
        // Albo na sztywno ;-)
        $cacheTime = 60 * 60; // na godzinę (limity githuba)

        $cachedResult = $this->cache::get($cacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }

        $data = [];

        try {
            $repository = $this->client->api('repo')->show($owner, $repo);
            $stars = $repository['stargazers_count'];
            $followers = $repository['subscribers_count'];

            $releases = $this->client->api('repo')->releases()->all($owner, $repo);
            $numReleases = count($releases);
            $lastReleaseDate = isset($releases[0]['published_at']) ? $releases[0]['published_at'] : null;

            $forks = $this->client->api('repo')->forks()->all($owner, $repo);
            $numForks = count($forks);

            $pullRequests = $this->client->api('search')->issues('type:pr repo:' . $owner . '/' . $repo . ' is:pr is:open');
            $numOpenPullRequests = $pullRequests['total_count'];

            $closedPullRequests = $this->client->api('search')->issues('type:pr repo:' . $owner . '/' . $repo . ' is:pr is:closed');
            $numClosedPullRequests = $closedPullRequests['total_count'];

            $mergedPullRequests = $this->client->api('search')->issues('type:pr repo:' . $owner . '/' . $repo . ' is:pr is:merged');
            $latestMergedPullRequest = isset($mergedPullRequests['items'][0]['merged_at']) ? $mergedPullRequests['items'][0]['merged_at'] : null;

            $latestPullRequest = isset( $pullRequests['items'][0]['created_at'] ) ? $pullRequests['items'][0]['created_at'] : null;
        } catch (\Exception $e) {
            throw new \Exception('Error getting GitHub stats. Please try again later.');
        }

        $data = [
            'stars' => empty($stars) ? 0 : $stars,
            'followers' => empty($followers) ? 0 : $followers,
            'forks' => empty($numForks) ? 0 : $numForks,
            'releases' => empty($numReleases) ? 0 : $numReleases,
            'last_release_date' => empty($lastReleaseDate) ? null : date('Y-m-d H:i:s' , strtotime($lastReleaseDate)),
            'open_pull_requests' => empty($numOpenPullRequests) ? null : $numOpenPullRequests,
            'closed_pull_requests' => empty($numClosedPullRequests) ? null : $numClosedPullRequests,
            'latest_pull_request' => empty($latestPullRequest) ? null : $latestPullRequest,
            'latest_merge_pull_request' => empty($latestMergedPullRequest) ? null : $latestMergedPullRequest
        ];

        $result = response()->json( $data );

        $this->cache::put($cacheKey, $result, $cacheTime);
        return $result;
    }
}
