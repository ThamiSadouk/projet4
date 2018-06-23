<?php

session_start();

/*
 * Flash message helper
 * EXEMPLE - flash('register_success', 'You are registered, 'alert alert-danger');
 * AFFICHE DANS LA VUE- <?= flash('register_sucess');
 */
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if(!empty($name)) { // vérifie si $name est passé en paramètre
        // if $message is passed in and if session $name is not already set
        if(!empty($message) && empty($_SESSION[$name])){
            if(!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if(!empty($_SESSION[$name. '_class'])) {
                unset($_SESSION[$name. '_class']);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name. '_class'] = $class;
        } elseif(empty($message) && !empty($_SESSION[$name])) {
            // if it's not empty, we put $name inside class else quote
            $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
            echo '<div class="'.$class.'" id="msg-flash">' .$_SESSION[$name]. '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name. '_class']);
        }
    }
}

function isLoggedIn() {
    if(isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}