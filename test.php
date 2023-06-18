<?php
    $author = $this -> authentication -> getUser();
    if ($author -> accessLevel == 2) {
        // 관리자
    } else {
        // 관리자 아님
    }
?>