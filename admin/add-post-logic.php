<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user_id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $is_feature = filter_var($_POST['is-feature'], FILTER_SANITIZE_NUMBER_INT);
    $thumnail = $_FILES['thumbnail'];
    // if set is_feature to 0
    $is_feature = $is_feature == 1 ? 1 : 0;
    if (!$title) {
        $_SESSION['add-post'] = 'Please enter title';
    } elseif (!$category_id) {
        $_SESSION['add-post'] = 'Please select category';
    } elseif (!$body) {
        $_SESSION['add-post'] = 'Please enter body';
    } elseif (!$thumnail['name']) {
        $_SESSION['add-post'] = 'Please select Image';
    } else {
        // work with image
        $time = time();
        $thumnail_name = $time . $thumnail['name'];
        $thumnail_tmp_name = $thumnail['tmp_name'];
        $thumnail_destination_path = '../images/' . $thumnail_name;
        // make sure file is an image
        $allowed_files = ['jpg', 'png', 'jpeg'];
        $extension = explode('.', $thumnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            if ($thumnail['size'] < 2000000) {
                // move uploaded file to destination path
                move_uploaded_file($thumnail_tmp_name, $thumnail_destination_path);
            } else {
                $_SESSION['add-post'] = 'File size too large. should less than 2MB';
            }
        } else {
            $_SESSION['add-post'] = 'File should be png, jpg or jpeg';
        }
    }
    if (isset($_SESSION['add-post'])) {
        // pass form data back to add-post page if error
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/addPost.php');
        die();
    } else {
        // set is_featured of all post to 0, if this post is featured 1.
        // we design only one featured post
        if ($is_feature == 1) {
            $zero_query = "UPDATE posts SET is_featured = 0";
            $zero_result = mysqli_query($connection, $zero_query);
        }
        // insert post into database
        $query = "INSERT INTO posts(title, body, thumbnail, category_id, author_id, is_featured) VALUES('$title', '$body', '$thumnail_name', $category_id, $author_id, $is_feature)";
        $result = mysqli_query($connection, $query);
        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] = 'Post added successfully';
            header('location: ' . ROOT_URL . 'admin/index.php');
            die();
        } else {
            $_SESSION['add-post'] = 'Could not add post';
            header('location:' . ROOT_URL . 'admin/addPost.php');
            die();
        }
    }
    var_dump($thumnail);
} else {
    header('location: ' . ROOT_URL . 'admin/addPost.php');
    die();
}
