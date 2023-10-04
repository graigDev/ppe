<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::search($request->search)->get();
        $roles = Role::get();
        $teams = Team::get();

        return view('services.user.index', compact('users', 'roles', 'teams'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'  =>  Hash::make('password')
        ]);

        $user->roles()->attach($request->role);
        $user->teams()->attach($request->team);

        return back()->with('success', "L'utilisateur \"{$request->name}\" a bien été créé.");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $oldname = $user->name;

        $user->delete();

        return back()->with('success', "L'utilisateur \"{$oldname}\" à bien été supprimé.");
    }
}
