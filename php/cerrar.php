<?php
    session_start();
    if(!empty($_SESSION['usuario'])) {
       session_destroy();
    }
    header('refresh:0; url=../index.php');
?>