<?php
include 'includes/header.php';
?>
<div id="wrapper">
    <?php
    include 'includes/navigation.php'
    ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Comments actions
                        <small>Add/Edit/Delete</small>
                    </h1>
                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = "";
                    } switch ($source) {
                        case 'add_comment';
                            include "includes/add_comment.php";
                            break;
                        case 'edit_comment';
                            include "includes/edit_comments.php";
                            break;
                        default :
                            include 'includes/view_all_comments.php';
                            break;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
