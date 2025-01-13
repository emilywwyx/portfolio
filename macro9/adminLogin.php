<?php
$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'pikachu' && $password === 'pokemon') {
    echo 'success';
} else {
    echo 'failure';
}
?>