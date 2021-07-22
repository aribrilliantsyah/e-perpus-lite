<?php
    function base_url($url = ''){
        $base_url = config('base_url');
        if($base_url){
            $base_url .= $url;
        }else{
            $base_url = sprintf(
                "%s://%s/",
                isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
                $_SERVER['SERVER_NAME']
            );
            $base_url .= $url;
        }
        return $base_url;
    }

    function asset($name_path = ''){
        return base_url($name_path);
    }

    function config($key){
        include('../config/app.php');
        return isset($config[$key]) ? $config[$key] : '';
    }

    function pnow($key){
        echo '<pre>';
        print_r($key);
        echo '</pre>';
        die;
    }

    function pnext($key){
        echo '<pre>';
        print_r($key);
        echo '</pre>';
        // die;
    }

    function get_auth($key){
        return isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : '';
    }

    function get_last_uri(){
        $url = $_SERVER['REQUEST_URI'];
        $tokens = explode('/', $url);
        return end($tokens);
    }
?>