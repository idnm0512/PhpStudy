<?php
    namespace Ijdb\Controllers;

    use \Hanbit\DatabaseTable;
    use \Hanbit\Authentication;

    class Joke {

        private $jokesTable;
        private $authorsTable;
        private $authentication;

        public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable, Authentication $authentication) {
            $this -> jokesTable = $jokesTable;
            $this -> authorsTable = $authorsTable;
            $this -> authentication = $authentication;
        }

        public function home() {
            $title = '인터넷 유머 세상';

            return ['template' => 'home.html.php', 'title' => $title];
        }

        public function list() {
            $result = $this -> jokesTable -> findAll();

            $jokes = [];

            foreach ($result as $joke) {
                $author = $this -> authorsTable -> findById($joke['authorId']);

                $jokes[] = [
                    'id' => $joke['id'],
                    'joketext' => $joke['joketext'],
                    'jokedate' => $joke['jokedate'],
                    'name' => $author['name'],
                    'email' => $author['email'],
                    'authorId' => $author['id']
                ];
            }

            $title = '유머 글 목록';

            $totalJokes = $this -> jokesTable -> total();

            $author = $this -> authentication -> getUser();

            return ['template' => 'jokes.html.php',
                'title' => $title,
                'variables' => [
                    'totalJokes' => $totalJokes,
                    'jokes' => $jokes,
                    'userId' => $author['id'] ?? null
                ]
            ];
        }

        public function edit() {
            if (!$this -> authentication -> isLoggedIn()) {
                return ['template' => 'loginerror.html.php',
                    'title' => '이 페이지를 볼 수 있는 권한이 없습니다.'
                ];
            }

            $author = $this -> authentication -> getUser();

            if (isset($_GET['id'])) {
                $joke = $this -> jokesTable -> findById($_GET['id']);
            }

            $title = '유머 글 수정';

            return ['template' => 'editjoke.html.php',
                'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null,
                    'userId' => $author['id'] ?? null
                ]
            ];
        }

        public function saveEdit() {
            $author = $this -> authentication -> getUser();

            if (isset($_GET['id'])) {
                $joke = $this -> jokesTable -> findById($_GET['id']);

                if ($joke['authorId'] != $author['id']) {
                    return;
                }
            }

            $joke = $_POST['joke'];

            $joke['jokedate'] = new \DateTime();
            $joke['authorId'] = $author['id'];

            $this -> jokesTable -> save($joke);

            header('location: /joke/list');
        }

        public function delete() {
            $author = $this -> authentication -> getUser();

            $joke = $this -> jokesTable -> findById($_GET['id']);

            if ($joke['authorId'] != $author['id']) {
                return;
            }

            $this -> jokesTable -> delete($_POST['id']);

            header('location: /joke/list');
        }
    }