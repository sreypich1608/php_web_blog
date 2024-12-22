<?php
require 'config/constants.php';
// get signup data from signup-logic. if there is error
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
unset($_SESSION['signup-data']); // delete session after use

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- css style link -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- font awsome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- sing up start -->
    <section class="form-section">
        <div class="constainer form-section-container">
            <h2>Sign Up</h2>
            <?php if(isset($_SESSION['signup'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['signup']; 
                            unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            
            <form action="<?= ROOT_URL?>signup-logic.php" method="POST" enctype="multipart/form-data">
                <input name="firstname" value="<?= $firstname?>" type="text" placeholder="First Name">
                <input name="lastname" value="<?= $lastname?>" type="text" placeholder="Last Name">
                <input name="username" value="<?= $username?>" type="text" placeholder="User Name">
                <input name="email" value="<?= $email?>" type="email" placeholder="Email Name">
                <input name="createpassword" value="<?= $createpassword?>" type="password" placeholder="Password">
                <input name="confirmpassword" value="<?= $confirmpassword?>" type="password" placeholder="Password">
                <div class="form-control">
                    <label for="avatar" class="profile-1-img">Upload Profile Image</label>
                    <input name="avatar" type="file" id="upload-img">
                </div>
                <button name="submit" class="btn" type="submit">Sign Up</button>
                <small>Already have an account? <a href="./signin.php">Sign In</a></small>
            </form>
        </div>
    </section>
    <!-- sing up end -->

    
    <!-- custom js link -->
    <script src="./js/main.js"></script>
</body>
</html>