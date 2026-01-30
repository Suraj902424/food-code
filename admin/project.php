<?php
include 'loginQuery/session_start.php';
include 'dbc.php'; // Ensure this is included before using $conn

$pageTitle  = "Add a new Portfolio";
$pageName   = "Portfolio";
$linkName   = "Show All Portfolio";
$editMode   = "editData";
$addMode    = "addData";
$tableName  = "portfolio"; // Make sure this table exists in your database
$listPageUrl = "portfolio_list.php"; // Update with the correct URL
$imageUrl   = "uploads/"; // Change to the actual image directory
$user_id    = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

// Fetch Portfolio Data
$serviceData = [];
$image1 = "";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $serviceSql = mysqli_query($conn, "SELECT * FROM $tableName WHERE id = '$id'");

    if ($serviceSql && mysqli_num_rows($serviceSql) > 0) {
        $serviceData = mysqli_fetch_assoc($serviceSql);
        $image1 = $serviceData['image1']; // Fetch image1 from the database
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pageName; ?></title>
    
    <!-- Include header files -->
    <?php include 'include/header-file.php'; ?>

    <link rel="stylesheet" href="vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" />
    <link rel="stylesheet" href="vendor/summernote/dist/summernote.css" />

    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: ".editor",
            plugins: [
                "codesample advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample "
        });
    </script>
</head>

<body>
    <!-- Header -->
    <?php include 'include/header.php'; ?>
    <?php include 'include/side-menu.php'; ?>

    <div id="wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <form id="InsertUpdateForm" role="form" action="save_portfolio.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $serviceData['id'] : ''; ?>">

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="<?php echo isset($_GET['id']) ? htmlspecialchars($serviceData['name']) : ''; ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Url</label>
                                        <input type="text" name="url" class="form-control" value="<?php echo isset($_GET['id']) ? htmlspecialchars($serviceData['url']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <textarea name="meta_title" class="form-control"><?php echo isset($_GET['id']) ? htmlspecialchars($serviceData['meta_title']) : ''; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Meta Keyword</label>
                                    <textarea name="meta_keyword" class="form-control"><?php echo isset($_GET['id']) ? htmlspecialchars($serviceData['meta_keyword']) : ''; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" class="form-control editor"><?php echo isset($_GET['id']) ? htmlspecialchars($serviceData['meta_description']) : ''; ?></textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Uploaded Image</label>
                                        <div>
                                            <?php if (!empty($image1)) : ?>
                                                <img src="<?php echo $imageUrl . htmlspecialchars($image1); ?>" alt="Image 1" width="100%">
                                            <?php endif; ?>
                                        </div>
                                        <input type="file" name="image1">
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>Image Guidelines</strong>
                                        <ul>
                                            <li>Recommended size: 500x400 px</li>
                                            <li>Format: JPG or JPEG</li>
                                        </ul>
                                    </div>
                                </div>

                                <hr>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'include/footer-file.php'; ?>

        <script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="vendor/summernote/dist/summernote.min.js"></script>
        <script>
            $(function() {
                $('.summernote').summernote();
            });
        </script>
    </div>
</body>
</html>
