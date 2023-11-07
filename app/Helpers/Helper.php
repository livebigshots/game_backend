<?php

namespace App\Helpers;

use App\Models\User;

class Helper {

    public static function generateRandomPassword($length = 8)
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%&@!$%&@');
        $password = substr($random, 0, $length);
        return $password;
    }

    public static function revokeUserTokens($userId) {
        $userDetails = User::find($userId);

        $existingTokens = $userDetails->tokens;

        foreach($existingTokens as $key => $token) {
            $token->revoke();
            $token->delete();
        }
    }
}
