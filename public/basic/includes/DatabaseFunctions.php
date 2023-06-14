<?php
    function query($pdo, $sql, $parameters = []) { // $parameters 인수에 기본값을 빈 배열로 적용
        $query = $pdo -> prepare($sql);
        
        // foreach ($parameters as $name => $value) {
        //     $query -> bindValue($name, $value);
        // }

        $query -> execute($parameters);

        return $query;
    }

    function totalJokes($database) {
        // query() 함수로 보낼 빈 배열 생성 (대신 인수에 기본값 적용)
        // $parameters = [];

        // query() 함수를 호출할 때 빈 $parameters 배열을 전달 (오류 방지)
        $query = query($database, 'SELECT COUNT(*) FROM `joke`');

        $row = $query -> fetch();

        return $row[0];
    }

    function getJoke($pdo, $id) {
        // query() 함수에서 사용할 $parameters 배열 생성
        $parameters = [':id' => $id];

        // query() 함수를 호출할 때 $parameters 배열 제공
        $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);

        return $query -> fetch();
    }

    function insertJoke($pdo, $joketext, $authorId) {
        $query = 'INSERT INTO `joke` (`joketext`, `jokedate`, `authorId`)
                  VALUES (:joketext, CURDATE(), :authorId)';

        $parameters = [':joketext' => $joketext, ':authorId' => $authorId];

        query($pdo, $query, $parameters);
    }

    function updateJoke($pdo, $jokeId, $joketext, $authorId) {
        $parameters = [':joketext' => $joketext, ':authorId' => $authorId, ':id' => $jokeId];

        query($pdo, 'UPDATE `joke`
                        SET `authorId` = :authorId, `joketext` = :joketext
                      WHERE `id` = :id', $parameters);
    }

    function deleteJoke($pdo, $id) {
        $parameters = [':id' => $id];

        $query = 'DELETE FROM `joke` WHERE `id` = :id';

        query($pdo, $query, $parameters);
    }

    function allJoke($pdo) {
        $jokes = query($pdo, 'SELECT `joke`.`id`, `joketext`, `name`, `email` FROM `joke`
                              INNER JOIN `author` ON `authorId` = `author`.`id`');

        return $jokes -> fetchAll();
    }
?>