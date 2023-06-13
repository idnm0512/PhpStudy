<?php
    $output = '';

    for ($count = 1; $count <= 10; $count++) {
        $output .= $count . ' ';
    }

    // echo __DIR__;

    include __DIR__ . '/../templates/count.html.php';
?>