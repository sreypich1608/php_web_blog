<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
// fetch all category from database
$query = "SELECT * FROM categories ORDER BY title";
$fetch_category_result = mysqli_query($connection, $query);
?>
    
    <!-- dashboard start -->
    <section class="dashboard">
        <?php if(isset($_SESSION['add-category-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['add-category-success']; 
                            unset($_SESSION['add-category-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['edit-category-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['edit-category-success']; 
                            unset($_SESSION['edit-category-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-category'])) : //failed to delete category ?>
                <div class="container message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['delete-category']; 
                            unset($_SESSION['delete-category']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-category-success'])) :?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['delete-category-success']; 
                            unset($_SESSION['delete-category-success']);
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
                        <a href="<?= ROOT_URL?>/admin/index.php">
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
                        <a class="active" href="manage-category.php">
                            <i class="fa-solid fa-list"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                    <?php endif;?>
                </ul>
            </aside>
            <main>
                <h2>Manage Category</h2>
                <?php if(mysqli_num_rows($fetch_category_result) >0 ):?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($category = mysqli_fetch_assoc($fetch_category_result)) :?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?= ROOT_URL?>admin/editCategory.php?id=<?=$category['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL?>admin/delete-category-logic.php?id=<?=$category['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
                <?php else :?>
                    <div class="container message-alert message-alert-danger">  
                        <p>No category found</p>
                    </div>
                <?php endif;?>
            </main>
        </div>
    </section>
    <!-- dashboard end -->

<!-- get Footer from admin user partials folder -->
<?php include 'partials/footer.php';?>