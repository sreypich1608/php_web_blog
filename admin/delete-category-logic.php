<?php
require 'config/database.php';
// check if button delete is clicked
if(isset($_GET['id'])){
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    // update post with category id that we want to delete to uncategorized
    $update_post_query = "UPDATE posts SET category_id = 6 WHERE category_id = $category_id";
    $update_post_result = mysqli_query($connection, $update_post_query);
    if(!mysqli_errno($connection)){
        // delete category from database
        $delete_category_query = "DELETE FROM categories WHERE id = $category_id";
        $delete_category_result = mysqli_query($connection, $delete_category_query);
        if(mysqli_errno($connection)){
            $_SESSION['delete-category'] = "Failed to delete category";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }else{
            $_SESSION['delete-category-success'] = "Category deleted successfully";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }

}else{ 
    header('location:'. ROOT_URL .'admin/manage-category.php');
    die();
}
?>