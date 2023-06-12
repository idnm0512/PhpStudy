<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>무작위 숫자</title>
</head>
<body>
    <p>
        1에서 10까지 무작위 숫자 생성하기 :
        <?php
            /*
                http://localhost:8123/PHP-RandomNumber.php

                브라우저 화면에서 '마우스 오른쪽 클릭' > '페이지 소스 보기'를 통해 코드를 확인하면,
                브라우저로 출력된 해당 페이지에 PHP 코드가 사라졌음을 알 수 있다.
                39p. 참고
            */
            echo rand(1, 10);
        ?>
    </p>
</body>
</html>