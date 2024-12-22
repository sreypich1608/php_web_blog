<?php
require 'config/database.php';
// check if button submit is clicked
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // fetch user from database. so we get avatar name to delete it in image folder
    $fetch_user_query = "SELECT * FROM users WHERE id = $id LIMIT 1";
    $fetch_user_result = mysqli_query($connection, $fetch_user_query);
    $user = mysqli_fetch_assoc($fetch_user_result);
    // make sure we get only one user from database
    if(mysqli_num_rows($fetch_user_result) == 1){
        // delete user avatar from image folder
        $avatar_name = $user['avatar'];
        $avatar_path = '../images/' . $avatar_name;
        if($avatar_path){
            unlink($avatar_path);
        }
        // fetch all thumnail that this user post then delete from server
        $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
        $thumbnail_result = mysqli_query($connection, $thumbnail_query);
        if(mysqli_num_rows($thumbnail_result)>0){
            while($thumnail = mysqli_fetch_assoc($thumbnail_result)){
                $thumnail_path = '../images/' . $thumnail['thumbnail'];
                if($thumnail_path){
                    unlink($thumnail_path);
                }
            }
        }

        // delete user from database
        $delete_user_query = "DELETE FROM users WHERE id = $id";
        $delete_user_result = mysqli_query($connection, $delete_user_query);
        // make sure user is deleted from database
        if(!mysqli_errno($connection)){
            $_SESSION['delete-user-success'] = "User '{$user['firstname']} {$user['lastname']}' deleted successfully";
            header('location: ' . ROOT_URL . 'admin/manage-user.php');
            die();
        }else{
            $_SESSION['delete-user'] = "Failed to delete '{$user['firstname']} {$user['lastname']}' user";
            header('location: ' . ROOT_URL . 'admin/manage-user.php');
            die();
        }
    }else{
        header('location: ' . ROOT_URL . 'admin/manage-user.php');
        die();
    }
}
?>