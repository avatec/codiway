<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Github;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Http\Requests\GithubStoreRequest;
use App\Helpers\GithubClientHelper;
use App\Exceptions\NotFoundException;

class GithubApiController extends Controller
{
    private GithubClientHelper $GithubClient;

    public function __construct( GithubClientHelper $GithubClient )
    {
        $this->GithubClient = $GithubClient;
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

        if (empty($data)) {
            throw new NotFoundException("Data not found", JsonResponse::HTTP_NO_CONTENT);
        }

        foreach( $data as $index=>$value ) {
            try {
                $data[$index]['stats'] = $this->GithubClient->getStats( $value['url'] );
            } catch (\Exception $e) {
                $data[$index]['stats'] = null;
            }
        }

        return response()->json(['data' => $data], JsonResponse::HTTP_OK);
    }

    /**
     * @LRDparam name string Name of repository
     * @LRDparam url string URL of repository
     * @LRDparam responses 204,201,404
     */
    public function store(GithubStoreRequest $request, $id = null)
    {
        $data = $request->validated();
        if (empty($data)) {
            return response()->json(['error' => 'Data not found'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if (Github::count() >= 5) {
            return response()->json(['error' => 'Cannot create more than 5 records.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $github = Github::updateOrCreate(['id' => $id], $data);

        $statusCode = $github->wasRecentlyCreated ? JsonResponse::HTTP_CREATED : JsonResponse::HTTP_OK;

        return response()->json(['success' => true, 'id' => $github->id], $statusCode);
    }


    public function remove($id)
    {
        $github = Github::find($id);
        if (!$github) {
            return response()->json(['error' => 'Data not found'], JsonResponse::HTTP_NO_CONTENT);
        }

        $github->delete();
        return response()->json(['success' => true], JsonResponse::HTTP_OK);
    }
}
