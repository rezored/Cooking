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
                        Admin Page
                        <small>Subheading</small>
                    </h1>
                    <div class="col-xs-6">
                        <?php insert_categories(); ?>
                        <form action="" method="post">
                            <div class="form-group"><label for="cat-title">Add new category's</label>
                                <input class="form-control"type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                            </div>                  
                        </form>
                        <?php
                        if (isset($_GET['edit'])) {
                            $cat_id = $_GET['edit'];
                            include 'includes/update_categories.php';
                        }
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover"><label for="cat-title">Category list</label>
                            <thead>
                            <th>ID</th>
                            <th>Category title</th>
                            <th colspan="2">Actions</th>
                            </thead>
                            <tbody>
                                <?php
                                findAllCategories();
                                deleteCategories();
                                ?>
                            </tbody>
                        </table>         
                    </div>                                                                                                  
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'includes/footer.php';
    ?>
