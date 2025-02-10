<?php
$connection = mysqli_connect('localhost', 'root', '', 'warteque');
if (!$connection) {
    echo 'Connection error: ' . mysqli_connect_error();
}