<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GithubController extends Controller
{
    const GITHUB_USERS_API_URL = 'https://api.github.com/users/';

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * @param Request $request
     */
    public function users(Request $request, $users_name = null)
    {

        /**
         * TODOS
         * apply redis cache then api authentications
         */

        $users = array_map('trim', explode(',', $users_name));
        $users = collect(array_filter($users))->sort(); //remove also empty values

        if ($users->count() <= 0) {
            return $this->buildJson(['is_error' => true, 'msg' => 'Please provide atleast one user name']);
        }
        if ($users->count() > 10) {
            return $this->buildJson(['is_error' => true, 'msg' => 'Max of 10 user only']);
        }

        $github_users_info = [];
        foreach ($users as $user) {
            $redis_key = 'github:user:' . $user;
            $user_data = Redis::get($redis_key);
            if (!$user_data) {
                $url = self::GITHUB_USERS_API_URL . $user;
                try {
                    $response = Http::get($url);
                    $responseData = $response->json();
                    if ($response->ok()) {
                        $user_data = collect($responseData)->only(['name', 'login', 'company', 'public_repos', 'followers'])->toArray();
                        if ($user_data['followers']) {
                            $user_data['avg_followers'] = number_format($user_data['followers'] / $user_data['public_repos'], 2);
                        } else {
                            $user_data['avg_followers'] = 0;
                        }
                        $user_data['found'] = true;

                    } else {
                        $user_data = [
                            'user' => $user,
                            'found' => false,
                            'msg' => 'User not found'
                        ];
                    }

                    Redis::set($redis_key, json_encode($user_data));
                    Redis::expire($redis_key, 120);
                    Log::info('User ' . $user . ' info was fetched from github.');
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    $user_data = [
                        'found' => false,
                        'msg' => $e->getMessage(),
                        'user' => $user
                    ];
                }
            } else {
                $user_data = json_decode($user_data, true);
                Log::info('User ' . $user . ' info was fetched from cache.');
            }

            $github_users_info[] = $user_data;

        }

        $data = ['users' => $github_users_info];
        return $this->buildJson($data);
    }

}
