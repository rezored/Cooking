<?php
include 'deletemsg.php';
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'publish' :
                $publishPost = Database::instance()->prepare("UPDATE posts SET post_status = 'published' WHERE post_id = :checkbox ");
                $publishPost->bindParam(":checkbox", $checkBoxValue);
                $publishPost->execute();
                break;
            case 'draft':
                $draftPost = Database::instance()->prepare("UPDATE posts SET post_status = 'draft' WHERE post_id = :checkbox ");
                $draftPost->bindParam(":checkbox", $checkBoxValue);
                $draftPost->execute();
                break;
            case 'delete' :
                $deletePost = Database::instance()->prepare("DELETE FROM posts WHERE post_id = :checkbox ");
                $deletePost->bindParam(":checkbox", $checkBoxValue);
                $deletePost->execute();
                break;
        }
    }
}
if (isset($_GET['delete'])) {
    $delete_post_id = $_GET['delete'];
    $deletePost = Database::instance()->prepare("DELETE FROM posts WHERE post_id = :delete_id ");
    $deletePost->bindParam(":delete_id", $delete_post_id);
    $deletePost->execute();
    header("Location: posts.php");
}
if (isset($_GET['publish'])) {
    $publish_post_id = $_GET['publish'];
    $publishPost = Database::instance()->prepare("UPDATE posts SET post_status = 'published' WHERE post_id = :publish_id ");
    $publishPost->bindParam(":publish_id", $publish_post_id);
    $publishPost->execute();
    header("Location: posts.php");
}
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Option</option>
                <option value="publish">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Comment count</th>
                <th>Date</th>
                <th colspan="3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $selectPost = Database::instance()->fetchAssoc("SELECT * FROM posts ORDER BY post_id DESC");
            foreach ($selectPost as $row) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_cat_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_content = $row['post_content'];
                $post_comment_count = $row['post_comment_count'];
                $post_date = $row['post_date'];
                echo "<tr>";
                ?>
            <td><input class="checkBoxes" id="selectAllBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>
                <?php
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_author}</td>";
                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
                $selectCat = Database::instance()->fetchAssoc("SELECT * FROM categories WHERE cat_id=$post_cat_id");
                foreach ($selectCat as $row) {
                    $post_category = $row['cat_title'];
                }
                echo "<td>{$post_category}</td>";
                echo "<td>{$post_status}</td>";
                echo "<td><img width='150' align='center' src='../images/$post_image' atl='image'></td>";
                echo "<td>{$post_tags}</td>";
                echo "<td>{$post_content}</td>";
                echo "<td>{$post_comment_count}</td>";
                echo "<td>{$post_date}</td>";
                echo "<td><a href='posts.php?publish={$post_id}'>Publish</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
//                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete ?'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "<td><a rel='{$post_id}' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $(".delete_link").on('click', function () {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            $('.modal_delete_link').attr("href", delete_url);
            $("#myModal").modal('show');
        });
    });
</script>