<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private $message;
    private $user;

    public function __construct(Message $message, User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    public function index()
    {
        $current_user_id = Auth::id();
        // 各ユーザーの最新のmessage_id
        $latest_messages = $this->message->select(DB::raw('MAX(id) as last_message_id'))
            ->where(function ($query) use ($current_user_id) {
                $query->where('send_user_id', $current_user_id)
                    ->orWhere('recieve_user_id', $current_user_id);
            })
            ->groupBy(DB::raw('LEAST(send_user_id, recieve_user_id), GREATEST(send_user_id, recieve_user_id)'));
        // 最新のメッセージ内容と関連するユーザー情報を取得
        $messages = $this->message->whereIn('id', function ($query) use ($latest_messages) {
            $query->select('last_message_id')
                    ->from(DB::raw('(' . $latest_messages->toSql() . ') as sub'))
                    ->mergeBindings($latest_messages->getQuery());
        })->orderBy('created_at', 'desc')->get();

        return view('users.messages.index')
                ->with('messages', $messages);
    }

    public function show($id)
    {

        $user = $this->user->findOrFail($id);
        $current_user_id = Auth::user()->id;

        $messages = $this->message->where(function ($query) use ($current_user_id, $id) {
            $query->where('send_user_id', $current_user_id)
                  ->where('recieve_user_id', $id);
        })->orWhere(function ($query) use ($current_user_id, $id) {
            $query->where('send_user_id', $id)
                  ->where('recieve_user_id', $current_user_id);
        })->get();

        return view('users.messages.show')
                ->with('messages', $messages)
                ->with('user', $user);
    }

    public function send(Request $request, $id)
    {

        $request->validate([
            'message'      => 'required',
        ]);
        $user = $this->user->findOrFail($id);
        $this->message->send_user_id = Auth::user()->id;
        $this->message->recieve_user_id = $user->id;
        $this->message->message = $request->message;
        $this->message->save();

        return redirect()->back();
    }
}
