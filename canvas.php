<?php
session_start();
$_SESSION['canvas_domain'] = $_POST['canvas_domain'];
$_SESSION['canvas_token'] = $_POST['canvas_token'];
$_SESSION['canvas_account'] = $_POST['canvas_account'];
header("Location: home.php?#results");
?>