<?php
    namespace Ijdb;

    use \Hanbit\DatabaseTable;
    use \Hanbit\Routes;
    use \Hanbit\Authentication;
    use \Ijdb\Controllers\Joke;
    use \Ijdb\Controllers\Register;
    use \Ijdb\Controllers\Login;
    use \Ijdb\Controllers\Category;

    class IjdbRoutes implements Routes {

        private $jokesTable;
        private $authorsTable;
        private $categoriesTable;
        private $authentication;
        private $jokeCategoriesTable;

        public function __construct() {
            include __DIR__ . '/../../includes/DatabaseConnection.php';

            $this -> jokesTable = new DatabaseTable($pdo, 'joke', 'id', '\Ijdb\Entity\Joke',
                                                    [&$this -> authorsTable, &$this -> jokeCategoriesTable]);
            $this -> authorsTable = new DatabaseTable($pdo, 'author', 'id', '\Ijdb\Entity\Author', [&$this -> jokesTable]);
            $this -> categoriesTable = new DatabaseTable($pdo, 'category', 'id', '\Ijdb\Entity\Category',
                                                    [&$this -> jokesTable, &$this -> jokeCategoriesTable]);
            $this -> authentication = new Authentication($this -> authorsTable, 'email', 'password');
            $this -> jokeCategoriesTable = new DatabaseTable($pdo, 'joke_category', 'categoryId');
        }
        
        public function getRoutes(): array {
            $jokeController = new Joke($this -> jokesTable, $this -> authorsTable, $this -> categoriesTable, $this -> authentication);
            $registerController = new Register($this -> authorsTable);
            $loginCotroller = new Login($this -> authentication);
            $categoryController = new Category($this -> categoriesTable);

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
                'category/list' => [
                    'GET' => [
                        'controller' => $categoryController,
                        'action' => 'list'
                    ],
                    'login' => true,
                    'permissions' => \Ijdb\Entity\Author::LIST_CATEGORIES
                ],
                'category/edit' => [
                    'POST' => [
                        'controller' => $categoryController,
                        'action' => 'saveEdit'
                    ],
                    'GET' => [
                        'controller' => $categoryController,
                        'action' => 'edit'
                    ],
                    'login' => true,
                    'permissions' => \Ijdb\Entity\Author::EDIT_CATEGORIES
                ],
                'category/delete' => [
                    'POST' => [
                        'controller' => $categoryController,
                        'action' => 'delete'
                    ],
                    'login' => true,
                    'permissions' => \Ijdb\Entity\Author::REMOVE_CATEGORIES
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

        public function checkPermission($permission): bool {
            $user = $this -> authentication -> getUser();

            if ($user && $user -> hasPermission($permission)) {
                return true;
            } else {
                return false;
            }
        }
    }