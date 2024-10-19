<?php
session_start();

session_unset(); 
session_destroy();
//takes back to main page after log out
header("Location: index.php");
exit;
?>
