<?php
ob_start();
global $connection;
if (isset($_GET['p_id'])) {
    $update_comment_id = $_GET['p_id'];
    $updateCom = Database::instance()->fetchAssoc("SELECT * FROM comments WHERE comment_id=:comment_ID ", [
        "comment_ID" => $update_comment_id,
    ]);
    foreach ($updateCom as $row) {
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author = $row['comment_author'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
    }
}
if (isset($_POST['update_comment'])) {
    $update_comment_post_id = $_POST['comment_post_id'];
    $update_comment_author = $_POST['comment_author'];
    $update_comment_email = $_POST['comment_email'];
    $update_comment_content = $_POST['comment_content'];
    $update_comment_status = $_POST['comment_status'];
    $updatePost = Database::instance()->prepare("UPDATE comments SET comment_post_id=:comment_post_id, comment_author=:comment_author, "
            . "comment_email=:comment_email, comment_content=:comment_content, comment_status=:comment_status, comment_date=now() "
            . "WHERE comment_id = :comment_id");
    $updatePost->bindParam(":comment_post_id", $comment_post_id);
    $updatePost->bindParam(":comment_author", $update_comment_author);
    $updatePost->bindParam(":comment_email", $update_comment_email);
    $updatePost->bindParam(":comment_content", $update_comment_content);
    $updatePost->bindParam(":comment_status", $update_comment_status);
    $updatePost->bindParam(":comment_id", $update_comment_id);
    $updatePost->execute();
    header('Location:comments.php');
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="author">Comment Author</label>
        <input type="text" class="form-control" name="comment_author"value="<?php echo $comment_author; ?>">
    </div>
    <div class="form-group">
        <label for="author">Comment Post ID</label>
        <input type="text" class="form-control" name="comment_post_id"value="<?php echo $comment_post_id; ?>">
    </div>
    <div class="form-group">
        <label for="author">Comment email</label>
        <input type="text" class="form-control" name="comment_email"value="<?php echo $comment_email; ?>">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="comment_status" id="" class="form-control">
            <option value="<?php echo $comment_status; ?>"><?php echo $comment_status; ?></option>
            <?php
            if ($comment_status == 'approved') {
                echo "<option value='unapproved'>unapproved</option>";
            } else {
                echo "<option value='approved'>approved</option>";
            }
            ?>
        </select>
    </div>

    <!--    <div class="form-group">
            <label for="post_status">Post Status</label>
            <input type="text" class="form-control" name="comment_status" value="<?php echo $comment_status; ?>">
        </div>-->
    <div class="form-group">
        <label for="post_content">Post Contents</label>
        <textarea class="form-control" name="comment_content" rows="4"><?php
            echo $comment_content;
            ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_comment" value="Update Comment">
    </div>
</form>
