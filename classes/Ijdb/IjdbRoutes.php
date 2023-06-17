<?php
    namespace Ijdb;

    use \Hanbit\DatabaseTable;
    use \Hanbit\Routes;
    use \Hanbit\Authentication;
    use \Ijdb\Controllers\Joke;
    use \Ijdb\Controllers\Register;
    use \Ijdb\Controllers\Login;

    class IjdbRoutes implements Routes {

        private $jokesTable;
        private $authorsTable;
        private $authentication;

        public function __construct() {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $this -> jokesTable = new DatabaseTable($pdo, 'joke', 'id');
            $this -> authorsTable = new DatabaseTable($pdo, 'author', 'id');
            $this -> authentication = new Authentication($this -> authorsTable, 'email', 'password');
        }
        
        public function getRoutes(): array {
            $jokeController = new Joke($this -> jokesTable, $this -> authorsTable, $this -> authentication);
            $registerController = new Register($this -> authorsTable);
            $loginCotroller = new Login($this -> authentication);

            $routes = [
                'login' => [
                    'GET' => [
                        'controller' => $loginCotroller,
                        'action' => 'loginForm'
                    ],
                    'POST' => [
                        'controller' => $loginCotroller,
                        'action' => 'processLogin'
                    ]
                ],
                'login/success' => [
                    'GET' => [
                        'controller' => $loginCotroller,
                        'action' => 'success'
                    ],
                    'login' => true
                ],
                'login/error' => [
                    'GET' => [
                        'controller' => $loginCotroller,
                        'action' => 'error'
                    ]
                ],
                'logout' => [
                    'GET' => [
                        'controller' => $loginCotroller,
                        'action' => 'logout'
                    ]
                ],
                'author/register' => [
                    'GET' => [
                        'controller' => $registerController,
                        'action' => 'registrationForm'
                    ],
                    'POST' => [
                        'controller' => $registerController,
                        'action' => 'registerUser'
                    ]
                ],
                'author/success' => [
                    'GET' => [
                        'controller' => $registerController,
                        'action' => 'success'
                    ]
                ],
                'joke/list' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'list'
                    ]
                ],
                'joke/edit' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'saveEdit'
                    ],
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'edit'
                    ],
                    'login' => true
                ],
                'joke/delete' => [
                    'POST' => [
                        'controller' => $jokeController,
                        'action' => 'delete'
                    ],
                    'login' => true
                ],
                '' => [
                    'GET' => [
                        'controller' => $jokeController,
                        'action' => 'home'
                    ]
                ]
            ];

            return $routes;
        }

        public function getAuthentication(): Authentication {
            return $this -> authentication;
        }
    }