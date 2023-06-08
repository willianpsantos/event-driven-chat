<?php

namespace App\Http\Controllers;

use App\Libraries\JsonResponse;
use App\Libraries\AuthManager;
use App\Libraries\SessionTokenManager;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showLoginForm() {
        $token = SessionTokenManager::generateToken();
        SessionTokenManager::setToken($token);

        return view('login');
    }

    public function authenticate(Request $request) {
        $result = new JsonResponse;

        /*
        $requestToken = SessionTokenManager::getTokenFromRequest($request);
        $sessionToken = SessionTokenManager::getToken();

        if ( $requestToken != $sessionToken ) {
            $result->success = false;
            $result->message = 'Requisição inválida';
            $result->field = 'session';

            return response()->json( $result );
        }*/

        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::byEmail($email)->first();

        if( !$user ) {
            $result->success = false;
            $result->message = 'E-mail inválido!';
            $result->field = 'email';

            return response()->json( $result );
        }

        $success = AuthManager::authenticate($user, $password);

        if( !$success ) {
            $result->success = false;
            $result->message = 'E-mail inválido!';
            $result->field = 'email';

            return response()->json( $result );
        }

        $result->success = true;
        $result->message = 'Autenticado com sucesso!';
        $result->redirectTo = route('home');

        $token = SessionTokenManager::generateToken();
        SessionTokenManager::setToken($token);
        $user->sesstoken = $token;
        $user->save();
        $user->type = 'user';

        AuthManager::setAuthUser($request, $user);

        return response()->json( $result );
    }

    public function searchUsers(Request $request, string $text, bool $onlyContacts = false, $user = null) {
        $result = null;

        if($onlyContacts) {
            $result = User::searchUserContacts($text, $user)->get();
        }
        else {
            $result = User::searchUsers($text)->get();
        }

        return response()->json($result);
    }

    public function getUserContacts(Request $request, $id) {
        $contacts = User::contactsOfUser($id);
        return response()->json($contacts);
    }

    public function getRecentContacts(Request $request, $id) {
        $contacts = User::recentContactsOfUser($id);
        return response()->json($contacts);
    }

    public function getAuthenticatedUser(Request $request) {
        $user = AuthManager::getAuthUser($request);
        return response()->json($user);
    }
}
