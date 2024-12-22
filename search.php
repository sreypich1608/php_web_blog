<?php
include 'partials/header.php';
if(isset($_GET['search']) && isset($_GET['submit'])){
    $search = filter_var($_GET['search'],FILTER_SANITIZE_SPECIAL_CHARS);
    $query = "SELECT posts.id as post_id,posts.*, users.*, categories.title AS category_title
    FROM posts 
    left JOIN users ON posts.author_id = users.id 
    left JOIN categories ON posts.category_id = categories.id 
    where posts.title LIKE '%$search%' 
    ORDER BY date_time DESC";
    $post_search = mysqli_query($connection,$query);
}else{
    header('location:'.ROOT_URL.'blog.php');
    die();
}
// fetch all category from database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($connection, $category_query);
?>

<?php if(mysqli_num_rows($post_search) > 0) :?>
<!--Post start -->
<section class="post-section" style="margin-top: 8rem;">
        <div class="post-container container">
        <?php while($post = mysqli_fetch_assoc($post_search)):?>
            <article class="post">
                <div class="post-thumb">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                </div>
                <div class="post-info">
                <?php 
                    $cat_query = "SELECT * FROM categories WHERE id = {$post['category_id']}";  
                    $cat_result = mysqli_query($connection, $cat_query);
                    $cat = mysqli_fetch_assoc($cat_result);
                    $category_title = $cat['title'];
                ?>
                    <a href="<?= ROOT_URL?>category.php?id=<?= $post['category_id']?>" class="category-btn"><?= $category_title?></a>
                    <h3 class="post-title"><a href="<?= ROOT_URL?>post.php?id=<?= $post['post_id']?>"><?= $post['title']?></a></h3>
                    <p class="post-body">
                        <?= $post['body'] ?>
                    </p>
                    <div class="post-profile">
                        <div class="post-profile-img">
                            <img src="./images/<?= $post['avatar']?>" alt="">
                        </div>
                        <div class="post-profile-info">
                            <h5>By: <?= $post['firstname']?> <?= $post['lastname']?></h5>
                            <small><?= date('M d, Y - H:i', strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile;?>
            
        </div>
    </section>
    <!--Post end -->
    <?php else:?>
    <div class="alert-message alert-message-error">
        <p>No post found for this search</p>
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

<?php include 'partials/footer.php';?>