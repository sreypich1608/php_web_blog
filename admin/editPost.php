<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
// fecth post with post id
if(isset($_GET['id'])){
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $post_fetch_query = "SELECT * FROM posts WHERE id = $post_id";
    $post_fetch_result = mysqli_query($connection,$post_fetch_query);
    $post = mysqli_fetch_assoc($post_fetch_result);
    $title = $post['title'];
    $body = $post['body'];
    $category_id = $post['category_id'];
    $prevous_thumbnail = $post['thumbnail'];
    $is_feature = $post['is_featured'];
    // fetch all category from database
    $fetch_category_query = "SELECT * FROM categories";
    $fetch_category_result = mysqli_query($connection, $fetch_category_query);

}else{
    header('location:'. ROOT_URL .'admin/index.php');
    die();
}
?>
    
    <!-- sing up start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Edit Post</h2>
            <?php if(isset($_SESSION['edit-post'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['edit-post']; 
                            unset($_SESSION['edit-post']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="post_id" value="<?=$post_id?>">
            <input type="hidden" name="previous_thumbnail" value="<?=$prevous_thumbnail?>">
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
                    <label for="thumbnail">Change Photo</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <textarea name="body" id="body" rows="10" placeholder="Body"><?= $body?></textarea>
                <button name="submit" class="btn" type="submit">Add Post</button>
            </form>
        </div>
    </section>
    <!-- sing up end -->

<!-- get Footer from admin user partials folder -->
<?php include 'partials/footer.php';?>