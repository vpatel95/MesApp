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

    public function searchMessage(MessageRepository $repo) {

    	$messages = $repo->search((string) request('query'), (int) request('chat_id_search'));
        $id = request('chat_id_search');

        $pchat = Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get();
        $gchat = Chat::whereIn('c_id',GroupMember::where('user_id',Auth::user()->id)->pluck('group_chat_id')->toArray())->get();

        $chat = Chat::find($id);
        if($chat->type == 'personal'){
            $pc = PersonalChat::find($chat->c_id);
            $id1 = $pc->user_id_1;
            $id2 = $pc->user_id_2;
            if($id1 == Auth::user()->id)
                $receiver_id = $id2;
            elseif($id2 == Auth::user()->id)
                $receiver_id = $id1;
            else
                return redirect()->back();

            return view('search', [
                'messages' => $messages,
                'user' => Auth::user(),
                'receiver' => User::find($receiver_id),
                'chats' => ($pchat->merge($gchat))->sortBy('created_at'),
                'chat_details' => $chat,
                'type' => 'search',
                'id' => $id
            ]);

        } else {
            $gc = GroupChat::find($chat->c_id);
            if(GroupMember::where('group_chat_id',$gc->id)->where('user_id',Auth::user()->id)->exists()){
                return view('search', [
                    'messages' => $messages,
                    'user' => Auth::user(),
                    'receiver' => $gc,
                    'chats' => Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get(),
                    'chat_details' => $chat,
                    'type' => 'search',
                    'id' => $id
                ]);
            }
        }

        return redirect()->back();

    }

    public function searchUser(UserRepository $repo) {
        $users = $repo->search((string) request('query'));

        $pc = Chat::where('type','personal')->whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get();
        $gc = Chat::where('type','group')->whereIn('c_id',GroupMember::where('user_id',Auth::user()->id)->pluck('group_chat_id')->toArray())->get();

        return view('searchuser', [
            'users' => $users,
            'chats' => ($pc->merge($gc))->sortBy('created_at'),
            'chat_details' => null
        ]);
    }
    
}