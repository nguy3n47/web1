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
        $data = null;
        if (isset($_FILES['postImage'])) {
          $fileTemp = $_FILES['postImage']['tmp_name'];
          if (!empty($fileTemp)) {
              $data = file_get_contents($fileTemp);
          }
        }
        $len = strlen($content);
        if ($len > 1024) {
          $success = false;
        } else {
          createPost($currentUser['id'], $content, $data);
          header('Location: index.php');
          exit();
        }
      }
?>

<?php include 'header.php'; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <textarea class="form-control" id="content" name="content" rows="1"
            placeholder="What's on your mind?"></textarea>
    </div>
    <div class="form-group">
        <img style="margin-bottom: 10px;object-fit: cover;" id="output" />
        <label for=""></label>
        <input type="file" class="form-control-file" id="postImage" name="postImage" accept="image/*"
            onchange="loadFile(event)">
        <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
        </script>
    </div>
    <button type="submit" class="btn btn-primary">Post</button>
</form>

<?php include 'footer.php'; ?>