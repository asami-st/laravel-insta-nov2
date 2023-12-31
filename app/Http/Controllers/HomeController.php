<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();

        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users);
    }

    private function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 5);
        /*
           array_slice(x, y, z)
           x:  array/array_name
           y:  offset/starting index
           z:  length/number of items
        */
    }

    public function search(Request $request){
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();

        if ($request->ajax()) {
            return response()->json($users);
        }

        return view('users.search')
                ->with('users', $users)
                ->with('search', $request->search);
    }

    public function getAllSuggestedUsers()
    {
        $user_id = Auth::user()->id;

        $all_suggested_users = $this->user
            ->where('id', '!=', $user_id)
            ->whereDoesntHave('followers', function ($query) use ($user_id) {
                $query->where('follower_id', $user_id);
            })
            ->paginate(5);

        return view('users.suggestions')
                ->with('all_suggested_users', $all_suggested_users);
    }
}
