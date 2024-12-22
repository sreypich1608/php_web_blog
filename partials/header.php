<?php
require 'config/database.php';

//fecth current user from database
if(isset($_SESSION['user_id'])){
    $id = filter_var($_SESSION['user_id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);// return in assoc array
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- css style link -->
    <link rel="stylesheet" href="<?= ROOT_URL?>css/style.css">
    <!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Nav bar start -->
    <nav>
        <div class="container nav-container">
            <a class="logo" href="<?= ROOT_URL?>index.php"><h3>SP<span>-</span>Blog</h3></a>
            <ul class="nav-link">
                <li><a href="<?= ROOT_URL?>">Home</a></li>
                <li><a href="<?= ROOT_URL?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL?>service.php">Service</a></li>
                <li><a href="<?= ROOT_URL?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user_id'])) :?>
                <li>
                    <div class="nav-profile">
                        <div class="profile-img">
                            <img class="nav-img" src="<?= ROOT_URL . 'images/' . $user['avatar']?>" alt="">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL?>logout.php">Log Out</a></li>
                        </ul>
                    </div>
                </li>
                <?php else :?>
                    <li><a href="<?php ROOT_URL?>signin.php">Sign In</a></li>
                <?php endif; ?>
                
            </ul>
            <button class="phone-button open"><i class="fa-solid fa-bars"></i></button>
            <button class="phone-button close"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </nav>
    <!-- Nav bar end -->