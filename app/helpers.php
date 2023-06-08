<?php

use App\Libraries\SessionTokenManager;
use Illuminate\Support\Facades\DB;

function sesstoken_input() {
    return SessionTokenManager::renderSessionTokenInputHidden();
}

function sesstoken_meta() {
    return SessionTokenManager::renderSessionTokenMetaTag();
}

function sesstoken() {
    return SessionTokenManager::getToken();
}

function unique_id() {
    $time = microtime(true);
    $rand1 = rand();
    $rand2 = rand($rand1, PHP_INT_MAX);
    $key = $time . $rand1 . $rand2;
    $hash = sha1($key);

    return $hash;
}

function current_date($get_as_string = false) {
    $query = DB::select('select current_timestamp(6) as date');
    $date = $query[0]->date;

    if ( $get_as_string === true ) {
        return $date;
    }

    return new \DateTime($date);
}

function interval_desc(\DateInterval $interval) {
    if ($interval->d == 1) {
        return "1 dia";
    }

    if ($interval->d > 1) {
        return "{$interval->d} dias";
    }

    if ( $interval->h == 1 ) {
        return '1 hora';
    }

    if ( $interval->h > 1 ) {
        return "{$interval->h} hora";
    }

    if ( $interval->m == 1 ) {
        return "1 minuto";
    }

    if ( $interval->m > 1 ) {
        return "{$interval->m} minutos";
    }

    if ( $interval->s == 1 ) {
        return "1 segundo";
    }

    if ( $interval->s > 1 ) {
        return "{$interval->s} segundos";
    }

    return "";
}
