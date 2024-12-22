<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
$current_user_id = $_SESSION['user_id'];
// fetch all post from database
$post_fetch_query = "SELECT posts.id, posts.title, categories.title AS category_title
FROM posts JOIN categories ON posts.category_id = categories.id 
WHERE posts.author_id = $current_user_id
ORDER BY posts.id DESC";

$post_fetch_result = mysqli_query($connection, $post_fetch_query);
?>
    
    <!-- dashboard start -->
    <section class="dashboard">
        <?php if(isset($_SESSION['add-post-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['add-post-success']; 
                            unset($_SESSION['add-post-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['edit-post-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['edit-post-success']; 
                            unset($_SESSION['edit-post-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-post'])) :?>
                <div class="container message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['delete-post']; 
                            unset($_SESSION['delete-post']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-post-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['delete-post-success']; 
                            unset($_SESSION['delete-post-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <div class="container dashboard-container">
            <aside>
                <ul>
                    <li>
                        <a href="addPost.php">
                            <i class="fas fa-plus-square"></i>
                            <h5>Add Post</h5>
                        </a>
                    </li>
                    <li>
                        <a class="active" href="<?= ROOT_URL?>/admin/index.php">
                            <i class="fa-solid fa-pen"></i>
                            <h5>Manage Post</h5>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['user_is_admin'])) :?>
                    <li>
                        <a href="addUser.php">
                            <i class="fa-solid fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user.php">
                            <i class="fa-solid fa-user"></i>
                            <h5>Manage User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="addCategory.php">
                            <i class="fa-solid fa-folder-plus"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-category.php">
                            <i class="fa-solid fa-list"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </aside>
            <main>
                <h2>Manage Post</h2>
                <?php if(mysqli_num_rows($post_fetch_result) > 0) :?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($post = mysqli_fetch_assoc($post_fetch_result)) :?>
                        <tr>
                            <td class="table-title"><?= $post['title'] ?></td>
                            <td><?= $post['category_title'] ?></td>
                            <td><a href="<?= ROOT_URL?>admin/editPost.php?id=<?=$post['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL?>admin/delete-post-logic.php?id=<?=$post['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                    <?php endwhile;?>
                    </tbody>
                </table>
                <?php else :?>
                    <p>No post found</p>
                <?php endif;?>
            </main>
        </div>
    </section>
    <!-- dashboard end -->

<!-- get Footer from admin user partials folder -->
<?php include 'partials/footer.php';?>