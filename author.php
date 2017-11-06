<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'includes/navigation.php';
?>
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            $authorName = !empty($_GET['author']) ? $_GET['author'] : null;
            $postAuthor = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_author = :post_author ", [
                "post_author" => $authorName,
            ]);
            foreach ($postAuthor as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 50);
                $post_status = $row['post_status'];
                ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>" ><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>" ><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                <hr>
                <p><?php echo $post_content; ?> ...</p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>" >Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>

                <?php
            }
            ?>
        </div>
        <?php
        include 'includes/sidebar.php';
        ?>
    </div>
    <hr>
    <?php
    include 'includes/footer.php';
    ?>