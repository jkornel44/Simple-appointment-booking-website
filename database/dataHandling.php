<?php

function userExists($email){
    return isset( json_decode(file_get_contents('../database/felhasznalok.json'))->$email->email );
}

function pswdMatch($email, $pswd){
    return password_verify($pswd, json_decode(file_get_contents('../database/felhasznalok.json'))->$email->jszo);
}

function registration($name, $taj, $address, $email, $pswd){
    $adatok = json_decode(file_get_contents('../database/felhasznalok.json'));
    $adatok->$email = (object)[
        "nev" => $name,
        "taj" => $taj,
        "cim" => $address,
        "email" => $email,
        "jszo" => password_hash($pswd, PASSWORD_DEFAULT),
        "admin" => false 
    ];
    file_put_contents('../database/felhasznalok.json', json_encode($adatok, JSON_PRETTY_PRINT));
}

function addDate($date, $capacity, $month){
    $adatok = json_decode(file_get_contents('../database/idopontok.json'));
        $adatok->$month[] = (object)[
            "date" => $date,
            "max" => $capacity,
            "patient" => []
        ];
        file_put_contents('../database/idopontok.json', json_encode($adatok, JSON_PRETTY_PRINT));
}

function apply($date, $email, $month){
    $datas = json_decode(file_get_contents('../database/idopontok.json'));
    foreach($datas->$month as $d) {
        if($d->date == $date && count($d->patient) < $d->max) {
            $d->patient[]= $email;
            file_put_contents('../database/idopontok.json', json_encode($datas, JSON_PRETTY_PRINT));
            return true;
        }
    }
    return false;
}

function getReservation($email) {
    $adatok = json_decode(file_get_contents('database/idopontok.json'));
    foreach($adatok as $month) {
        foreach($month as $date) {
            if(in_array($email, $date->patient)) return $date->date;
        }
    }
}

function hasReservation($email) {
    $adatok = json_decode(file_get_contents('database/idopontok.json'));
    foreach($adatok as $month) {
        foreach($month as $date) {
            if(in_array($email, $date->patient)) return true;
        }
    }
    return false;
}

function deleteReservation($email) {
    $adatok = json_decode(file_get_contents('../database/idopontok.json'));
    foreach($adatok as $month) {
        foreach($month as $date) {
            if (($key = array_search($email, $date->patient)) !== false) {
                unset($date->patient[$key]);
            }
        }
    }
    file_put_contents('../database/idopontok.json', json_encode($adatok, JSON_PRETTY_PRINT));
}