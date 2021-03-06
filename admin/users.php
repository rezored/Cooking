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
                        case 'add_user';
                            include "includes/add_user.php";
                            break;
                        case 'edit_user';
                            include "includes/edit_user.php";
                            break;
                        default :
                            include 'includes/view_all_users.php';
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
