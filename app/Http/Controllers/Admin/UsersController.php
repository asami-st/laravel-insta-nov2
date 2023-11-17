<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; //inherit the user model

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index()
    {
        $all_users = $this->user->withTrashed()->latest()->paginate(4);
        // The same: "SELECT * from users ORDER BY created_at DESC"

        return view('admin.users.index')
                ->with('all_users', $all_users);
    }

    public function activate($id){
        // $this->user->withTrashed()->findOrFail($id)->restore();
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }
}
