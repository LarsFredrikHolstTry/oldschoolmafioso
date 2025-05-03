<?php

    session_start();
    // Destroying All Sessions
    if(session_destroy()) {
        // Redirecting To Home Page
        $cookie_name = "remember_forever";
        unset($_COOKIE[$cookie_name]);
        // empty value and expiration one hour before
        setcookie($cookie_name, '', time() - 3600);

        header("Location: logginn.php");
    }

?>