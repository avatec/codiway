<?php

namespace App\Http\Controllers;

use App\Http\Requests\GithubStoreRequest;
// use Illuminate\Contracts\View\View;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Github;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Redirect;


class GithubController extends Controller
{
    public function index(): View
    {
        $items = Github::all();
        return view('github.index', ['list' => $items]);
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
        $github = Github::updateOrCreate(['id' => $id], $data);

        $status = $id ? 'github-updated' : 'github-created';
        return redirect()->route('github')->with('status', $status);
    }

    public function remove($id)
    {
        $github = Github::findOrFail($id);
        $github->delete();
        return redirect()->route('github')->with('status', 'Github repository removed successfully');
    }
}
