<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>변수와 연산자</title>
</head>
<body>
    <p>
        <?php
            $var1 = 1 + 1; // 2 할당
            $var2 = 1 - 1; // 0 할당
            $var3 = 2 * 2; // 4 할당
            $var4 = 2 / 2; // 1 할당
            $var5 = '여어 ' . '안녕!'; // '여어 안녕!' 할당
            $var6 = 'PHP'; // 'PHP' 할당

            echo $var1 . '<br>';
            echo $var2 . '<br>';
            echo $var3 . '<br>';
            echo $var4 . '<br>';
            echo $var5 . '<br>';
            echo '$var6 규칙! <br>'; // '$var6 규칙!' 출력
            echo "$var6 규칙! <br>"; // 'PHP 규칙!' 출력
        ?>
    </p>
</body>
</html>