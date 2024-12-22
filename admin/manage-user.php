<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
// fetch all user from database exept current user
$current_admin_id = $_SESSION['user_id'];
$fetch_user_query = "SELECT * FROM users WHERE NOT id = $current_admin_id";
$fecht_user_result = mysqli_query($connection,$fetch_user_query);

?>
    
    <!-- dashboard start -->
    <section class="dashboard">
        <?php if(isset($_SESSION['add-user-success'])) : // if add user successfully?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['add-user-success']; 
                            unset($_SESSION['add-user-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['edit-user-success'])) : // if edit user successfully?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['edit-user-success']; 
                            unset($_SESSION['edit-user-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-user-success'])) : // if delete user successfully?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['delete-user-success']; 
                            unset($_SESSION['delete-user-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        <?php if(isset($_SESSION['delete-user'])) : // if delete user not successfully?>
                <div class="container message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['delete-user']; 
                            unset($_SESSION['delete-user']);
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
                        <a class="active" href="manage-user.php">
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
                <h2>Manage User</h2>
                <?php if(mysqli_num_rows($fecht_user_result) >0) :?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Admin</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($fecht_user_result)) :?>
                        <tr>
                            <td><?= $user['firstname'] ." ". $user['lastname']?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['is_admin'] == 0 ? 'No' : 'Yes'?></td>
                            <td><a href="<?= ROOT_URL?>admin/editUser.php?id=<?=$user['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?= ROOT_URL?>admin/delete-user.php?id=<?=$user['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
                <?php else :?>
                    <div class="container message-alert message-alert-danger">  
                        <p>No user found</p>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </section>
    <!-- dashboard end -->

    <!-- get Footer from admin user partials folder -->
    <?php include 'partials/footer.php';?>