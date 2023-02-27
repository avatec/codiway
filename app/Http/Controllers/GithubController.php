<?php

namespace App\Http\Controllers;

use App\Http\Requests\GithubStoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Github;
use App\Models\User;
use App\Helpers\GithubClientHelper;

class GithubController extends Controller
{
    public function index(Request $request)
    {
        $items = Github::all()->map(function ($item) {
            $item->stats = json_decode($item->stats);
            $item->stats->stars_rank = $this->getRank($item->stats->stars);
            $item->stats->followers_rank = $this->getRank($item->stats->followers);
            $item->stats->forks_rank = $this->getRank($item->stats->forks);
            $item->stats->releases_rank = $this->getRank($item->stats->releases);

            $item->rank_name = $this->getCustomRank( $item->rank );

            return $item;
        });

        return view('github.index', [
            'list' => $items,
            'records' => Github::count()
        ]);
    }

    private function getRank( $stars )
    {
        if ($stars == 0) {
            return 'brak';
        } elseif ($stars < 10) {
            return 'mało';
        } elseif ($stars < 100) {
            return 'średnio';
        } else {
            return 'dużo';
        }
    }

    private function getCustomRank( $rank )
    {
        return match( $rank ) {
            1 => 'Nieprzydatne',
            2 => 'Przydatne',
            3 => 'Bardzo przydatne',
            4 => 'Niezbędne'
        };
    }

    public function add(): View
    {
        return view('github.add');
    }

    public function show( $id )
    {
        $item = Github::findOrFail($id);

        return view('github.show', compact('item'));
    }

    public function store(GithubStoreRequest $request, GithubClientHelper $helper, $id = null)
    {
        $data = $request->validated();
        if (Github::count() >= 5) {
            return redirect()->route('github')->withErrors(['message' => 'Cannot create more than 5 records.']);
        }

        $stats = $helper->getStats( $data['url'] );
        $data['stats'] = $stats->getContent();
        $github = Github::updateOrCreate(['id' => $id], $data);

        $status = $id ? 'github-updated' : 'github-created';
        return redirect()->route('github')->with('status', $status);
    }

    public function remove($id)
    {
        $github = Github::findOrFail($id);
        $github->delete();
        return redirect()->route('github');
    }
}
