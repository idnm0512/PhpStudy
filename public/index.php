<?php
    use \Hanbit\EntryPoint;
    use \Ijdb\IjdbRoutes;

    try {
        include __DIR__ . '/../includes/autoload.php';

        $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

        $entryPoint = new EntryPoint($route, $_SERVER['REQUEST_METHOD'], new IjdbRoutes());
        $entryPoint -> run();

    } catch (PDOException $e) {
        $output = '데이터베이스 오류.'
                    . '<br> 내용: ' . $e -> getMessage()
                    . '<br> 경로: ' . $e -> getFile()
                    . '<br> 라인: ' . $e -> getLine();

        include __DIR__ . '/../templates/layout.html.php';
    }