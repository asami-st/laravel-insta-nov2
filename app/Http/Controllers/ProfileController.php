<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.show')
                ->with('user', $user);
    }

    public function followers($id){
        $user = $this->user->findOrFail($id);
        $followers = $user->followers()->get();
        return view('users.profile.followers')
                ->with('user', $user)
                ->with('followers', $followers);
    }

    public function following($id){
        $user = $this->user->findOrFail($id);
        $following_users = $user->following()->get();
        return view('users.profile.following')
                ->with('user', $user)
                ->with('following_users', $following_users);
    }


    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);
        # $user[id, name, introduction, created_at, updated_at]
        return view('users.profile.edit')
                    ->with('user', $user);
    }

    public function update(Request $request){

        # 1. Validate the data
        $request->validate(
            [
                'avatar'       => 'mimes:jpeg,jpg,png,gif|max:1048',
                'name'         => 'required|min:1|max:50',
                // 'email'        => ['required', 'email','max:50', Rule::unique('users')->ignore(Auth::id())],
                'email'        => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
                'introduction' => 'nullable|max:100'
            ],
            [
                'name.required'         => 'You cannot submit an empty name.',
                'email.required'        => 'You cannot submit an empty email.',
                'name.max'              => 'The name must not be greater than 50 characters.',
                'introduction.max'      => 'The introduction must not be greater than 100 characters.'
            ]
    );

        $user = $this->user->findOrFail(Auth::user()->id);

        if ($request->avatar) {
            $user->avatar = 'data:avatar/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        $user->save();

        // return redirect()->route('profile.show', $user->id);
        return redirect()->route('profile.show', Auth::user()->id);
    }
}
