<?php
require 'config/database.php';
if(isset($_POST['submit'])){
    $user_id = filter_var($_POST['user_id'],FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    if(!$firstname){
        $_SESSION['edit-user'] = 'Please enter first name';
    }elseif(!$lastname){
        $_SESSION['edit-user'] = 'Please enter last name';
    }elseif($is_admin === '' || ($is_admin != 0 && $is_admin != 1)){
        $_SESSION['edit-user'] = 'Please select user role';
    }else{
        $update_user_query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE id = $user_id LIMIT 1";
        $update_user_result = mysqli_query($connection, $update_user_query);
        if(!mysqli_errno($connection)){
            $_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully.";
            header('location: ' . ROOT_URL . 'admin/manage-user.php');
        }else{
            $_SESSION['edit-user'] = 'Failed to update user';
        }
    }
    if(isset($_SESSION['edit-user'])){
        //$_SESSION['edit-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/editUser.php?id=' . $user_id);
        die();
    }
}else{
    header('location:'.ROOT_URL.'admin/manage-user.php');
    die();
}
?>