<?php
    require_once 'init.php';

    $title = 'Forgotten password?';

?>

<?php include 'header.php'; ?>

<form action="changePassword.php" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>
    </div>
    <button button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php include 'footer.php'; ?>