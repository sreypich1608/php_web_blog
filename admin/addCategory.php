<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
$title = $_SESSION['add-category-data']['title'] ?? null;	
$description = $_SESSION['add-category-data']['description'] ?? null;
unset($_SESSION['add-category-data']);
?>
    
    <!-- Add Category start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Add Category</h2>
            <?php if(isset($_SESSION['add-category'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['add-category']; 
                            unset($_SESSION['add-category']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/add-category-logic.php" method="POST" enctype="multipart/form-data" >
                <input value="<?= $title ?>" name="title" type="text" placeholder="Title">
                <textarea value="<?= $description ?>" name="description" id="" rows="4" placeholder="Description"><?= $description ?></textarea>
                <button name="submit" class="btn" type="submit">Add Category</button>
            </form>
        </div>
    </section>
    <!-- Add Category end -->

    <!-- get Footer from admin user partials folder -->
    <?php include 'partials/footer.php';?>