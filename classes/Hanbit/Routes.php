<?php
    namespace Hanbit;

    use \Hanbit\Authentication;

    interface Routes {
        public function getRoutes(): array;
        public function getAuthentication(): Authentication;
    }