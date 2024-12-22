<?php
require 'config/database.php';
// get signup data from signup page. if button submit is clicked
if(isset($_POST['submit'])){    
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatart = $_FILES['avatar'];
    // validation input
    if(!$firstname){
        $_SESSION['signup'] = 'Please enter your first name';
    }elseif(!$lastname){
        $_SESSION['signup'] = 'Please enter your last name';
    }elseif(!$username){
        $_SESSION['signup'] = 'Please enter your user name';
    }elseif(!$email){
        $_SESSION['signup'] = 'Please enter a valid email';
    }elseif(!$createpassword){
        $_SESSION['signup'] = 'Please enter your password';
    }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = 'Password should be at least 8 characters';
    }elseif(!$avatart['name']){
        $_SESSION['signup'] = 'Please add avatar';
    }else{
        // check if password match
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = 'Password do not match';
        }else{
            // hash password
            $hash_password = password_hash($createpassword, PASSWORD_DEFAULT);
            // check if email or username is already in use
            $user_check_query = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['signup'] = 'Email or username already in use';
            }else{
                // upload avatar
                // first rename avatar to make it unique
                $time = time(); 
                $avatar_name = $time . $avatart['name'];
                $avatar_tmp_name = $avatart['tmp_name']; // avatar temporary name
                $avatar_destination_path = 'images/' . $avatar_name;
                // before upload make sure it is image
                $allowed_file = ['png','jpg','jpeg']; // allowed file type
                $extension = explode('.', $avatar_name);//get image extension
                $extension = end($extension); // get last element of array
                if(in_array($extension, $allowed_file)){
                    // make sure image size is not too large (1mb+)
                    if($avatart['size'] < 1000000){
                        // upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup'] = 'File size too large. should less than 1MB';
                    }
                }else{
                    $_SESSION['signup'] = 'File should be png, jpg or jpeg';
                }
            }
        }
    }
    // redirect back to signup page if there is error
    if(isset($_SESSION['signup'])){
        // pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }else{
        // insert into database
        $insert_user_query ="INSERT INTO users (firstname, lastname, username, email, password, avatar,is_admin) 
        VALUES('$firstname', '$lastname', '$username', '$email', '$hash_password', '$avatar_name',0)";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            $_SESSION['signup-success'] = "Account Register successfully. Please Login";
            header('location: ' . ROOT_URL . 'signin.php');
        }
    }
}else{
    // if button submit is not clicked, back to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
?>