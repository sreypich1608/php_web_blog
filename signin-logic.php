<?php
require 'config/database.php';
// check if button submit is clicked
if(isset($_POST['submit'])){
    // get data from form
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!$username_email){
        $_SESSION['signin'] = 'Please enter username or email';
    }else if(!$password){
        $_SESSION['signin'] = 'Please enter password';
    }else{
        // fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE email = '$username_email' OR username = '$username_email'";
        $fecht_user_result = mysqli_query($connection,$fetch_user_query);
        if(mysqli_num_rows($fecht_user_result) == 1){
            // convert the record to assoc array
            $user_data = mysqli_fetch_assoc($fecht_user_result);
            // check if password is correct
            if(password_verify($password, $user_data['password'])){
                // set session for access control
                session_start();
                $_SESSION['user_id'] = $user_data['id'];
                // set session for user admin
                if($user_data['is_admin'] == 1){
                    $_SESSION['user_is_admin'] = true;
                }
                // log to admin
                header('location: ' . ROOT_URL . 'admin/');
                
            }else{
                $_SESSION['signin'] = 'Incorrect password';
            }
        }else{
            $_SESSION['signin'] = 'User not found';
        }
    }
    // if there is any error
    if(isset($_SESSION['signin'])){
        // pass form data back to signin page
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
}else{
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}

?>