<?php
require_once 'init.php';
unset($_SESSION['us']);
$title = 'Register';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $exists = findUserByUsername($username);
    if ($exists) {
        echo '<div class="alert alert-danger" role="alert">' . 'Username already exists' . '</div>';
    } else {
			if ($password != $confirmpassword) {
                echo '<div class="alert alert-danger" role="alert">' . 'Password incorrect' . '</div>';
            } else 
			{
               echo '<div class="alert alert-success" role="alert">' . 'Success' . '</div>';
               $user = CreateUser($username,password_hash($password, PASSWORD_DEFAULT));
			} 
				
	}
}
?>

<?php include 'header.php'; ?>


<form action="register.php" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="confirmpassword">Confirm Password</label>
        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required>
    </div>
    <button button type="submit" class="btn btn-primary">Register</button>
</form>


<?php include 'footer.php'; ?>