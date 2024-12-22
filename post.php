<?php 
include 'partials/header.php';
if (isset($_GET['id'])) {
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT posts.*, categories.title AS category_title,users.* 
    FROM posts 
    left JOIN categories ON posts.category_id = categories.id 
    left JOIN users ON posts.author_id = users.id 
    WHERE posts.id = $post_id";
    $post_result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($post_result);
}
?>

    <!--single post start -->
    <section class="single-post">
        <div class="container single-post-container">
            <h2><?= $post['title']?></h2>
            <div class="post-info">
                <a href="<?= ROOT_URL?>category.php?id=<?= $post['category_id']?>" class="category-btn"><?= $post['category_title']?></a>
                <div class="post-profile">
                    <div class="post-profile-img">
                        <img src="./images/<?= $post['avatar'] ?>" alt="">
                    </div>
                    <div class="post-profile-info">
                        <h5 style="color: white;">By: <?= $post['firstname'] ?> <?= $post['lastname'] ?></h5>
                        <small><?= date('M d, Y - H:i', strtotime($post['date_time'])) ?></small>
                    </div>
                </div>
            </div>
            <div class="single-post-thumb">
                <img src="./images/<?= $post['thumbnail'] ?>" alt="">
            </div>
            <p>
                <?= $post['body'] ?>
            </p>
        </div>
    </section>
    <!--single post end -->
<?php include 'partials/footer.php';?>