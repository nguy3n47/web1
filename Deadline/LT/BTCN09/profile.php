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
          if (!empty($fileTemp)) {
            $avatarImage = file_get_contents($fileTemp);
            $currentUser['hasAvatar'] = 1;
            $currentUser['avatarImage'] = $avatarImage;
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
    <?php if($currentUser['hasAvatar'] == 0){
       echo '<img src="./uploads/avatars/profile.jpg">';
    }
      else{
        echo '<img style="width: 360px;height: 360px;object-fit: cover;" src="data:image/jpeg;base64,' . base64_encode($currentUser['avatarImage']) . '"/>';
    }
    ?>
    <div class="form-group">
        <label for="avatar"></label>
        <input type="file" class="form-control-file" id="avatar" name="avatar">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php include 'footer.php'; ?>