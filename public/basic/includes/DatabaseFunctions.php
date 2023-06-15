<?php
    function query($pdo, $sql, $parameters = []) { // $parameters 인수에 기본값을 빈 배열로 적용
        $query = $pdo -> prepare($sql);
        
        // foreach ($parameters as $name => $value) {
        //     $query -> bindValue($name, $value);
        // }

        $query -> execute($parameters);

        return $query;
    }

    function processDates($fields) {
        // 배열 요소 순회
        foreach ($fields as $key => $value) {
            // $value가 DateTime 객체라면
            if ($value instanceof DateTime) {
                // Y-m-s H:i:s 형식으로 변환
                $fields[$key] = $value -> format('Y-m-s H:i:s'); 
            }
        }

        return $fields;
    }

    function save($pdo, $table, $primaryKey, $record) {
        try {
            if ($record['primaryKey'] == '') {
                $record['primaryKey'] = null;
            }

            insert($pdo, $table, $record);

        } catch (PDOException $e) {
            update($pdo, $table, $primaryKey, $record);
        }
    }

    function total($database, $table) {
        // query() 함수로 보낼 빈 배열 생성 (대신 인수에 기본값 적용)
        // $parameters = [];

        // query() 함수를 호출할 때 빈 $parameters 배열을 전달 (오류 방지)
        $query = query($database, 'SELECT COUNT(*) FROM `' . $table . '`');

        $row = $query -> fetch();

        return $row[0];
    }

    function findAll($pdo, $table) {
        $result = query($pdo, 'SELECT * FROM `' . $table . '`');

        return $result -> fetchAll();
    }

    function findById($pdo, $table, $primaryKey, $value) {
        $query = 'SELECT * FROM `' . $table . '` WHERE `' . $primaryKey . '` = :value';

        $parameters = [
            'value' => $value
        ];

        $query = query($pdo, $query, $parameters);

        return $query -> fetch();
    }

    function insert($pdo, $table, $fields) {
        $query = ' INSERT INTO `'. $table . '` (';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
        }
        
        $query = rtrim($query, ',');

        $query .= ') VALUES ('; 

        foreach ($fields as $key => $value) {
            $query .= ':' . $key . ',';
        }

        $query = rtrim($query, ',');

        $query .= ')';

        $fields = processDates($fields);

        query($pdo, $query, $fields);
    }

    function update($pdo, $table, $primaryKey, $fields) {
        $query = ' UPDATE `'. $table .'` SET ';

        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ' , ';
        }

        $query = rtrim($query, ',');

        $query .= ' WHERE `' . $primaryKey . '` = :primaryKey';

        $fields = processDates($fields);

        // :primaryKey 변수 설정
        $fields['primaryKey'] = $fields['id'];

        query($pdo, $query, $fields);
    }

    function delete($pdo, $table, $primaryKey, $id) {
        $parameters = [':id' => $id];

        query($pdo, 'DELETE FROM `' . $table . '` WHERE `'. $primaryKey . '` = :id', $parameters);
    }

    // function getJoke($pdo, $id) {
    //     // query() 함수에서 사용할 $parameters 배열 생성
    //     $parameters = [':id' => $id];

    //     // query() 함수를 호출할 때 $parameters 배열 제공
    //     $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);

    //     return $query -> fetch();
    // }

    // function insertJoke($pdo, $fields) {
    //     $query = ' INSERT INTO `joke` (';

    //     foreach ($fields as $key => $value) {
    //         $query .= '`' . $key . '`,';
    //     }
        
    //     $query = rtrim($query, ',');

    //     $query .= ') VALUES ('; 

    //     foreach ($fields as $key => $value) {
    //         $query .= ':' . $key . ',';
    //     }

    //     $query = rtrim($query, ',');

    //     $query .= ')';

    //     $fields = processDates($fields);

    //     query($pdo, $query, $fields);
    // }

    // function updateJoke($pdo, $fields) {
    //     $query = ' UPDATE `joke` SET ';

    //     foreach ($fields as $key => $value) {
    //         $query .= '`' . $key . '` = :' . $key . ' , ';
    //     }

    //     $query = rtrim($query, ',');

    //     $query .= ' WHERE `id` = :primaryKey';

    //     $fields = processDates($fields);

    //     // :primaryKey 변수 설정
    //     $fields['primaryKey'] = $fields['id'];

    //     query($pdo, $query, $fields);
    // }

    // function deleteJoke($pdo, $id) {
    //     $parameters = [':id' => $id];

    //     $query = 'DELETE FROM `joke` WHERE `id` = :id';

    //     query($pdo, $query, $parameters);
    // }

    // function allJoke($pdo) {
    //     $jokes = query($pdo, 'SELECT `joke`.`id`, `joketext`, `jokedate`, `name`, `email` FROM `joke`
    //                           INNER JOIN `author` ON `authorId` = `author`.`id`');

    //     return $jokes -> fetchAll();
    // }

    // function insertAuthor($pdo, $fields) {
    //     $query = ' INSERT INTO `author` (';

    //     foreach ($fields as $key => $value) {
    //         $query .= '`' . $key . '`,';
    //     }
        
    //     $query = rtrim($query, ',');

    //     $query .= ') VALUES ('; 

    //     foreach ($fields as $key => $value) {
    //         $query .= ':' . $key . ',';
    //     }

    //     $query = rtrim($query, ',');

    //     $query .= ')';

    //     $fields = processDates($fields);

    //     query($pdo, $query, $fields);
    // }

    // function deleteAuthor($pdo, $id) {
    //     $parameters = [':id' => $id];

    //     $query = 'DELETE FROM `author` WHERE `id` = :id';

    //     query($pdo, $query, $parameters);
    // }

    // function allAuthors($pdo) {
    //     $authors = query($pdo, 'SELECT * FROM `author`');

    //     return $authors -> fetchAll();
    // }
?>