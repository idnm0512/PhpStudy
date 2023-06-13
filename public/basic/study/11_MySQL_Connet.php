<?php
    try {
        // MySQL 접속 도구 중 하나인 PDO 라이브러리를 통해 DB 서버에 접속
        $pdo = new PDO('mysql:host=localhost;dbname=php_study;charset=utf8', 'jaeho', '1234');

        // PDO 객체의 오류 처리 방식(PDO::ATTR_ERRMODE)을 예외 처리(PDO::ERRMODE_EXCEPTION)로 설정한다.
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $output = '데이터베이스 접속 성공.';
    } catch (PDOException $e) {
        $output = '데이터베이스 서버에 접속할 수 없습니다.'
                    . '<br> 내용: ' . $e -> getMessage()
                    . '<br> 경로: ' . $e -> getFile()
                    . '<br> 라인: ' . $e -> getLine();

        // PHP는 스크립트를 끝까지 실행하고 나서 모든 데이터베이스 접속을 자동으로 끊는다.
        // 데이터베이스 접속을 직접 끊을 때는 객체가 담긴 배열에 null을 할당한다.
        // $pdo = null;
    }

    include __DIR__ . '/../templates/output.html.php';
?>