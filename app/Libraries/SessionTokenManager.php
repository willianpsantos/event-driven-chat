<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionTokenManager
{
    const REQUEST_TOKEN_SESSION = 'request-token';
    const INPUT_HIDDEN_NAME = '__sesstoken';

    public static function generateToken()
    {
        $token = sha1(microtime(true));
        return $token;
    }

    public static function setToken($token)
    {
        Session::put(self::REQUEST_TOKEN_SESSION, $token);
    }

    public static function getToken()
    {
        $token = Session::get(self::REQUEST_TOKEN_SESSION);
        return $token;
    }

    public static function getTokenFromRequest(Request $request)
    {
        $token = $request->input(self::INPUT_HIDDEN_NAME);
        return $token;
    }

    public static function renderSessionTokenInputHidden() {
        $token = self::getToken();
        $name = self::INPUT_HIDDEN_NAME;
        $html = "<input type='hidden' id='{$name}' name='{$name}' value='{$token}' />";

        return $html;
    }

    public static function renderSessionTokenMetaTag() {
        $token = self::getToken();
        $name = self::INPUT_HIDDEN_NAME;
        $html = "<meta name='{$name}' content='{$token}' />";

        return $html;
    }
}
