<?php


class Redirect{
    public static function to($location){
        if($location){
            if(is_numeric($location)){
                switch ($location){
                    case 404:
                        header('HTTP 1.0 404 Niet gevonden');
                        include 'includes/errors/404.php';
                        exit();
                    break;

                }
            }
            header('Location: ' . $location);
            exit();
        }
    }
}