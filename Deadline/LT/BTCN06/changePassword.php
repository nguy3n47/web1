<?php 
    $username = $_POST['username']; 
?>

<?php
require_once 'init.php';

$title = 'Change Password';

if(!isset($_SESSION["us"])){
    $user = findUserByUsername($username);
    if(!$user){
        $error = 'Not found user';
    }
    else{
        $_SESSION['us'] = $username;
    }
}


if (isset($_POST['password']) && isset($_POST['confirmpassword'])) {
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $exists = findUserByUsername($_SESSION["us"]);
    if ($exists) {
        if ($password != $confirmpassword) {
            echo '<div class="alert alert-danger" role="alert">' . 'Password incorrect' . '</div>';
        } else {
            echo '<div class="alert alert-success" role="alert">' . 'Success' . '</div>';
            ChangeUserPassword($_SESSION["us"], password_hash($password, PASSWORD_DEFAULT));
            unset($_SESSION['us']);
        }
    }
}
?>

<?php include 'header.php'; ?>

<?php if (isset($error)): ?>
<div class="alert alert-danger" role="alert">
    <?php echo 'Not found user: '. $username; ?>
</div>
<?php else: ?>
    <div class="content">
    <?php if (isset($username)){ ?>
        <div class="alert alert-success" role="alert">
            Hi <?php echo $username.' 👋';  ?>, You can change your password!
        </div>
        <form action="changePassword.php" method="POST">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required>
        </div>
        <button button type="submit" class="btn btn-primary">Change Password</button>
    </form>
    <?php } ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
    