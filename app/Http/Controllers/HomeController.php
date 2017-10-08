<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\PersonalChat;
use App\GroupChat;
use App\GroupMember;
use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pc = Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get();
        $gc = Chat::whereIn('c_id',GroupMember::where('user_id',Auth::user()->id)->pluck('group_chat_id')->toArray())->get();

        return view('home', [
            'users' => User::get()->all(),
            'chats' => ($pc->merge($gc))->sortBy('created_at')
        ]);
    }


    public function group() {
        return view('group', [
            'users' => User::get()->all(),
        ]);
    }
}