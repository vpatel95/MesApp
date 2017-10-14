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
use Illuminate\Support\Facades\DB;
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

    	$c_id = $personal->id;

    	$chat = new Chat;
    	$chat->type = 'personal';
    	$chat->c_id = $c_id;
    	$chat->save();

    	return redirect('chat/'.$chat->id);
    }

    public function chat($id) {
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

	    	return view('chatroom', [
	    		'messages' => Message::where('chat_id',$chat->id)->get(),
	    		'user' => Auth::user(),
	    		'receiver' => User::find($receiver_id),
	    		'chats' => ($pchat->merge($gchat))->sortBy('created_at'),
	    		'chat_details' => $chat,
                'type' => 'nosearch'
	    	]);
	    }else {
	    	$gc = GroupChat::find($chat->c_id);
	    	if(GroupMember::where('group_chat_id',$gc->id)->where('user_id',Auth::user()->id)->exists()){
	    		return view('chatroom', [
	    			'messages' => Message::where('chat_id', $chat->id)->get(),
	    			'user' => Auth::user(),
	    			'receiver' => $gc,
	    			'chats' => Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get(),
	    			'chat_details' => $chat,
                    'type' => 'nosearch'
	    		]);
	    	}
	    }

	    return redirect()->back();
    }

    public function sendMessage(Request $request) {
    	$message = htmlspecialchars($request['message']);
    	$chat_id = $request['chat_id'];
    	$user_id = Auth::user()->id;

        $this->validate($request, [
            'message' => 'required',
        ]);

    	$m = new Message;
    	$m->message = $message;
    	$m->user_id = $user_id;
    	$m->chat_id = $chat_id;
    	$m->save();

    	broadcast(new MessageSent($user_id, $message, $chat_id, User::find($user_id)->name));

    	return [
    		'message' => $message,
    		'status' => 'success'
    	];
    }

    public function createGroup(Request $request) {
    	$name = $request['name'];
    	$members = $request['group_member'];

    	$this->validate($request, [
            'name' => 'required|unique:group_chats',
        ]);

    	$group_chat = new GroupChat;
    	$group_chat->name = $name;
    	$group_chat->save();

    	$c_id = $group_chat->id;

    	$chat = new Chat;
    	$chat->type = 'group';
    	$chat->c_id = $c_id;
    	$chat->save();

    	$gmo = new GroupMember;
        $gmo->group_chat_id = $c_id;
        $gmo->user_id = Auth::user()->id;
        $gmo->save();

    	for ($i=0; $i < sizeof($members); $i++) { 
            
            $gm = new GroupMember;
            $gm->group_chat_id = $c_id;
            $gm->user_id = $members[$i];
            $gm->save();

        }

        return redirect('chat/'.$chat->id);
    }

}
