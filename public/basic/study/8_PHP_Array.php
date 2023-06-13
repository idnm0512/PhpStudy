<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>배열</title>
</head>
<body>
    <?php
        $testArray = ['하나', 2, 3];

        echo $testArray[0] . '<br>'; // '하나' 출력
        echo $testArray[1] . '<br>'; // 2 출력
        echo $testArray[2] . '<br>'; // 3 출력

        $testArray[1] = '둘'; // 값을 다시 할당
        $testArray[3] = '넷'; // 새로운 값을 할당
        $testArray[] = '다섯'; // 배열의 끝에 원소 추가

        echo $testArray[1] . '<br>'; // '둘' 출력
        echo $testArray[3] . '<br>'; // '넷' 출력
        echo $testArray[4] . '<br>'; // '다섯' 출력

        $var1 = 2;
        $var2 = 3;

        // 숫자 대신 해당 값이 할당된 변수 사용 가능
        echo $testArray[$var1] . '<br>'; // 3 출력
        echo $testArray[$var2] . '<br>'; // '넷' 출력

        // 일반적으로 숫자를 부여하지만 문자열을 부여하는 배열도 있다. (연관 배열)
        $phoneNumbers = [
            'Kebin' => '010-1234-5678',
            'Lee' => '010-1111-1111',
            'David' => '010-2222-2222',
        ];

        echo $phoneNumbers['Kebin'] . '<br>';
        echo $phoneNumbers['Lee'] . '<br>';
        echo $phoneNumbers['David'] . '<br>';
    ?>
</body>
</html>