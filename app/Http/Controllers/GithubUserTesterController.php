<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubUserTesterController extends Controller
{
    public function index()
    {
        /**
         * notes add token to view for testing purposes only
         */
        $user = auth()->user();
        $tokens =  $user->tokens;
        if($tokens->count() == 0) {
            $user->createToken($user->email); //use email as device name
        }
        $user->refresh();
        return view('github_user_tester.index',['token' => $user->tokens->first()]);
    }
}
