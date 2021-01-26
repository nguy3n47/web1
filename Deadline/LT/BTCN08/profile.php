<?php
    require_once 'init.php';
    $title = 'Profile';
    if (!$currentUser) {
        header('Location: index.php');
        exit();
      }
      
      $fullname = $currentUser['fullname'];
      $email = $currentUser['email'];
      $phone = $currentUser['phone'];

      if (isset($_POST['fullname'])) {
        if (strlen($_POST['fullname']) > 0) {
          $fullname = $_POST['fullname'];
          $phone = $_POST['phone'];
          $currentUser['fullname'] = $fullname;
          $currentUser['phone'] = $phone;
          updateUser($currentUser);
          $success = true;
        } else {
          $success = false;
        }
      
        if(isset($_FILES['avatar'])) {
          $fileName = $_FILES['avatar']['name'];
          $fileSize = $_FILES['avatar']['size'];
          $fileTemp = $_FILES['avatar']['tmp_name'];
          $fileSave = './uploads/avatars/' . $currentUser['id'] . '.jpg';
          // userid.jpg
          $result = move_uploaded_file($fileTemp, $fileSave);
          if (!$result) {
            //$success = false;
          } else {
            $newImage = resizeImage($fileSave, 480, 480);
            imagejpeg($newImage, $fileSave);
            $currentUser['hasAvatar'] = 1;
            updateUser($currentUser);
          }
        }
      }
?>

<?php include 'header.php'; ?>
<?php if ($success): ?>
<div class="alert alert-success" role="alert">
    Update Success
</div>
<?php endif; ?>
<form method="POST" action="profile.php" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fullname">Fullname</label>
    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullname ?>">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
  </div>
  <div class="form-group">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone ?>">
  </div>
  <img src="./uploads/avatars/<?php if($currentUser['hasAvatar'] == 0) echo 'profile'; else echo $currentUser['id']; ?>.jpg">
  <div class="form-group">
    <label for="avatar">Avatar</label>
    <input type="file" class="form-control-file" id="avatar" name="avatar">
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php include 'footer.php'; ?>