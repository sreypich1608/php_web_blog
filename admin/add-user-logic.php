<?php
require 'config/database.php';
// get add-user data from add-user page. if button submit is clicked
if(isset($_POST['submit'])){    
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatart = $_FILES['avatar'];
    // validation input
    if(!$firstname){
        $_SESSION['add-user'] = 'Please enter first name';
    }elseif(!$lastname){
        $_SESSION['add-user'] = 'Please enter last name';
    }elseif(!$username){
        $_SESSION['add-user'] = 'Please enter username';
    }elseif($is_admin === '' || ($is_admin != 0 && $is_admin != 1)){
        $_SESSION['add-user'] = 'Please select user role';
    }elseif(!$email){
        $_SESSION['add-user'] = 'Please enter a valid email';
    }elseif(!$createpassword){
        $_SESSION['add-user'] = 'Please enter password';
    }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['add-user'] = 'Password should be at least 8 characters';
    }elseif(!$avatart['name']){
        $_SESSION['add-user'] = 'Please add avatar';
    }else{
        // check if password match
        if($createpassword !== $confirmpassword){
            $_SESSION['add-user'] = 'Password do not match';
        }else{
            // hash password
            $hash_password = password_hash($createpassword, PASSWORD_DEFAULT);
            // check if email or username is already in use
            $user_check_query = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
            $user_check_result = mysqli_query($connection, $user_check_query);
            if(mysqli_num_rows($user_check_result) > 0){
                $_SESSION['add-user'] = 'Email or username already in use';
            }else{
                // upload avatar
                // first rename avatar to make it unique
                $time = time(); 
                $avatar_name = $time . $avatart['name'];
                $avatar_tmp_name = $avatart['tmp_name']; // avatar temporary name
                $avatar_destination_path = '../images/' . $avatar_name;
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
                        $_SESSION['add-user'] = 'File size too large. should less than 1MB';
                    }
                }else{
                    $_SESSION['add-user'] = 'File should be png, jpg or jpeg';
                }
            }
        }
    }
    // redirect back to add-user page if there is error
    if(isset($_SESSION['add-user'])){
        // pass form data back to add-user page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/addUser.php');
        die();
    }else{
        // insert into database
        $insert_user_query ="INSERT INTO users (firstname, lastname, username, email, password, avatar,is_admin) 
        VALUES('$firstname', '$lastname', '$username', '$email', '$hash_password', '$avatar_name', $is_admin)";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        if(!mysqli_errno($connection)){
            $_SESSION['add-user-success'] = "New User $firstname $lastname created successfully.";
            header('location: ' . ROOT_URL . 'admin/manage-user.php');
        }
    }
}else{
    // if button submit is not clicked, back to add-user page
    header('location: ' . ROOT_URL . 'admin/addUser.php');
    die();
}
?>