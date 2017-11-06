<?php
include 'includes/header.php';

$session = session_id();
$time = time();
$time_out_in_seconds = 60;
$time_out = $time - $time_out_in_seconds;

$sessionSelect = Database::instance()->prepare("SELECT * FROM users_online WHERE session = :session ");
$sessionSelect->bindParam(":session", $session);
$sessionSelect->execute();
$sessionCount = $sessionSelect->fetch();

if ($sessionCount == NULL) {
    $insertSession = Database::instance()->prepare("INSERT INTO users_online(session, time) VALUES :session, :time)");
    $insertSession->bindParam(":session", $session);
    $insertSession->bindParam(":time", $time);
    $insertSession->execute();
}

$selectPost = Database::instance()->prepare("SELECT COUNT(*) AS count FROM posts ");
$selectPost->execute();
$countPost = $selectPost->fetch();

$selectComment = Database::instance()->prepare("SELECT COUNT(*) AS count FROM comments ");
$selectComment->execute();
$countCom = $selectComment->fetch();

$selectUser = Database::instance()->prepare("SELECT COUNT(*) AS count FROM users ");
$selectUser->execute();
$countUser = $selectUser->fetch();

$selectCat = Database::instance()->prepare("SELECT COUNT(*) AS count FROM categories ");
$selectCat->execute();
$countCat = $selectCat->fetch();

$selectDrafts = Database::instance()->prepare("SELECT COUNT(*) AS count FROM posts WHERE post_status ='draft' ");
$selectDrafts->execute();
$countDrafts = $selectDrafts->fetch();

$selectUnap = Database::instance()->prepare("SELECT COUNT(*) AS count FROM comments WHERE comment_status= 'unapproved' ");
$selectUnap->execute();
$countUnap = $selectUnap->fetch();
?>
<div id="wrapper">
    <?php
    include 'includes/navigation.php'
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Admin Page
                        <small>Здравей</small>
                        <?php
                        echo $_SESSION['firstname'] . " " . $_SESSION['lastname'];
                        ?>
                    </h1>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $countPost['count']; ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $countCom['count']; ?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $countUser['count']; ?></div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $countCat['count']; ?></div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <script type="text/javascript">
                    google.charts.load('current', {'packages': ['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        console.log("asdsa");
                        var data = google.visualization.arrayToDataTable([
                            ['Data', 'Published', 'In Review'],
                        <?php
                        $element_text = ['Posts', 'Comments', 'Users', 'Categories'];
                        $element_count = [$countPost['count'], $countCom['count'], $countUser['count'], $countCat['count']];
                        $element_review = [$countDrafts['count'], $countUnap['count'], 0, 0];
                        for ($i = 0; $i < 4; $i++) {
                            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}" . "," . "{$element_review[$i]}],";
                        }
                        ?>
                        ]);
                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php
include 'includes/footer.php';
?>
