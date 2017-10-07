<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\PersonalChat;
use App\GroupChat;
use App\GroupMember;
use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller {
    
    public function __construct() {
    	$this->middleware('auth');
    }

    public function newchat($id) {

    	if(PersonalChat::where('user_id_1',Auth::user()->id)->where('user_id_2',$id)->exists()){
    		$pid = PersonalChat::where('user_id_1',Auth::user()->id)->where('user_id_2',$id)->first()->id;
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
    		$id1 = PersonalChat::find($chat->c_id)->user_id_1;
    		$id2 = PersonalChat::find($chat->c_id)->user_id_2;
    		if($id1 == Auth::user()->id)
    			$receiver_id = $id2;
    		else
    			$receiver_id = $id1;
    	}
    	return view('chatroom', [
    		'user' => Auth::user(),
    		'receiver' => User::find($receiver_id)
    	]);
    }
}
