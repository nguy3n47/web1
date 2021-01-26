<?php
require_once 'init.php';

$title = 'Registrer';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $exists = existsUsername($username);
    if ($exists == true) {
        echo '<div class="alert alert-danger" role="alert">' . 'Username already exists' . '</div>';
    } else {
        if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)) {
            echo '<div class="alert alert-danger" role="alert">' . 'Username is not valid' . '</div>';
        } else {
            if ($password != $confirmpassword) {
                echo '<div class="alert alert-danger" role="alert">' . 'Password incorrect' . '</div>';
            } else {
                echo '<div class="alert alert-success" role="alert">' . 'Success' . '</div>';
                $account = array(
                    'username' => $username,
                    'password' => $password,
                );
                $current = file_get_contents('./data');
                if ($current == null){
                    $users = array($account);
                    file_put_contents('./data', serialize($users));
                }
                else{
                    $users = unserialize($current);
                    array_push($users, $account);
                    file_put_contents('./data', serialize($users));
                }
            }
        }
    }
}
?>

<?php include 'header.php'; ?>


<form action="registrer.php" method="POST">
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
