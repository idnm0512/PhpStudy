<?php
    namespace Ijdb\Controllers;

    use \Hanbit\DatabaseTable;

    class Register {

        private $authorsTable;

        public function __construct(DatabaseTable $authorsTable) {
            $this -> authorsTable = $authorsTable;
        }

        public function registrationForm() {
            return ['template' => 'register.html.php', 'title' => '사용자 등록'];
        }

        public function success() {
            return ['template' => 'registersuccess.html.php', 'title' => '등록 성공'];
        }

        public function registerUser() {
            $author = $_POST['author'];

            // 데이터는 처음부터 유효하다고 가정
            $vaild = true;
            $errors = [];

            // 하지만 항목이 빈 값이면 $vaild에 false 할당
            if (empty($author['name'])) {
                $vaild = false;
                $errors[] = '이름을 입력해야 합니다.';
            }

            if (empty($author['email'])) {
                $vaild = false;
                $errors[] = '이메일을 입력해야 합니다.';
            } else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
                $vaild = false;
                $errors[] = '유효하지 않은 이메일 주소입니다.';
            } else {
                // 이메일 주소가 빈 값이 아니고 유효하다면,
                // 이메일 주소를 소문자로 변환
                $author['email'] = strtolower($author['email']);

                // $author['email']을 소문자로 검색
                if (count($this -> authorsTable -> find('email', $author['email'])) > 0) {
                    $vaild = false;
                    $errors[] = '이미 가입된 이메일 주소입니다.';
                }
            }

            if (empty($author['password'])) {
                $vaild = false;
                $errors[] = '패스워드를 입력해야 합니다.';
            }

            // $vaild가 true라면 빈 항목이 없으므로 데이터를 추가할 수 있음
            if ($vaild == true) {
                // 데이터베이스에 저장하기 전에 패스워드를 해시화
                $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);

                // 폼이 전송되면 $author 변수는 소문자 메일과 패스워드 해시값을 포함
                $this -> authorsTable -> save($author);

                header('location: /author/success');
            } else {
                // 데이터가 유효하지 않으면 폼을 다시 출력
                return ['template' => 'register.html.php',
                    'title' => '사용자 등록',
                    'variables' => [
                        'errors' => $errors,
                        'author' => $author
                    ]
                ];
            }
        }

        public function list() {
            $authors = $this -> authorsTable -> findAll();
            
            return ['template' => 'authorlist.html.php',
                'title' => '사용자 목록',
                'variables' => [
                    'authors' => $authors
                ]
            ];
        }

        public function permissions() {
            $author = $this -> authorsTable -> findById($_GET['id']);

            $reflected = new \ReflectionClass('\Ijdb\Entity\Author');
            $constants = $reflected -> getConstants();

            return ['template' => 'permissions.html.php',
                'title' => '권한 수정',
                'variables' => [
                    'author' => $author,
                    'permissions' => $constants
                ]
            ];
        }

        public function savePermissions() {
            $author = [
                'id' => $_GET['id'],
                'permissions' => array_sum($_POST['permissions'] ?? [])
            ];

            $this -> authorsTable -> save($author);

            header('location: /author/list');
        }
    }