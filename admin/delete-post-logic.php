<?php
require 'config/database.php';
if (isset($_GET['id'])) {
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $fetch_post_query = "SELECT * FROM posts WHERE id = $post_id";
    $fetch_post_result = mysqli_query($connection, $fetch_post_query);
    // make sure we get only one record
    if(mysqli_num_rows($fetch_post_result) == 1){
        $post = mysqli_fetch_assoc($fetch_post_result);
        $thumnail_name = $post['thumbnail'];
        // delete thumnail from server
        $destination_path = '../images/' . $thumnail_name;
        if ($destination_path) {
            unlink($destination_path);
        }
        // delete post from database
        $delete_post_query = "DELETE FROM posts WHERE id = $post_id";
        $delete_post_result = mysqli_query($connection, $delete_post_query);
        if (mysqli_errno($connection)) {
            $_SESSION['delete-post'] = "Failed to delete post";
        } else {
            $_SESSION['delete-post-success'] = "Post Deleted Successfully";
        }
        header('location: ' . ROOT_URL . 'admin/index.php');
        exit();
    }else{
        header('location: ' . ROOT_URL . 'admin/index.php');
        die();
    }
    
}
?>