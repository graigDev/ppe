<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;

class FilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }


    public function download(User $user, File $file): bool
    {
        return $file->team_id === $user->currentTeam->id;
    }
}
