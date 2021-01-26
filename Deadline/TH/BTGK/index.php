<?php
    require_once 'init.php';
    unset($_SESSION['us']);
    $title = 'Home';
?>

<?php include 'header.php'; ?>

<?php if (isset($currentUser)): ?>
<div class="alert alert-success" role="alert">
    Hi <?php echo $currentUser['fullname'].' 👋';  ?>, Welcome back to the website!
</div>
<?php else : ?>
<div class="alert alert-secondary" role="alert">
    You are not logged in
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>