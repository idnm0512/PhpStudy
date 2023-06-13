<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>주사위 게임 (for문)</title>
</head>
<body>
    <?php
        for ($count = 0; $count < 3; $count++) {
            $roll = rand(1, 6);

            echo '<p>주사위를 굴려 나온 숫자 : ' . $roll . '</p>';

            if ($roll == 6) {
                echo '<p>이겼다!</p>';
            } else if ($roll == 5) {
                echo '<p>오!</p>';
            } else {
                echo '<p>아쉽지만 \'꽝\'이네요. 다음 기회를 노려보세요!</p>';
            }
    
            echo '<p>게임에 참여해주셔서 감사합니다.</p>';
        }
    ?>
</body>
</html>