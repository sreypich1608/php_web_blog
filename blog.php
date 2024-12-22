<?php 
include 'partials/header.php';
// fetch latest post from database
$latest_query = "SELECT posts.id as post_id,posts.*, users.* FROM posts left join users on posts.author_id = users.id ORDER BY posts.id DESC LIMIT 8";
$latest_result = mysqli_query($connection, $latest_query);
// fetch all category from database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($connection, $category_query);
?>
    
    <!-- Blog page search bar start -->
    <section class="search-bar">
        <form class="container search-container" action="<?= ROOT_URL?>search.php" method="GET">
            <div>
                <i class="fa-solid fa-magnifying-glass"></i>
                <input name="search" type="search" placeholder="search...">
            </div>
            <button name="submit" type="submit" class="btn">Search</button>
        </form>
    </section>
    <!--Blog page search bar end -->

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

<?php include 'partials/footer.php';?>