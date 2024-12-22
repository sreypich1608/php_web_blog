<?php 
require 'config/database.php';
// check if button submit is clicked
if(isset($_POST['submit'])){
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!$title){
        $_SESSION['edit-category'] = 'Please enter title';
    }elseif(!$description){
        $_SESSION['edit-category'] = 'Please enter description';
    }
    if(isset($_SESSION['edit-category'])){
        //$_SESSION['edit-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/editCategory.php?id='.$category_id);
        die();
    }else{
        // insert into database
        $update_category_query= "UPDATE categories SET title = '$title', description = '$description' WHERE id = $category_id";
        $update_category_result = mysqli_query($connection, $update_category_query);
        if(mysqli_errno($connection)){
            $_SESSION['edit-category'] = "Failed to update category";
            header('location: ' . ROOT_URL . 'admin/editCategory.php?id='.$category_id);
            die();
        }else{
            $_SESSION['edit-category-success'] = "Category updated successfully";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }
}else{
    header('location:'. ROOT_URL . 'admin/editCategory.php');
    die();
}
?>