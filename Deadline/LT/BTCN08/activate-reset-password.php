<?php
require_once 'init.php';
$title = 'Enter Security Code';
if ($currentUser) {
  header('Location: index.php');
  exit();
}
?>

<?php include 'header.php' ?>

<?php if (!(isset($_GET['code']))) : ?>
<form action="activate-reset-password.php" method="GET">
    <div class="form-group">
        <label for="code">Please check your emails for a message with your code. Your code is 6 digits long.</label>
        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" required>
    </div>
    <button type="submit" class="btn btn-primary">Confirm</button>
</form>
<?php else : ?>
<?php
    // fetch from data
    $code = $_GET['code'];

    $success = checkValidCodeResetPassword($code);

    if(empty($code)){
      $success = false;
    }

    // check fields
    $errorPattern = "<div class='alert alert-danger' role='alert alert-dismissible fade show'>";
    $error = "";

    if ($success) {
      header("Location: reset-password.php?code=$code");
      exit();
    } else {
      $error .= $errorPattern . "The number that you've entered doesn't match your code. Please try again.</div>";
    }

    if (!empty($error)) {
      echo $error;
    }
    ?>
<a href="./activate-reset-password.php" class="btn btn-light">Retry</a>
<?php endif; ?>

<?php include 'footer.php' ?>