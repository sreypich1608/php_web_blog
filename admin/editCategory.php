<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
if(isset($_GET['id'])){
    $query = "SELECT * FROM categories WHERE id = {$_GET['id']}";
    $fetch_category_result = mysqli_query($connection, $query);
    $category= mysqli_fetch_assoc($fetch_category_result);
    $title = $category['title'];
    $description = $category['description'];
}else{
    header('location: ' . ROOT_URL . 'admin/manage-category.php');
    die();
}
?>
    
    <!-- sing up start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Edit Category</h2>
            <?php if(isset($_SESSION['edit-category'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['edit-category']; 
                            unset($_SESSION['edit-category']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/edit-category-logic.php?id=<?= $_GET['id']?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="category_id" value="<?= $_GET['id'] ?>">
                <input value="<?= $title ?>" name="title" type="text" placeholder="Title">
                <textarea value="<?= $description ?>" name="description" id="" rows="4" placeholder="Description"><?= $description ?></textarea>
                <button name="submit" class="btn" type="submit">Update Category</button>
            </form>
        </div>
    </section>
    <!-- sing up end -->

    <!-- get Footer from admin user partials folder -->
    <?php include 'partials/footer.php';?>