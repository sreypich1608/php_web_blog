<?php
require 'config/constants.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['sign-data']);
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
            <h2>Sign In</h2>
            <!-- <div class="message-alert message-alert-error">
                <p>This is error message</p>
            </div> -->
            <?php if(isset($_SESSION['signup-success'])) :?>
                <div class="message-alert message-alert-success">
                    <p>
                        <?= $_SESSION['signup-success']; 
                            unset($_SESSION['signup-success']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['signin'])) :?>
                <div class="message-alert message-alert-error">
                    <p>
                        <?= $_SESSION['signin']; 
                            unset($_SESSION['signin']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <form action="<?= ROOT_URL?>signin-logic.php" method="POST" enctype="multipart/form-data">
                <input value="<?= $username_email; ?>" name="username_email" type="text" placeholder="User Name or Email">
                <input value="<?= $password; ?>" name="password" type="password" placeholder="Password">
                <button name="submit" class="btn" type="submit">Sign In</button>
                <small>Don't have an account? Create new here<a href="./signup.php">Sign Up</a></small>
            </form>
        </div>
    </section>
    <!-- sing up end -->

    
    <!-- custom js link -->
    <script src="./js/main.js"></script>
</body>
</html>