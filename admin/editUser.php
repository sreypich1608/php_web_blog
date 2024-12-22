<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
if(isset($_GET['id'])){
    $user_id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $fetch_user_query = "SELECT * FROM users WHERE id = $user_id";
    $fecht_user_result = mysqli_query($connection,$fetch_user_query);
    $user = mysqli_fetch_assoc($fecht_user_result);
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $userrole = $user['is_admin'];
}else{
    header('location:'. ROOT_URL .'admin/manage-user.php');
    die();
}
?>
    
    <!-- sing up start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Edit User</h2>
            <?php if(isset($_SESSION['edit-user'])) :?>
                <div class="container message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['edit-user']; 
                            unset($_SESSION['edit-user']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/edit-user-logic.php?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $user_id?>">
                <input name="firstname" value="<?= $firstname?>" type="text" placeholder="First Name">
                <input name="lastname" value="<?= $lastname?>" type="text" placeholder="Last Name">
                <select name="userrole" id="userrole">
                    <option <?= $userrole =="0" ? 'selected':'' ?> value="0">Author</option>
                    <option <?= $userrole =="1" ? 'selected':'' ?> value="1">Admin</option>
                </select>
                <button name="submit" class="btn" type="submit">Update User</button>
            </form>
        </div>
    </section>
    <!-- sing up end -->

<!-- get Footer from admin user partials folder -->
<?php include 'partials/footer.php';?>