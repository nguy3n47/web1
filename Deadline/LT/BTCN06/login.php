<?php
    require_once 'init.php';
    unset($_SESSION['us']);
    $title = 'Login';

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = findUserByUsername($username);
        if(!$user){
            $error = 'Not found user';
        } else {
            if(!password_verify($password,$user['password'])){
                $error = 'Password incorrect';
            } else {
                $_SESSION['userId'] = $user['id'];
                header('Location:index.php');
                exit();
            }
        }
    }

    if ($currentUser){
        header('Location:index.php');
        exit();
    }
?>

<?php include 'header.php'; ?>


<?php if (isset($error)): ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
</div>
<?php else: ?>
<form action="login.php" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button button type="submit" class="btn btn-primary">Login</button>
<div>
    <a href="forgottenPassword.php" class="text-primary" style="position: relative;">Forgotten password?</a>
</div>
</form>
<?php endif; ?>


<?php include 'footer.php'; ?>