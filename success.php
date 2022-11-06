
<?php 
require_once 'core/init.php';

if (!Session::flash('upload_success')) {
	Redirect::to('index.php');
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Success</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>
<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center pt-5 flex-column mt-5">
<!-- <?php if(Session::flash('upload_success')): ?> -->
     <div class="alert alert-success py-3 rounded-0 mb-4"><strong><?= Session::flash('upload_success'); ?></strong><br>
        <a href="/" class="alert-link">Back to Home</a>
    </div>
<!-- <?php endif; ?> -->


<a href="upload.php" class="btn mt-5 text-secondary">Upload more stuffs</a>
</div>
</body>
</html>