<?php 
require_once 'core/init.php';
$msg = '';
$work_title = '';
$work_description = '';
$picture_name = '';

if(!Session::exists('loggedIn')) {
  Redirect::to(400);
}

if (Input::get_item('submit')) {
$work_title = Input::get('work_title');
$work_description = Input::get('work_description');
$picture_name = Input::get('picture_name');
if (Input::get_item('category')) {
$category = Input::get('category');
}else {
$category = ''; 
}


if (!empty($work_description) && !empty($work_description) && !empty($picture_name) && !empty($category)) {
    
if (isset($_FILES['file'])) {
$file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];


  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowed = array('jpg','png','jpeg','gif');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize > 5000000) {
        Session::flash('upload', 'File size too big!');
      }else {

        $fileNewName = uniqid('img-',true).".".$fileActualExt;
        $file_dir = 'uploads/'.$fileNewName;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_dir);
        // 

        
        // ADD TO DATABASE HERE
        $query = DB::connect()->insert('work', array(
          'user_Id' => Session::get(Config::get('session.session_name')),
          'category' => $category,
          'work_title' => $work_title,
          'work_description' => $work_description,
          'img_name' => $picture_name,
          'img_dir' => $file_dir,
          'tag' => 'New'
        ));

        if ($query) {
          $work_title = '';
          $work_description = '';
          $picture_name = '';

            Session::flash('upload_success', 'Successfully uploaded!');
            // Redirect::to('success.php');
        }else {
          Session::flash('upload', 'There was an error processing your request, please try again.');
        }
      }

    }else {
      Session::flash('upload', 'There was an error processing request!');
    }

  }else {
    Session::flash('upload', 'Invalid file format; only jpg, jpeg,png, and gif allowed!');
  }
}

    

}else {
  Session::flash('upload', 'Please fill in all fields!');
}




  

  
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Xtriim - Upload</title>
	<link href="public/css/all.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style1.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700,900" rel="stylesheet">
    <link href="./fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <style type="text/css" rel="stylesheet">
    body {
      color: #666;
      background: #f0f7f4;
    }
      .img_preview {
        width: 50%;
        height: 10rem;
      }
    </style>
</head>
<body>
<a href="" class="btn btn-light ml-2 mt-3 back_btn"><i class="fa fa-arrow-left"></i> Back</a>
<hr>
<div class="form-container d-flex align-items-center justify-content-center">
  <form class="input-form text-center" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
    <?php if(Session::exists('upload_success')): ?>
      <div class="alert alert-success py-3 rounded-0 mb-4"><strong><?= Session::flash('upload_success'); ?></strong><br>
        <a href="index.php" class="alert-link"><i class="fa fa-arrow-left"></i> Back to Home</a></div>
    <?php endif ?>
    <?php if (Session::exists('upload')): ?>
    <div class="alert alert-danger py-3 rounded-0 mb-4"><strong><?= Session::flash('upload'); ?></strong></div>      
      
    <?php endif ?>

    <div id="dropdown_input" class="text-left">
      <div class="form-group">
        <label><strong>Category</strong></label>
        <select class="form-control" id="category" name="category">
          <option selected="selected" disabled="disabled">Select Category:</option>
          <option class="category_option">Painting</option>
          <option class="category_option">Sketch</option>
          <option class="category_option">Graffiti</option>
          <option class="category_option">Picture Drawing</option>          
        </select>
      </div>

</div>




    <div id="manual_input">
    <div class="form-group text-left">
      <label><strong>Work Title</strong></label>
      <input type="text" name="work_title" class="form-control form-control-lg mb-3" placeholder="What is the title of your work?" id="work_title" value="<?= $work_title; ?>">
    </div>

    <div class="form-group text-left">
      <label><strong>Work Description</strong></label>
      <textarea class="form-control" rows="5" placeholder="Write something about this your work." id="work_description" name="work_description"><?= $work_description; ?></textarea>
    </div>
    <div class="form-group text-left">
      <label><strong>Picture Name</strong></label>
      <input type="text" class="form-control form-control-lg" placeholder="Please choose a name for the Picture." id="picture_name" name="picture_name" value="<?= $picture_name ; ?>">
    </div>

      <div class="form-group text-left">
        <label><strong>Choose the picture</strong></label>
        <input type="file" class="form-control" accept="image/*;capture=camera" name="file" id="file" value="<?= $_FILES['file']; ?>">
        <div class="jumbotron img_preview mt-1">
          <img src="" alt="Preview Image" id="img_preview_img">
          <span><p class="lead text-dark" id="img_preview_text">Image Preview</p></span>
        </div>
      </div>
  </div>

    <button type="submit" class="btn btn-primary btn-custom btn-block btn-lg mt-4" id="upload_btn" name="submit">UPLOAD <i class="fa fa-cloud-upload-alt d-inline-flex ml-2"></i></button>
  </form>

</div>

<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./js/timeago.js"></script>
 <script type="text/javascript">
  $(document).ready(function(){

  var category_id;
  var image_value;
  var work_title;
  var work_description;
  var picture_name;
  get_select_option();

  //  $('#upload_btn').click(function(e){
  //   e.preventDefault();
  //     category_id = category_id;
  //     image_value = $('#image').val();
  //     work_title = $('#work_title').val();
  //     work_description = $('#work_description').val();
  //     picture_name = $('#picture_name').val(); 

  //   if (category_id !== '' && image_value !== '' && work_description !== '' && work_title !== '' && picture_name !== '') {
    
  //   $.ajax({
  //   url:'upload.php',
  //   method:'POST',
  //   dataType:'text',
  //   data:{
  //     image_value:image_value,
  //     submit:1
  //   },
  //   success:function(response){
  //     if (response === 'file_too_big') {
  //       $('.error_msg').text('File size too big!');
  //     }
  //     if (response === 'error_upload') {
  //       $('.error_msg').text('There was an error uploading your file!');
  //     }
  //     if (response === 'invalid_format') {
  //       $('.error_msg').text('Invalid file format; only jpg, jpeg, and png allowed!');
  //     }
  //   }
  // });

  //   }else {
  //     $('.error_msg').text('Please fill all inputs!');
  //     return false;
  //   }

  //  });

     // function to get option value
  function get_select_option() {
      $('#category').change(function(){

      var cat = $('.category_option');
        for(var i=0;i<cat.length;i++){
          category_id = $(this).val();
        }
    });
  }
     var img_preview = $('.img_preview');
    var img_preview_img = $('#img_preview_img');
    var img_preview_text = $('#img_preview_text');

    $('#file').change(function(){
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        img_preview_text.css('display', 'none');
        img_preview_img.css('display', 'block');
        img_preview.addClass('p-0');

        reader.addEventListener('load', function(){
          // console.log(this);

          img_preview_img.attr('src', this.result)
        });

        reader.readAsDataURL(file);
      }else {
        img_preview_text.css('display', 'block');
        img_preview_img.css('display', 'none');         
      }
    });   
  })

 </script>
</body>
</html>