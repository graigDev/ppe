<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard()
    {
        $users = User::get();
        $teams = Team::get();
        $folders = Folder::get();
        $files = File::get();
        return view('dashboard', compact('users', 'teams', 'folders', 'files'));
    }
}
