<?php
    require_once 'init.php';
    $title = 'Change Password';

    if (!$currentUser) {
        header('Location: index.php');
        exit();
      }
      
      $success = true;
      
      if (isset($_POST['oldPassword'])) {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $newPassword2 = $_POST['newPassword2'];
      
        $oldPasswordOk = password_verify($oldPassword, $currentUser['password']);
        $newPasswordOk = $newPassword == $newPassword2 && strlen($newPassword) >= 8;
      
        $success = $oldPasswordOk && $newPasswordOk;
        
        if ($success) {
            updateUserPassword($currentUser['id'], password_hash($newPassword, PASSWORD_DEFAULT));
            echo '<div class="alert alert-success" role="alert">' . 'Success' . '</div>';
          }
        }
?>

<?php include 'header.php'; ?>

<?php if (!$success) : ?>
<div class="alert alert-danger" role="alert">
    <ul>
        <?php if (!$oldPasswordOk) : ?>
        <li>Old password is incorrect!</li>
        <?php endif; ?>
        <?php if (!$newPasswordOk) : ?>
        <li>The new password should be the same and at least 8 characters!</li>
        <?php endif; ?>
        <?php if ($oldPassword == $newPassword) : ?>
        <li>The new password cannot be the same as the old one</li>
        <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
<form method="POST">
    <div class="form-group">
        <label for="oldPassword">Current</label>
        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
    </div>
    <div class="form-group">
        <label for="newPassword">New</label>
        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
    </div>
    <div class="form-group">
        <label for="newPassword2">Re-type New</label>
        <input type="password" class="form-control" id="newPassword2" name="newPassword2" required>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>

<?php include 'footer.php'; ?>