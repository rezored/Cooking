<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = "draft";
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($post_image_temp, "../images/$post_image");
    $createPost = Database::instance()->prepare("INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) "
            . "VALUES (:post_category_id,:post_titl,:post_author,now(),:post_image,:post_content',:post_tags,:post_status)");
    $createPost->bindParam(":post_category_id", $post_category_id);
    $createPost->bindParam(":post_title", $post_title);
    $createPost->bindParam(":post_author", $post_author);
    $createPost->bindParam(":post_image", $post_image);
    $createPost->bindParam(":post_content", $post_content);
    $createPost->bindParam(":post_tags", $post_tags);
    $createPost->bindParam(":post_status", $post_status);
    $createPost->execute();
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post title</label>
        <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
        <select name="post_category_id" id="" class="form-control">
            <?php
            $selectCat = Database::instance()->fetchAssoc("SELECT * FROM categories");
            foreach ($selectCat as $row) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post Contents</label>
        <textarea class="form-control" name="post_content" id="" cols="3" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>