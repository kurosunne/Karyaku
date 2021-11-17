<?php
    session_start();
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "karyaku_db";

    $koneksi = mysqli_connect($host,$username,$password,$dbname);
?>