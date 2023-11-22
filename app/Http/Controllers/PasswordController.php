<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()
                        ->with('warning', 'The current password is incorrect');
        }

        $request->validate(
            [
                'new_password' => 'required|string|min:8|confirmed'
            ],
            [
                'new_password.required'         => 'You cannot submit an empty password.',
                'new_password.min'              => 'The name must be at least 8 characters long.',
                'new_password.confirmed'        => 'Passwords do not match.'
            ]
        );
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('status', 'Password changed successfully.');
    }
}
