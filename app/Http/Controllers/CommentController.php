<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        # 1. Validate the data first
        $request->validate(
            [
            'comment_body' . $post_id => 'required|max:150'
            ],
            [
                'comment_body' .$post_id . '.required' => 'You cannot submit an empty comment.',
                'comment_body' .$post_id . '.max'      => 'The comment must not be greater than 150 characters.'
            ]
        );
        # 2. Save/insert comment details
        $this->comment->body    = $request->input('comment_body' . $post_id);
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->save();

        # 3. return to the previous page
        return redirect()->back();

    }

    public function destroy($id){
        $this->comment->destroy($id);

        return redirect()->back();
    }

    # 1. Create a destroy method
    # 2. Create the for that
    # 3. use the route in comments and show blade file to delete the comment
    # 4. return the view to the previous page
}
