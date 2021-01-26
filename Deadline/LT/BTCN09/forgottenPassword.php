<?php
    require_once 'init.php';

    $title = 'Forgotten password?';

?>

<?php include 'header.php'; ?>
<?php if (!(isset($_POST['email']))) : ?>
<form action="forgottenPassword.php" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="form-control" required>
    </div>
    <button button type="submit" class="btn btn-primary">Send</button>
</form>

<?php else : ?>
<?php
    $email = $_POST['email'];

    $user = findUserByEmail($email);

    $errorPattern = "<div class='alert alert-danger' role='alert alert-dismissible fade show'>";
    $error = "";

    if ($user) {
        sendCodeResetPassword($user);
    } else {
      $error .= $errorPattern . "Email does not exist!</div>";
    }
    ?>
<?php if (!empty($error)) : ?>
<?php echo $error; ?>
<a href="./forgottenPassword.php" class="btn btn-light">Retry</a>
<?php else : ?>
<div class="alert alert-success">Please check your email for a message with your code to enable password reset!</div>
<a href="./activate-reset-password.php" class="btn btn-primary">Enter Code</a>
<?php endif; ?>
<?php endif; ?>

<?php include 'footer.php'; ?>