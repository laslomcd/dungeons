<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use function view;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'threads' => $user->threads()->paginate(25)
        ]);
    }
}
