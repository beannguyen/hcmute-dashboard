<?php

namespace App\Repositories;

use App\User;

class UserRepository {
    public function findByUserNameOrCreate($userData) {

        $user = User::where('provider_id', '=', $userData->id)->first();
        if(!$user) {

            $user = new User();
            $user->provider_id = $userData->id;
            $user->provider = 'google';
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->email = $userData->email;
            $user->active = 1;
            $user->save();
        }
        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {

        $socialData = [
            'email' => $userData->email,
            'name' => $userData->name,
            'username' => $userData->nickname,
        ];
        $dbData = [
            'email' => $user->email,
            'name' => $user->name,
            'username' => $user->username,
        ];

        if (!empty(array_diff($socialData, $dbData))) {

            $user->email = $userData->email;
            $user->name = $userData->name;
            $user->username = $userData->nickname;
            $user->save();
        }
    }
}