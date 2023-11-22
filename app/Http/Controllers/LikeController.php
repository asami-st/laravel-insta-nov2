<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;
    private $user;
    private $post;

    public function __construct(Like $like, User $user, Post $post){
        $this->like = $like;
        $this->user = $user;
        $this->post = $post;
    }

    public function index($id){
        $user = $this->user->findOrFail($id);
        $likes = $user->likes;

        $liked_posts = [];
        foreach ($likes as $like) {
            $liked_posts[] = $like->post;
        }

        return view('users.likes.index')
                ->with('liked_posts', $liked_posts);
    }



    public function store($post_id){
        $this->like->user_id = Auth::user()->id;        // user who liked the post
        $this->like->post_id = $post_id;                // post being liked
        $this->like->save();                            // execute the query

        return redirect()->back();                      // return to the previous page
    }

    # Unlike/Destroy
    # This method will destroy/or remove the likes details in the likes table
    public function destroy($post_id){
        $this->like
                ->where('user_id', Auth::user()->id)    // user who liked the post
                ->where('post_id', $post_id)            // post being liked
                ->delete();                            // delete the user id and post id

        return redirect()->back();
    }
}
