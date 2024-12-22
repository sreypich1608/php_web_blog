<?php
include 'partials/header.php';
if (isset($_GET['id'])) {
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT posts.id as post_id,posts.*, categories.title AS category_title,users.* 
    FROM posts 
    left JOIN categories ON posts.category_id = categories.id 
    left JOIN users ON posts.author_id = users.id 
    WHERE category_id = $category_id";
    $post_category_result = mysqli_query($connection, $query);
}
// fetch all category from database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($connection, $category_query);
?>
<!--category start -->
<section class="category-title">
    <?php
    $cat_query = "SELECT * FROM categories WHERE id = {$category_id}";
    $cat_result = mysqli_query($connection, $cat_query);
    $cat = mysqli_fetch_assoc($cat_result);
    $category_title = $cat['title'];
    ?>
    <h2><?= $category_title?></h2>
</section>
<!--category end -->
<?php if(mysqli_num_rows($post_category_result) > 0) :?>
<!--Post start -->
<section class="post-section">
    <div class="post-container container">
        <?php while ($post_category = mysqli_fetch_assoc($post_category_result)): ?>
            <article class="post">
                <div class="post-thumb">
                    <img src="./images/<?= $post_category['thumbnail'] ?>" alt="">
                </div>
                <div class="post-info">
                    <a href="<?= ROOT_URL?>category.php?id=<?= $post_category['category_id']?>" class="category-btn"><?= $post_category['category_title'] ?></a>
                    <h3 class="post-title"><a href="<?= ROOT_URL?>post.php?id=<?= $post_category['post_id']?>"><?= $post_category['title'] ?></a></h3>
                    <p class="post-body">
                        <?= $post_category['body'] ?>
                    </p>
                    <div class="post-profile">
                        <div class="post-profile-img">
                            <img src="./images/<?= $post_category['avatar'] ?>" alt="">
                        </div>
                        <div class="post-profile-info">
                            <h5>By: <?= $post_category['firstname'] ?> <?= $post_category['lastname'] ?></h5>
                            <small><?= date('M d, Y - H:i', strtotime($post_category['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<!--Post end -->
<?php else:?>
    <div class="alert-message alert-message-error">
        <p>No post found in this category</p>
    </div>
<?php endif;?>

<!--Category start -->
<section class="category">
        <div class="category-container container">
            <?php while($category = mysqli_fetch_assoc($category_result)):?>
            <a href="<?= ROOT_URL?>category.php?id=<?=$category['id']?>" class="category-btn"><?=$category['title']?></a>
            <?php endwhile;?>
        </div>
    </section>
    <!--Category end -->

<?php include 'partials/footer.php'; ?>