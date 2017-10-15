<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\PersonalChat;
use App\GroupChat;
use App\GroupMember;
use App\Chat;
use App\Message\MessageRepository;
use App\Users\UserRepository;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller {

	public function __construct() {
    	$this->middleware('auth');
    }

    public function search(MessageRepository $msg_repo, UserRepository $user_repo) {

    	$messages = $msg_repo->search((string) request('query'), (int) request('chat_id_search'));
        $users = $user_repo->search((string) request('query'));

        $id = request('chat_id_search');

        $pchat = Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get();
        $gchat = Chat::whereIn('c_id',GroupMember::where('user_id',Auth::user()->id)->pluck('group_chat_id')->toArray())->get();

        return view('search', [
            'messages' => $messages,
            'search_users' => $users,
            'user' => Auth::user(),
            'chats' => ($pchat->merge($gchat))->sortBy('created_at'),
            'type' => 'search'
        ]);

    }
    
}