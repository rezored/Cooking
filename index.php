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
            <?php
            $selectPost = Database::instance()->prepare("SELECT COUNT(*) AS count FROM posts ");
            $selectPost->execute();
            $countPost = $selectPost->fetch();

            $paginPost = $countPost['count'];
            $paginPost = ceil($paginPost / 5);

            $publishedPosts = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_status = 'published' ");
            foreach ($publishedPosts as $row) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 50);
                $post_status = $row['post_status'];
                ?>

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
    <ul class="pager">
        <?php
        for ($i = 1; $i <= $paginPost; $i++) {
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
        }
        ?>
    </ul>

    <?php
    include 'includes/footer.php';
    ?>