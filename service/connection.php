<?php
$connected = mysqli_connect('localhost', 'root', '', 'warteque');
if (!$connected) {
    echo 'Connection error: ' . mysqli_connect_error();
}