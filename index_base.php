<?php
require_once 'includes/db.php';
require_once 'includes/header.php';
require_once 'includes/navigation.php';
?>



<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <!--<div class="col-md-8">-->
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
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="images/<?php echo $post_image; ?>" alt="">
                            <div class="caption">
                                <h4><a href="#"><?php echo $post_title; ?></a>
                                    <h4 class=""><?php echo $post_author; ?></h4>
                                </h4>
                                <p><?php echo $post_content; ?></a>.</p>
                            </div>
                            <div class="ratings clearfix">
                                <p class="pull-right">15 reviews</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

<div class="container">

    <hr>


    <?php
    include 'includes/footer.php';
    ?>
