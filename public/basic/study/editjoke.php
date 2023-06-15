<?php
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    try {
        if (isset($_POST['joke'])) {
            $joke = $_POST['joke'];

            $joke['authorId'] = 1;
            $joke['jokedate'] = new DateTime();

            save($pdo, 'joke', 'id' ,$joke);

            header('location: jokes.php');

        } else {
            if (isset($_GET['id'])) {
                $joke = findById($pdo, 'joke', 'id', $_GET['id']);
            }

            $title = '유머 글 수정';

            ob_start();

            include __DIR__ . '/../templates/editjoke.html.php';

            $output = ob_get_clean();
        }

    } catch (PDOException $e) {
        $title = '오류가 발생했습니다.';

        $output = '데이터베이스 오류.'
                . '<br> 내용: ' . $e -> getMessage()
                . '<br> 경로: ' . $e -> getFile()
                . '<br> 라인: ' . $e -> getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';
?>