<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'includes/navigation.php';
$selected_post_id = !empty($_GET['p_id']) ? $_GET['p_id'] : null;
$rowsComments = Database::instance()->fetchAssoc("SELECT * FROM comments WHERE comment_post_id = :comment_post_id AND comment_status = 'approved' ORDER BY comment_id DESC ", [
    "comment_post_id" => $selected_post_id,
        ]);
?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <?php             $selected_post_id = !empty($_GET['p_id']) ? $_GET['p_id'] : null;
            $selectPost = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_id = :post_id ", [
                "post_id" => $selected_post_id,
            ]);
            foreach ($selectPost as $post) {
                $post_title = $post['post_title'];
                $post_author = $post['post_author'];
                $post_date = $post['post_date'];
                $post_image = $post['post_image'];
                $post_content = $post['post_content'];
                ?>
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <hr>
                <?php
            }
            ?>
            <?php
            $postSaved = false;
            if (isset($_POST['create_comment'])) {
                $selected_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                $postSaved = true;
                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $recordCommens = Database::instance()->prepare("INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)"
                            . " VALUES (:post_id, :comment_author, :comment_email, :comment_content, 'unapproved', now() )");
                    $recordCommens->bindParam(":post_id", $selected_post_id);
                    $recordCommens->bindParam(":comment_author", $comment_author);
                    $recordCommens->bindParam(":comment_email", $comment_email);
                    $recordCommens->bindParam(":comment_content", $comment_content);
                    $recordCommens->execute();
                }
            }
            ?>
            <div class="well">
                <?php if ($postSaved): ?>
                    <div class="alert alert-success">Comment successfully submitted.</div>
                <?php endif; ?>
                <h4>Leave a Comment:</h4>
                <form role="form" action="" method="post">
                    <label for="Author" required>Author</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <label for="Email">Email</label>
                    <div class="form-group">
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <label for="Comment">Comment</label>
                    <div class="form-group">
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr>
            <!-- Posted Comments -->
            <?php
            foreach ($rowsComments as $row) {
                $comment_author = $row['comment_author'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date ?></small>
                        </h4>
                        <?php echo $comment_content ?>
                    </div>
                </div>
                <?php
            }
            ?>            
            <!-- Comment -->
        </div>
        <?php
        include 'includes/sidebar.php';
        ?>
    </div>
    <hr>
    <?php
    include 'includes/footer.php';
    ?>