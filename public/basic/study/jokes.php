<?php
    try {
        // MySQL 접속 도구 중 하나인 PDO 라이브러리를 통해 DB 서버에 접속
        // $pdo = new PDO('mysql:host=localhost;dbname=php_study;charset=utf8', 'jaeho', '1234');

        // PDO 객체의 오류 처리 방식(PDO::ATTR_ERRMODE)을 예외 처리(PDO::ERRMODE_EXCEPTION)로 설정한다.
        // $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        // $sql = 'SELECT `joketext` FROM `joke`';

        // $result = $pdo -> query($sql);

        // while ($row = $result -> fetch()) {
        //     $jokes[] = $row['joketext'];
        // }

        // $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke`
        //         INNER JOIN `author` ON `authorId` = `author`.`id`';

        // $result = $pdo -> query($sql);

        // while ($row = $result -> fetch()) {
        //     // $jokes[] = ['id' => $row['id'], 'joketext' => $row['joketext']];
        //     $jokes[] = $row;
        // }

        $jokes = allJoke($pdo);

        $title = '유머 글 목록';

        $totalJokes = totalJokes($pdo);

        // $output = '';

        // foreach ($jokes as $joke) {
        //     $output .= '<blockquote>';
        //     $output .= '<p>';
        //     $output .= $joke;
        //     $output .= '</p>';
        //     $output .= '</blockquote>';
        // }

        // 버퍼 저장 시작
        ob_start();

        // 템플릿을 include 한다.
        // PHP 코드가 실행되지만, 결과 HTML은 브라우저로 전송되지 않고 버퍼에 저장된다.
        include __DIR__ . '/../templates/jokes2.html.php';

        // 출력 버퍼의 내용을 읽고 $output 변수에 저장한다.
        $output = ob_get_clean();
        
    } catch (PDOException $e) {
        $output = '데이터베이스 오류.'
                    . '<br> 내용: ' . $e -> getMessage()
                    . '<br> 경로: ' . $e -> getFile()
                    . '<br> 라인: ' . $e -> getLine();

        // PHP는 스크립트를 끝까지 실행하고 나서 모든 데이터베이스 접속을 자동으로 끊는다.
        // 데이터베이스 접속을 직접 끊을 때는 객체가 담긴 배열에 null을 할당한다.
        // $pdo = null;
    }

    include __DIR__ . '/../templates/layout.html.php';
?>