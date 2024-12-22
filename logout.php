<?php
require 'config/constants.php';
// destroy session
session_destroy();
// redirect to home page
header("Location: " . ROOT_URL);
die();
?>