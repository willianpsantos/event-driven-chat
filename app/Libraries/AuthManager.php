<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthManager
{
    const AUTHENTICATED_USER_SESSION = 'authenticated.user.session';

    public static function setAuthUser(Request $request, UserInterface $user) {
        $request->session()->put(self::AUTHENTICATED_USER_SESSION, $user);
    }

    public static function getAuthUser(Request $request) {
        $user = $request->session()->get(self::AUTHENTICATED_USER_SESSION);

        return $user;
    }

    public static function cript(string $text) {
        return sha1($text);
    }

    public static function authenticate(UserInterface $user, string $typedPassword) {
        $password = $user->getPassword();
        $hash = sha1($typedPassword);
        $equals = ( strcmp($password, $hash) === 0 );
        return $equals;
    }
}
