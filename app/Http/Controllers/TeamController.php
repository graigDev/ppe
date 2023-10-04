<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $teams = Team::get();

        return view('services.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamStoreRequest $request)
    {
        $team = Team::create([
            'user_id'   =>  auth()->user()->id,
            'name'      =>  $request->name
        ]);

        $team->users()->attach(auth()->user()->id);

        return back()->with('success', "L'equipe \"{$request->name}\" a bien été créé.");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TeamUpdateRequest $request, Team $team): \Illuminate\Http\RedirectResponse
    {
        $oldname = $team->name;
        $team->update($request->validated());

        return back()->with('success', "Le nom de l'equipe a été changé de \"{$oldname}\" à \"{$request->name}\".");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $oldname = $team->name;

        $team->delete();

        return back()->with('success', "L'equipe \"{$oldname}\" à bien été supprimé.");
    }
}
