<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Github;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\GithubStoreRequest;
use Github\Client;

class GithubApiController extends Controller
{
    public function __construct()
    {
        $this->client = new Client();
    }

    private function getGithubStats( string $url )
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

        $cachedResult = Cache::get($cacheKey);
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

            $data = [
                'stars' => $stars,
                'followers' => $followers,
                'forks' => $numForks,
                'releases' => $numReleases,
                'last_release_date' => date('Y-m-d H:i:s' , strtotime($lastReleaseDate)),
                'open_pull_requests' => $numOpenPullRequests,
                'closed_pull_requests' => $numClosedPullRequests,
                'latest_pull_request' => $latestPullRequest,
                'latest_merge_pull_request' => $latestMergedPullRequest
            ];
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting GitHub stats. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }

        $result = response()->json( $data);

        Cache::put($cacheKey, $result, $cacheTime);
        return $result;
    }

    /**
     * @lrd:start
     * Returns github repositories list
     * @lrd:end
     * @return json array
     */
    public function index()
    {
        $data = Cache::remember('github.data', 60, function () {
            return Github::all();
        });

        if( empty( $data )){
            throw new NotFoundException("Data not found");
        }

        foreach( $data as $index=>$value ) {
            $data[$index]['stats'] = $this->getGithubStats( $value['url']);

        }

        return response()->json(['data' => $data], 200);
    }

    /**
     * @LRDparam name string Name of repository
     * @LRDparam url string URL of repository
     * @LRDparam responses 204,201,404
     */
    public function store(GithubStoreRequest $request, $id = null)
    {
        $data = $request->validated();
        if( empty( $data )){
            throw new NotFoundException("Data not found");
        }

        if (Github::count() >= 5) {
            throw new NotFoundException("Cannot create more than 5 records.");
        }

        $github = Github::updateOrCreate(['id' => $id], $data);

        return response()->json(['success' => true, 'id' => $github->id], $id ? 204: 201);
    }

    public function remove($id)
    {
        $github = Github::find($id);
        if (!$github) {
            throw new NotFoundException("Record not found");
        }

        $github->delete();
        return response()->json(['success' => true]);
    }
}
