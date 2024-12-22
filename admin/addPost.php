<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
// fetch all category from database
$fetch_category_query = "SELECT * FROM categories";
$fetch_category_result = mysqli_query($connection, $fetch_category_query);
// get error data from add-post-logic. if there is error
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;
$thumnail = $_SESSION['add-post-data']['thumnail'] ?? null;
$category_id = $_SESSION['add-post-data']['category_id'] ?? null;
$is_feature = $_SESSION['add-post-data']['is-feature'] ?? null;
unset($_SESSION['add-post-data']);
?>
    
    <!-- add Post start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Add Post</h2>
            <?php if(isset($_SESSION['add-post'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['add-post']; 
                            unset($_SESSION['add-post']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
                <input value="<?=$title?>" name="title" type="text" placeholder="Title">
                <select name="category_id" id="">
                    <?php while($category = mysqli_fetch_assoc($fetch_category_result)) :?>
                    <option <?= $category_id == $category['id'] ? 'selected' : ''?> value="<?=$category['id']?>"><?=$category['title']?></option>
                    <?php endwhile; ?>
                </select>
                <?php if(isset($_SESSION['user_is_admin'])) :?>
                <div class="form-control inline">
                    <input <?= $is_feature == 1 ? 'checked':''?> value="1" class="check" type="checkbox" name="is-feature" id="is-feature">
                    <label for="is-feature">Feature</label>
                </div>
                <?php endif;?>
                <div class="form-control">
                    <label for="thumbnail">Add Photo</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <textarea name="body" id="body" rows="10" placeholder="Body"><?= $body?></textarea>
                <button name="submit" class="btn" type="submit">Add Post</button>
            </form>
        </div>
    </section>
    <!-- add Post end -->

    <!-- get Footer from admin user partials folder -->
    <?php include 'partials/footer.php';?>