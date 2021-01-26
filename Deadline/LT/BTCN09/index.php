<?php
    require_once 'init.php';
    unset($_SESSION['us']);
    $title = 'Home';
    if ($currentUser) {
        $newFeeds = getNewFeedsForUserId($currentUser['id']);
      }
?>

<?php include 'header.php'; ?>

<?php if (isset($currentUser)): ?>
<div class="alert alert-success" role="alert">
    Hi <?php echo $currentUser['fullname'].' 👋';  ?>, Welcome back to the website!
</div>
<?php foreach ($newFeeds as $post) : ?>

<!--- \\\\\\\Post-->
<div class="card gedf-card" style="margin-bottom: 20px;">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <?php if ($post['userHasAvatar']) : ?>
                    <img class="rounded-circle" style="object-fit: cover;" width="64" height="64" class="avatar"
                        src=<?php echo 'data:image/jpeg;base64,'. base64_encode($post['avatarImage']) ?>>
                    <?php else : ?>
                    <img class="rounded-circle" width="64" height="64" class="avatar"
                        src="./uploads/avatars/profile.jpg">
                    <?php endif; ?>
                </div>
                <div class="ml-2">
                    <div class="h5 m-0"><?php echo $post['userFullname'] ?></div>
                    <div class="text-muted h7 mb-2"><i class="fa fa-clock-o"></i><?php echo $post['createdAt'] ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text">
            <?php echo $post['content'] ?>
        </p>
        <?php if ($post['postImage'] != null)
                echo '<img style="object-fit: cover;" width="600" height="600"
                src="data:image/jpeg;base64,' . base64_encode($post['postImage']) . '"/>' ?>
    </div>
    <div class="card-footer">
        <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
        <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
        <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Share</a>
    </div>
</div>
<!-- Post /////-->

<?php endforeach; ?>
<?php else : ?>
<div class="alert alert-secondary" role="alert">
    You are not logged in
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>