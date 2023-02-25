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

        $repository = $this->client->api('repo')->show($owner, $repo);
        $stars = $repository['stargazers_count'];
        $followers = $repository['subscribers_count'];

        $releases = $this->client->api('repo')->releases()->all($owner, $repo);
        $numReleases = count($releases);

        return response()->json([
            'stars' => $stars,
            'followers' => $followers,
            'releases' => $numReleases
        ]);
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
