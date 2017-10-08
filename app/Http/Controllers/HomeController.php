<?php

namespace App\Http\Controllers;

use App\User;
use App\Chat;
use App\PersonalChat;
use Illuminate\Http\Request;
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
        return view('home', [
            'users' => User::get()->all(),
            'chats' => Chat::whereIn('c_id',PersonalChat::where('user_id_1',Auth::user()->id)->orWhere('user_id_2',Auth::user()->id)->pluck('id')->toArray())->get()
        ]);
    }


    public function group() {
        return view('group', [
            'users' => User::get()->all(),
        ]);
    }
}

