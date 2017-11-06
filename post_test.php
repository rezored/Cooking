<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'includes/navigation.php';

?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- First Post -->
                <h2>
                    <a href="#">Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">author</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span>date</p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p>content</p>
                <hr>

            <!-- Comments -->
            <?php
            $postSaved = false;
                $comment_author = '';
                $comment_email = '';
                $comment_content = '';
            if (isset($_POST['create_comment'])) {
//                $selected_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                $postSaved = true;
            }
            ?>
            <!-- Comments Form -->
            <div class="well">
                <?php if($postSaved):?>
                <div class="alert alert-success">Post saved successfully.</div>
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