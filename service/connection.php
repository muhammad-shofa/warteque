<?php
$connected = mysqli_connect('localhost', 'admingriffith', 'Gr1ff1th@', 'warteque');
if (!$connected) {
    echo 'Connection error: ' . mysqli_connect_error();
}