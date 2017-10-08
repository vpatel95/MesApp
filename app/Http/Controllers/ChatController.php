<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\PersonalChat;
use App\GroupChat;
use App\GroupMember;
use App\Chat;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {
    
    public function __construct() {
    	$this->middleware('auth');
    }

    public function newchat($id) {

    	if(PersonalChat::whereIn('user_id_1',[Auth::user()->id, $id])->whereIn('user_id_2',[Auth::user()->id, $id])->exists()){
    		$pid = PersonalChat::whereIn('user_id_1',[Auth::user()->id, $id])->whereIn('user_id_2',[Auth::user()->id, $id])->first()->id;
    		$cid = Chat::where('type','personal')->where('c_id',$pid)->first()->id;
    		return redirect('chat/'.$cid);
    	}
    	$personal = new PersonalChat;
    	
    	$personal->user_id_1 = Auth::user()->id;
    	$personal->user_id_2 = $id;

    	$personal->save();

    	$c_id = PersonalChat::where('user_id_1',Auth::user()->id)->where('user_id_2',$id)->first()->id;

    	$chat = new Chat;

    	$chat->type = 'personal';
    	$chat->c_id = $c_id;

    	$chat->save();

    	return redirect('chat/'.$c_id);
    }

    public function chat($id) {
    	$chat = Chat::find($id);
    	if($chat->type == 'personal'){
    		$pc = PersonalChat::find($chat->c_id);
    		$id1 = PersonalChat::find($chat->c_id)->user_id_1;
    		$id2 = PersonalChat::find($chat->c_id)->user_id_2;
    		if($id1 == Auth::user()->id)
    			$receiver_id = $id2;
    		elseif($id2 == Auth::user()->id)
    			$receiver_id = $id1;
    		else
    			return redirect()->back();
    	}
    	return view('chatroom', [
    		'messages' => Message::where('chat_id',$chat->id)->get(),
    		'user' => Auth::user(),
    		'receiver' => User::find($receiver_id),
    		'chats' => Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get(),
    		'chat_details' => $chat
    	]);
    }

    public function sendMessage(Request $request) {
    	$message = $request['message'];
    	$chat_id = $request['chat_id'];
    	$user_id = Auth::user()->id;

    	$m = new Message;

    	$m->message = $message;
    	$m->user_id = $user_id;
    	$m->chat_id = $chat_id;

    	$m->save();

    	broadcast(new MessageSent($user_id, $message, $chat_id));

    	return [
    		'message' => $message,
    		'status' => 'success'
    	];
    }

    public function createGroups(Request $request) {

    }

}
