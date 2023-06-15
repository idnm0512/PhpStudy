<?php
    try {
        // $pdo = new PDO('mysql:host=localhost;dbname=php_study;charset=utf8', 'jaeho', '1234');
        // $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        // $sql = 'DELETE FROM `joke` WHERE `id` = :id';

        // $stmt = $pdo -> prepare($sql);

        // $stmt -> bindValue(':id', $_POST['id']);

        // $stmt -> execute();

        delete($pdo, 'joke', 'id', $_POST['id']);

        header('location: jokes.php');

    } catch (PDOException $e) {
        $title = '오류가 발생했습니다.';

        $output = '데이터베이스 오류.'
                . '<br> 내용: ' . $e -> getMessage()
                . '<br> 경로: ' . $e -> getFile()
                . '<br> 라인: ' . $e -> getLine();
        
    }

    include __DIR__ . '/../templates/layout.html.php';
?>