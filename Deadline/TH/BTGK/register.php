<?php
require_once 'init.php';
unset($_SESSION['us']);
$title = 'Register';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $fullname = $_POST['fullname'];
    $email = strtolower($_POST['email']);
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $exists = findUserByEmail($email);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        echo '<div class="alert alert-danger" role="alert"> Password
        <ul>
            <li>Must be a minimum of 8 characters</li>
            <li>Must contain at least 1 number</li>
            <li>Must contain at least one uppercase character</li>
            <li>Must contain at least one lowercase character</li>
        </ul>
            </div>';
}
else{
if ($exists) {
$error = 'Email already exists';
} else {
if ($password != $confirmpassword) {
$error = 'Password confirm incorrect';
} else
{
echo '<div class="alert alert-success" role="alert">' . 'Success' . '</div>';
$user = CreateUser($fullname, $email, password_hash($password, PASSWORD_DEFAULT));
}
}
}
}
?>

<?php include 'header.php'; ?>
<?php if (isset($error)): ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
</div>
<?php endif; ?>
<form action="register.php" method="POST">
    <div class="form-group">
        <label for="fullname">Fullname</label>
        <input type="text" class="form-control" id="fullname" name="fullname" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="form-control" required>
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