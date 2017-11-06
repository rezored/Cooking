<?php
ob_start();
global $connection;
if (isset($_GET['p_id'])) {
    $update_post_id = $_GET['p_id'];
    $updatePost = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_id= :post_id ", [
        "post_id" => $update_post_id,
    ]);
    foreach ($updatePost as $row) {
        $post_category = $row['post_category_id'];
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
    }
}
if (isset($_POST['update_post'])) {
    $update_post_title = $_POST['post_title'];
    $update_post_categoty_id = $_POST['post_category'];
    $update_post_author = $_POST['post_author'];
    $update_post_status = $_POST['post_status'];
    $update_post_image = $_FILES['image']['name'];
    $update_post_image_temp = $_FILES['image']['name'];
    $update_post_tags = $_POST['post_tags'];
    $update_post_content = $_POST['post_content'];
    move_uploaded_file($update_post_image_temp, "../images/$update_post_image ");
    if (empty($update_post_image)) {
        $uploadImage = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_id = $update_post_id ", [
            "post_id" => $update_post_id,
        ]);
        foreach ($uploadImage as $row) {
            $update_post_image = $row['post_image'];
        }
    }
    $updatePost = Database::instance()->prepare("UPDATE posts SET post_title=:post_title, post_category_id=:post_category_id, post_image=:post_image, "
            . "post_author=:post_author, post_content=:post_content, post_tags=:post_tags, post_status=:post_status, "
            . "post_date=now() WHERE post_id = :post_id");
    $updatePost->bindParam(":post_id", $update_post_id);
    $updatePost->bindParam(":post_title", $update_post_title);
    $updatePost->bindParam(":post_category_id", $update_post_categoty_id);
    $updatePost->bindParam(":post_image", $update_post_image);
    $updatePost->bindParam(":post_author", $update_post_author);
    $updatePost->bindParam(":post_content", $update_post_content);
    $updatePost->bindParam(":post_tags", $update_post_tags);
    $updatePost->bindParam(":post_status", $update_post_status);
    $updatePost->execute();
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
    </div>
    <div class="form-group">
        <label for="title">Post title</label>
        <input type="text" class="form-control" name="post_title"value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
        <label>Categoriy list</label>
        <select name="post_category" id="" class="form-control">
            <?php
            $selectCat = Database::instance()->fetchAssoc("SELECT * FROM categories");
            foreach ($selectCat as $row ) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="post_author"value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
        <select name="post_status" id="" class="form-control">
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php
            if ($post_status == 'draft') {
                echo "<option value='published'>published</option>";
            } else {
                echo "<option value='draft'>draft</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
        <label for="post_content">Post Contents</label>
        <textarea class="form-control" name="post_content"><?php
            echo $post_content;
            ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
        <?php
        if (isset($_POST['update_post'])) {
            echo "The post was updated. Review it <a href=../post.php?p_id=$post_id>here</a> or go to <a href=./posts.php>all posts</a>.";
        }
        ?>
    </div>
</form>
