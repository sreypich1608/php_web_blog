<?php
require 'config/database.php';
// check if button submit is clicked
if(isset($_POST['submit'])){
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!$title){
        $_SESSION['add-category'] = 'Please enter title';
    }elseif(!$description){
        $_SESSION['add-category'] = 'Please enter description';
    }
    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/addCategory.php');
        die();
    }else{
        // insert into database
        $insert_category_query= "INSERT INTO categories(title,description) values('$title','$description')";
        $insert_category_result = mysqli_query($connection, $insert_category_query);
        if(mysqli_errno($connection)){
            $_SESSION['add-category'] = "Failed to add category";
            header('location: ' . ROOT_URL . 'admin/addCategory.php');
            die();
        }else{
            $_SESSION['add-category-success'] = "Category added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-category.php');
            die();
        }
    }
}else{
    header('location: ' . ROOT_URL . 'admin/addCategory.php');
    die();
}
?>