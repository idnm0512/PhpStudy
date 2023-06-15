<?php
    function loadTemplate($templateFileName, $variables = []) {
        extract($variables);

        ob_start();

        include __DIR__ . '/../templates/' . $templateFileName;

        return ob_get_clean();
    }

    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../classes/DatabaseTable.php';
        include __DIR__ . '/../controllers/JokeController.php';
    
        $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new DatabaseTable($pdo, 'author', 'id');
    
        $jokeController = new JokeController($jokesTable, $authorsTable);

        // if (isset($_GET['edit'])) {
        //     $page = $jokeController -> edit();
        // } else if (isset($_GET['delete'])) {
        //     $page = $jokeController -> delete();
        // } else if (isset($_GET['list'])) {
        //     $page = $jokeController -> list();
        // } else {
        //     $page = $jokeController -> home();
        // }

        $action = $_GET['action'] ?? 'home';

        $page = $jokeController -> $action();
    
        $title = $page['title'];

        // if (isset($page['variables'])) {
        //     extract($page['variables']);
        // }

        // ob_start();

        // include __DIR__ . '/../templates/' . $page['template'];

        // $output = ob_get_clean();

        if (isset($page['variables'])) {
            $output = loadTemplate($page['template'], $page['variables']);
        } else {
            $output = loadTemplate($page['template']);
        }

    } catch (PDOException $e) {
        $output = '데이터베이스 오류.'
                    . '<br> 내용: ' . $e -> getMessage()
                    . '<br> 경로: ' . $e -> getFile()
                    . '<br> 라인: ' . $e -> getLine();
    }

    include __DIR__ . '/../templates/layout.html.php';
?>