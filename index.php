<?php
include 'partials/header.php';
// fetch featured post from database
$featured_query = "SELECT posts.id as post_id,posts.*, users.* FROM posts left join users on posts.author_id = users.id WHERE is_featured = 1";
$featured_result = mysqli_query($connection, $featured_query);
$feature_post = mysqli_fetch_assoc($featured_result);
// fetch latest post from database
$latest_query = "SELECT posts.id as post_id,posts.*, users.* FROM posts left join users on posts.author_id = users.id ORDER BY posts.id DESC LIMIT 8";
$latest_result = mysqli_query($connection, $latest_query);
// fetch all category from database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($connection, $category_query);
?>


    <?php if(mysqli_num_rows($featured_result)==1):?>
    <!-- Feature start -->
    <section class="feature">
        <div class="container featured-container">
            <div class="post-thumb">
                <img src="./images/<?= $feature_post['thumbnail'] ?>" alt="">
            </div>
            <div class="post-info">
                <?php 
                    $cat_query = "SELECT * FROM categories WHERE id = {$feature_post['category_id']}";  
                    $cat_result = mysqli_query($connection, $cat_query);
                    $cat = mysqli_fetch_assoc($cat_result);
                    $category_title = $cat['title'];
                ?>
                <a href="<?= ROOT_URL?>category.php?id=<?=$feature_post['category_id']?>" class="category-btn"><?= $category_title?></a>
                <h2 class="post-title">
                    <a href="<?= ROOT_URL?>post.php?id=<?= $feature_post['post_id']?>"><?= $feature_post['title']?></a>
                </h2>
                <p class="post-body">
                    <?= $feature_post['body']?>
                </p>
                <div class="post-profile">
                    <div class="post-profile-img">
                        <img src="./images/<?= $feature_post['avatar']?>" alt="">
                    </div>
                    <div class="post-profile-info">
                        <h5>By: <?= $feature_post['firstname']?> <?= $feature_post['lastname']?></h5>
                        <small><?= date('M d, Y - H:i', strtotime($feature_post['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Feature end -->
    <?php endif; ?>
    <!--Post start -->
    <section class="post-section">
        <div class="post-container container">
            <?php while($post = mysqli_fetch_assoc($latest_result)):?>
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

    <!--Category start -->
    <section class="category">
        <div class="category-container container">
            <?php while($category = mysqli_fetch_assoc($category_result)):?>
            <a href="<?= ROOT_URL?>category.php?id=<?=$category['id']?>" class="category-btn"><?=$category['title']?></a>
            <?php endwhile;?>
        </div>
    </section>
    <!--Category end -->
    
<?php
include 'partials/footer.php';
?>