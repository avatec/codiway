<?php

namespace App\Http\Controllers;

use App\Http\Requests\GithubStoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Github;
use App\Models\User;

class GithubController extends Controller
{
    public function index(Request $request)
    {
        $items = Github::all();

        return view('github.index', [
            'list' => $items,
            'records' => Github::count()
        ]);
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

    public function store(GithubStoreRequest $request, $id = null)
    {
        $data = $request->validated();
        if (Github::count() >= 5) {
            return redirect()->route('github')->withErrors(['message' => 'Cannot create more than 5 records.']);
        }
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
