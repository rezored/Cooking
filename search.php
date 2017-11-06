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
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];
                $searchWeb = Database::instance()->fetchAssoc("SELECT * FROM posts WHERE post_tags LIKE '%$search%' ");
                $count = $searchWeb->fetch();
                if ($count == 0) {
                    echo "<h1>NO result</h1>";
                } else {
                    while ($row = mysqli_fetch_assoc($search_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        ?>
                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>

                        <?php                 
                        }
                        }
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