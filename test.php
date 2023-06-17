<?php


    session_start();

    $_SESSION['password'] = 'mypassword';

    unset($_SESSION['password']);

    $_SESSION = [];

    session_destroy();



    if (!isset($_SESSION['visits'])) {
        $_SESSION['visits'] = 0;
    }

    $_SESSION['visits'] = $_SESSION['visits'] + 1;
    
    if ($visits > 1) {
        echo $_SESSION['visits'] . ' 번째 방문하셨습니다.';
    } else {
        echo '웹사이트에 오신 걸 환영합니다. 둘러보려면 여기를 클릭하세요!';
    }




    if (!isset($_COOKIE['visits'])) {
        $_COOKIE['visits'] = 0;
    }

    $visits = $_COOKIE['visits'] + 1;

    setcookie('visits', $visits, time() * 3600 * 24 * 365);
    
    if ($visits > 1) {
        echo "$vists 번째 방문하셨습니다.";
    } else {
        echo '웹사이트에 오신 걸 환영합니다. 둘러보려면 여기를 클릭하세요!';
    }



?>