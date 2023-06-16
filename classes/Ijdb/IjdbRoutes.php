<?php
    namespace Ijdb;

    use \Hanbit\DatabaseTable;
    use \Hanbit\Routes;
    use \Ijdb\Controllers\Joke;
    use \Ijdb\Controllers\Register;

    class IjdbRoutes implements Routes {
        
        public function getRoutes() {
            include __DIR__ . '/../../includes/DatabaseConnection.php';
        
            $jokesTable = new DatabaseTable($pdo, 'joke', 'id');
            $authorsTable = new DatabaseTable($pdo, 'author', 'id');

            $jokeController = new Joke($jokesTable, $authorsTable);

            $routes = [
                'joke/edit' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'saveEdit'
                    ],
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'edit'
                    ]
                ],
                'joke/delete' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'delete'
                    ]
                ],
                'joke/list' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'list'
                    ]
                ],
                '' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'home'
                    ]
                ],
            ];

            return $routes;
        }
    }