<?php
    require_once 'init.php';
    $title = 'Create Post';

    if (!$currentUser) {
        header('Location: index.php');
        exit();
      }
      
      $success = true;
      
      if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $len = strlen($content);
      
        if ($len == 0 || $len > 1024) {
          $success = false;
        } else {
          createPost($currentUser['id'], $content);
          header('Location: index.php');
          exit();
        }
      }
?>

<?php include 'header.php'; ?>

<form method="POST">
    <div class="form-group">
        <textarea class="form-control" id="content" name="content" rows="7"
            placeholder="What's on your mind?"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Post</button>
</form>

<?php include 'footer.php'; ?>