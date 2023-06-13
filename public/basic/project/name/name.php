<?php
    // $name = $_GET['name'];
    // // echo $name . '님, 홈페이지 방문을 환영합니다!';
    // // $name 변수값에 포함된 모든 문자열을 HTML코드가 아니라 일반적인 텍스트로 취급한다.
    // echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '님, 홈페이지 방문을 환영합니다!';

    // $firstname = $_GET['firstname'];
    // $lastname = $_GET['lastname'];

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    echo htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8')
            . ' '
            . htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8')
            . '님, 홈페이지 방문을 환영합니다!';
?>