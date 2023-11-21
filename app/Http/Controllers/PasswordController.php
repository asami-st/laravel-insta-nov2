<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class PasswordController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.password.edit')
                    ->with('user', $user);
    }
}
