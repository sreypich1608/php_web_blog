<!-- get Header from Admin partials folder -->
<?php 
include 'partials/header.php';
// get add-user data from add-user-logic. if there is error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
$userrole = $_SESSION['add-user-data']['userrole'] ?? null;
unset($_SESSION['add-user-data']); // delete session after use
?>
    
    <!-- sing up start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Add User</h2>
            <?php if(isset($_SESSION['add-user'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['add-user']; 
                            unset($_SESSION['add-user']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>admin/add-user-logic.php" method="POST" enctype="multipart/form-data">
            <input name="firstname" value="<?= $firstname?>" type="text" placeholder="First Name">
                <input name="lastname" value="<?= $lastname?>" type="text" placeholder="Last Name">
                <input name="username" value="<?= $username?>" type="text" placeholder="User Name">
                <input name="email" value="<?= $email?>" type="email" placeholder="Email">
                <input name="createpassword" value="<?= $createpassword?>" type="password" placeholder="Password">
                <input name="confirmpassword" value="<?= $confirmpassword?>" type="password" placeholder="Password">
                <select name="userrole" id="userrole">
                    <option <?= $userrole =="0" ? 'selected':'' ?> value="0">Author</option>
                    <option <?= $userrole =="1" ? 'selected':'' ?> value="1">Admin</option>
                </select>
                <div class="form-control">
                    <label checked for="avatar">Add Profile Image</label>
                    <input type="file" name="avatar" id="avatar">
                </div>
                <button name="submit" class="btn" type="submit">Add User</button>
            </form>
        </div>
    </section>
    <!-- sing up end -->

    <!-- get Footer from admin user partials folder -->
    <?php include 'partials/footer.php';?>