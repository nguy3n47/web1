<?php
require_once 'init.php';
$title = 'Reset Password';
if ($currentUser) {
  header('Location: index.php');
  exit();
}
?>


<?php include 'header.php'; ?>

<?php
$code = NULL;
$email = NULL;
if (isset($_GET['code']) && !empty($_GET['code'])) {
  $code = $_GET['code'];
  $email = getEmailbyCode($code);
  $check = checkValidCodeResetPassword($code);
  if (!$check) {
    header('Location: activate-reset-password.php');
    exit();
  }
} else {
  header('Location: activate-reset-password.php');
  exit();
}
?>

<div class="content">
    <?php if (!(isset($_POST['newPassword']) || isset($_POST['confirmnewPassword']))) : ?>
    <div class="alert alert-success" role="alert">
        Hi <?php echo $email.' 👋';  ?>, You can reset your password!
    </div>
    <form action="reset-password.php?code=<?php echo $code ?>" method="POST">
        <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" name="newPassword" id="newPassword" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirmnewPassword">Confirm Password</label>
            <input type="password" name="confirmnewPassword" id="confirmnewPassword" class="form-control" required>
        </div>
        <button button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
    <?php else : ?>
    <?php
    // fetch from data
    $newPassword = $_POST['newPassword'];
    $confirmnewPassword = $_POST['confirmnewPassword'];

    $success = false;

    // check fields
    $errorPattern = "<div class='alert alert-danger' role='alert alert-dismissible fade show'>";
    $error = "";

    if (empty($newPassword) || empty($confirmnewPassword)) {
      $error .= $errorPattern . "Bạn phải nhập đủ dữ liệu!</div>";
    } else {
      if ($newPassword == $confirmnewPassword) {
        $success = resetPassword($code, $newPassword);
      } else {
        $error .= $errorPattern . "Mật khẩu nhập lại không trùng khớp!</div>";
      }
    }

    if ($success) {
      header('Location: login.php');
      exit();
    } else {
      $error .= $errorPattern . "Reset mật khẩu thất bại!</div>";
    }

    if (!empty($error)) {
      echo $error;
    }
    ?>
    <a href="./reset-password.php?code=<?php echo $code ?>" class="btn btn-light">Thử lại</a>
</div>
<?php endif; ?>
</div>

<?php include 'footer.php'; ?>