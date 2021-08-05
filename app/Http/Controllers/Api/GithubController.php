<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GithubController extends Controller
{
    const GITHUB_USERS_API_URL = 'https://api.github.com/users/';
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

        if($users->count() <= 0) {
            return $this->buildJson(['is_error' => true,'msg' => 'Please provide atleast one user name']);
        }
        if($users->count() > 10) {
            return $this->buildJson(['is_error' => true,'msg' => 'Max of 10 user only']);
        }

        $github_users_info = [];
        foreach ($users as $user) {
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
                    $github_users_info[] = $user_data;
                } else {
                    $github_users_info[] = [
                        'user' => $user,
                        'found' => false,
                        'msg' => 'User not found'
                    ];
                }
            }catch (\Exception $e) {
                Log::error($e->getMessage());
                $github_users_info[] = [
                    'found' => false,
                    'msg' => $e->getMessage(),
                    'user' => $user
                ];
            }
        }

        $data= ['users' => $github_users_info];
        return $this->buildJson($data);
    }

}
