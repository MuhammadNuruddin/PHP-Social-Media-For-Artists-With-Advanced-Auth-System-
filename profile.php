<?php 
require_once 'core/init.php'; 


// CHECK IF USER LOGGED IN OR NOT

if (!Session::exists('username')) {

  // IF USER NOT LOGGED IN, REDIRECT TO HOMEPAGE

  Redirect::to('index.php');
}






// CODE FOR THE BIO INSERT/UPDATE
if (Input::get_item('submit_bio')) {
  // CHECK FOR BIO INFORMATION SUBMISSION

  $msg = array();
  $bio = Input::get('bio');
  $validate = new Validate();
  $validation = $validate->check($_POST, array(
      'bio' => array(
      'field_name' => 'Bio',
      'required' => true
      )
  ));

  if ($validation->passed()) {
        try {
          $db = DB::connect()->insert('additional_user_info', array(
            'user_id' => Session::get(Config::get('session.session_name')),
            'bio' => $bio
          ));  
          Session::flash('bio', 'Bio info inserted Successfully!');
          Redirect::to('profile.php');        
        } catch (Exception $e) {
          Redirect::to(400);
        }

      // }

  }else {
    foreach ($validation->errors() as $error) {
      array_push($msg, $error);

    }

  }
}


// CODE FOR THE BIO INSERT/UPDATE
if (Input::get_item('edit_bio')) {
  // CHECK FOR BIO INFORMATION SUBMISSION

  $msg = array();
  $bio = Input::get('bio');
  $validate = new Validate();
  $validation = $validate->check($_POST, array(
      'bio' => array(
      'field_name' => 'Bio',
      'required' => true
      )
  ));

  if ($validation->passed()) {
        try {
          $db = DB::connect()->update_additional_info('additional_user_info', Session::get(Config::get('session.session_name')),
            array('bio' => $bio)
        );  
          Session::flash('bio', 'Bio info updated Successfully!');
          Redirect::to('profile.php');        
        } catch (Exception $e) {
          Redirect::to(400);
        }

      // }

  }else {
    foreach ($validation->errors() as $error) {
      array_push($msg, $error);

    }

  }
}


// EDIT BIO INFORMATION
if (Input::get_item('delete_bio')) {
  // CODE TO SET THE BIO COLUMN FOR THE LOGGED IN USER IN THE TABLE TO NULL
  $user_id = Session::get(Config::get('session.session_name'));
  $query = DB::connect()->delete('additional_user_info', array('user_id', '=', 
    $user_id));
    Session::flash('bio', 'Bio info removed Successfully!');
    // exit('bio_removed');
}


// CODE TO ADD OR EDIT PROFILE IMAGE
if (Input::get_item('submit_image')) {
     $file = $_FILES['file_image'];

  $fileName = $_FILES['file_image']['name']; 
  $fileTmpName = $_FILES['file_image']['tmp_name'];
  $fileSize = $_FILES['file_image']['size'];
  $fileError = $_FILES['file_image']['error'];
  $fileType = $_FILES['file_image']['type'];

  // EXPLODE THE FILE NAME(.) TO SEPARATE THE FILENAME FROM THE FILE EXTENSION
  $fileExt = explode('.', $fileName);
  
  // THE END RETURNS THE LAST ITEM IN AN ARRAY. SO THE EXPLODE FUNCTION WILL RETURN TWO ARRAY VALUES(1-FILENAME,2-FILE EXTENSION)
  // AND THE STRTOLOWER FUNCTION WILL CHANGE THE FILE EXTENSION TO LOWER CASE FOR PERFECT MATCH WITH ALL GIVEN EXTENSIONS
  $fileActualExt = strtolower(end($fileExt));

  // THIS ARRAY CONTAINS ONLY THE ALLOWED IMAGE EXTENSIONS
  $allowed = array('jpg','png','jpeg');

  if (in_array($fileActualExt, $allowed)) {
    // CHECK IF THE FILE EXTENSION IS ALLOWED OR NOT(CHECK THE ARRAY WITH THE ALLOWED FILE EXTENSIONS AND COMPARE WITH THE FILE EXTENSION)
    if ($fileError === 0) {
      // CHECK IF THERE IS AN ERROR OR NOT
      if ($fileSize > 5000000) {
        // CHECK FOR THE FILE SIZE
        Session::flash('msg', 'File size too big!');
        // $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong></strong></div>';
        

      }else {
        // $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = ".$_SESSION['userId']."");
        $user = new User(Session::get(Config::get('session.session_name')));
        // $result = mysqli_fetch_assoc($result);
        // while ($row = mysqli_fetch_assoc($sql)) {
        //   $old_image = $row['avatar'];
        // }
        $old_image = $user->data()->avatar;
        
        // GENERATE A NEW FILENAME WITH THE UNIQID FUNCTION(PREPENDS THE MICROSECONDS OF THE CURRENT TIMESTAMP TO THE FILE EXTENSION)
        $fileNewName = uniqid('img-',true).".".$fileActualExt;
        // FILE DIRECTORY FOR THE STORED IMAGES
        $file_dir = 'profile_image/'.$fileNewName;
        // MOVE THE FILE FROM THE TEMPORARY FILE DIRECTORY TO THE NEW FILE DIRECTORY
        move_uploaded_file($fileTmpName, $file_dir);

        // 

        
        // ADD TO DATABASE HERE
        // $query = "UPDATE users SET avatar = '$file_dir' WHERE user_id = ".$_SESSION['userId']."";
        $query = DB::connect()->update('users', Session::get(Config::get('session.session_name')), 
          array('avatar' => $file_dir)
        );
        if ($query) {
          if ($old_image !== null) {
            unlink("".$old_image."");
          }
          
          
          // Redirect::to('profile.php');
          Session::flash('success', 'Profile Image updated Successfully!');
        }      
        }
    }else {
      // $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong></strong></div>';
      Session::flash('msg', 'There was an error uploading your file!');

    }

  }else {
    // $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>Invalid file format; only jpg, jpeg, and png allowed!</strong></div>';
    Session::flash('msg', 'Invalid file format; only jpg, jpeg, and png allowed!');
  }
}


// REMOVE PROFILE IMAGE CODE

if (Input::get_item('remove_image')) {
  $old_avi = new User(Session::get(Config::get('session.session_name')));
  $old_image = $old_avi->data()->avatar;

    $query = DB::connect()->update('users', Session::get(Config::get('session.session_name')),array(
          'avatar' => null
    ));
    if ($query) {
      if ($old_image !== null) {
         unlink("".$old_image."");
      }
     
      Session::flash('success', 'Profile Image removed Successfully!');
      exit('profile_image_updated');

  }
  }

// edit social media info script
if(Input::get_item('edit_social_info')) {
  $facebook_username = Input::get('facebook_username');
  $instagram_username = Input::get('instagram_username');
  $twitter_username = Input::get('twitter_username');
  $user_id = Input::get('user_id');
  if($facebook_username == '') {
    $facebook_username = null;
  }
  if($instagram_username == '') {
    $instagram_username = null;
  }
  if($twitter_username == '') {
    $twitter_username = null;
  }
  // if(empty($facebook_username) && empty($instagram_username) && empty($twitter_username)) {
    Session::flash('msg', 'Please Input some values!');
  // }else {
    $query = DB::connect()->update_additional_info('additional_user_info', $user_id, array(
			'facebook' => $facebook_username,
			'instagram' => $instagram_username,
			'twitter' => $twitter_username
	));
  if($query) {
		Session::flash('success', 'Social Info added Successfully!');
		Redirect::to('profile.php');
	}
  // }

}


// $query = "SELECT * FROM work WHERE user_Id = ".$_SESSION['userId']." ORDER BY uploaded_on DESC";
// $rows = mysqli_query($conn, $query);


// // Edit Work Code
// $msg = '';
// $work_title = '';
// $work_description = '';
// $picture_name = '';
// $category = '';
// if (isset($_POST['submit'])) {
// $work_title = mysqli_real_escape_string($conn, $_POST['work_title']);
// $work_description = mysqli_real_escape_string($conn, $_POST['work_description']);
// $picture_name = mysqli_real_escape_string($conn, $_POST['picture_name']);
// $category = mysqli_real_escape_string($conn, $_POST['category']);
// if (!empty($work_description) || !empty($work_description) || !empty($picture_name)) {
//     $file = $_FILES['file'];

//   $fileName = $_FILES['file']['name'];
//   $fileTmpName = $_FILES['file']['tmp_name'];
//   $fileSize = $_FILES['file']['size'];
//   $fileError = $_FILES['file']['error'];
//   $fileType = $_FILES['file']['type'];


//   $fileExt = explode('.', $fileName);
//   $fileActualExt = strtolower(end($fileExt));
//   $allowed = array('jpg','png','jpeg','gif');

//   if (in_array($fileActualExt, $allowed)) {
    
//     if ($fileError === 0) {
//       if ($fileSize > 5000000) {
//         $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>File size too big!</strong></div>';
        
//       }else {
//         $fileNewName = uniqid('',true).".".$fileActualExt;
//         $file_dir = 'uploads/'.$fileNewName;
//         move_uploaded_file($fileTmpName, $file_dir);
//         // 

        
//         // ADD TO DATABASE HERE
//         $query = "INSERT INTO work(user_id,category,work_title,work_description,img_name,img_dir) VALUES(".$_SESSION['userId'].",'$category','$work_title','$work_description','$picture_name','$file_dir')";

//         if (mysqli_query($conn, $query)) {
//           $work_title = '';
//           $work_description = '';
//           $picture_name = '';
//           $category = '';
//           $msg = '<div class="alert alert-success py-3 rounded-0 mb-4"><strong>Successfully uploaded!</strong></div>';
//         }         
//         }
//     }else {
//       $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>There was an error uploading your file!</strong></div>';

//     }

//   }else {
//     $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>Invalid file format; only jpg, jpeg,png, and gif allowed!</strong></div>';
//   }
// }else {
//  $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>Both fields are required!</strong></div>';
// }


//   // }

  
// }


// GET ADDITIONAL INFO FROM THE OTHER TABLE
$user_info = new User();
if ($user_info->find_info(Session::get('userId'))) {
  $rows = $user_info->user_info();
}else {
  $rows = null;
}
// var_dump($rows);
// GET USER INFO - LOGGED IN USER
$user = new User(Session::get('userId'));
if (!$user->exists()) {
  Redirect::to(404);
}else {
  $data = $user->data();
}

$works = DB::connect()->select('work', array('user_Id', '=', Session::get(Config::get('session.session_name'))));
$results = $works->results();
// foreach ($results as $row) {
// var_dump($row->img_name);
// }

// get followers count request
if(Input::get('get_followers')) {
	$user_id = Input::get('user_id');
	$query = DB::connect()->select('follow', array('follows_user_id', '=', $user_id));
	if($query) {
		$count = $query->count();
		exit(''.$count.'');
	}
}

if(Input::get('get_following')) {
	$user_id = Input::get('user_id');
	$query = DB::connect()->select('follow', array('follower_id', '=', $user_id));
	if($query) {
		$count = $query->count();
		exit(''.$count.'');
	}	
}

?>



<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>(<?= $data->username ?>) - Profile</title>
	<!-- <link href="public/css/all.min.css" rel="stylesheet"> -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700,900" rel="stylesheet">
    <link href="./fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <link rel="stylesheet" type="text/css" href="./style1.css">
    <style type="text/css" rel="stylesheet">
    body {
      color: #666;
      background: #f0f7f4;
    }
      .dropdown-menu {
        transform: none !important;
      }
      .hidden_file {
        display: none;
      }
      .profile_image_container {
        height: 20rem;
        width: 20rem;
        object-fit:cover;
      }
      .profile_image_container img {
        object-fit: cover;
        width: 100%;
      }
      @media (max-width: 657px) {
        .border-sm-none {
          border-right: none !important;
          margin-bottom: 1.5rem;
        }
        .img_preview {
          height: 13rem !important;
        }
      }
      .test-btn + span {
        opacity: 0.8;
      }
      .img_preview {
        width: 100%;
        height: 10rem;
      }
      .work_action_btns {
        display: flex;
        justify-content: space-around;
        width: 100%;
      }
      .work_action_btns a {
        padding: .3rem;
        font-size: .8rem;
        opacity: .9;
      }
      #preview_image_src {
        border-radius: 2px;
        height: 25rem !important;
      }
      @media (max-width: 768px) and (min-width: 100px){
        .Card {
          position: relative;
        }
        .Card .work_action_btns {
          position: absolute;
          top: 50%;
          left: 50%;
          width: 80%;
          transform: translate(-50%,-50%);
          background: rgba(214, 214, 194,0.3);
          border:1px solid silver;
        }
        .work_action_btns a {
        padding: .3rem;
        font-size: 1rem;
        opacity: 0.8;
        color: #dc3545;
        font-weight: bold;
        }
      }
      .remove_social_container {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .Card {
            border: 1px solid #E4E7ED;
            margin-top: 0;
        }
    </style>
</head>
<body>
<a href="" class="btn btn-light ml-2 mt-3 back_btn"><i class="fa fa-arrow-left"></i> Back</a>
<hr>
<div class="container mt-3">
  <div class="container">

  <div class="container">
   <?php if (isset($msg)) {
    foreach ($msg as $error) {
      echo "<div class='alert alert-danger py-3 rounded-0 mb-4'><strong>{$error}</strong></div>";
    }
    
  }else if(Session::exists('bio'))
      echo "<div class='alert alert-success py-3 rounded-0 mb-4'><strong>".Session::flash('bio')."</strong></div>";
    else if(Session::exists('msg'))
      echo "<div class='alert alert-danger py-3 rounded-0 mb-4'><strong>".Session::flash('msg')."</strong></div>";

  else if(Session::exists('success'))
      echo "<div class='alert alert-success py-3 rounded-0 mb-4'><strong>".Session::flash('success')."</strong></div>";
  ?>

    
  </div>
 
  </div>
  <div class="row justify-content-center pt-5">
    <div class="col-md-4">
      <div class="m-3">
        <?php if($data->avatar !== null): ?>
        <img src="<?= $data->avatar ?>" class="profile_image_container img-fluid border rounded-circle border-danger p-1">
        <?php else: ?>
        <img src="./profile_image/default_image.jpg" class="profile_image_container img-fluid border rounded-circle border-danger p-1">
        <?php endif; ?>
        <div class="dropdown">
        &nbsp;&nbsp;&nbsp; 
        <a href="#" data-toggle="modal" data-target="#edit_modal" title="Edit Image" class="btn btn-danger d-inline-block" data_id="<?= $data->id ;?>" id="popover-avatar"><i class="fa fa-edit" title="Edit Profile Image"></i>
        </a>
<!--         <div class="dropdown-menu">
          <form>
         <label for="file_hidden" class="mb-0 dropdown-item" id="label_change"><span>Change Image</span></label>
          <input type="file" id="file_hidden" name="file" class="hidden_file" accept="image/*;capture=camera">
          
          <hr class="my-1 bg-secondary mx-3">

          <a href="" class="dropdown-item" id="remove_image" style="display: flex;justify-content: space-between;align-items: center;">Remove Image</a>
          </form>
        </div> -->
        </div>

      </div>
        </div>
  </div>

<!-- The Modal -->
<div class="modal" id="edit_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-6 border-right border-sm-none">
              <h3 class="lead mb-2"><strong>Change Image</strong></h3>
              <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                <div class="form-group">
              <input type="file" name="file_image" id="file_image" accept="image/*;capture=camera" class="form-control">
              </div>


              <div class="jumbotron img_preview">
                <img src="" alt="Preview Image" id="img_preview_img">
                <span><p class="lead text-dark" id="img_preview_text">Image Preview</p></span>
              </div>
              <button type="submit" class="btn btn-primary" name="submit_image">Save Changes</button>
              </form>
            </div>
            <div class="col-md-6">
              <h3 class="lead mb-2"><strong>Remove Image</strong></h3>
              <a href="#" class="btn btn-info d-block" data_user_id="<?= $data->id ;?>" id="remove_image">Proceed</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>


          <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <div class="bio-section text-center">
          <h4 class="display-4 my-3" style="font-size: 2.3rem"> <i class="fa fa-user-tie"></i> <?= $data->username ?></h4>
           
           <!-- Follow details -->
           
           
            <ul class="nav nav-tab my-4 justify-content-center mb-2 section-tab-nav" id="target">
            <li class="nav-item">
              <a data-toggle="modal" data-target="#followers_modal" class="nav-link text-danger profile_followers" data-toggle="tab"><strong></strong> Followers</a>
            </li>
            <li class="nav-item">
              <a data-toggle="modal" data-target="#following_modal" class="nav-link text-danger profile_following" data-toggle="tab"><strong></strong> Following</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" data-toggle="tab"><strong><?= $works->count() ?></strong> Works</a>
            </li>
          </ul>

            
          <div class="jumbotron">
          <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-info-circle"></i> Bio</h4>
          <hr class="my-3">
          <?php if($rows->bio == null): ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
              <div class="form-group">
                <textarea rows="6" name="bio" class="form-control" placeholder="Add Bio"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="submit_bio" class="btn btn-danger text-left d-block">Add <i class="fa fa-plus"></i></button>
              </div>
            </form>
            <?php else: ?>
          <p class="lead my-5" style="font-size: 1.2rem"><?= $rows !== null ? $rows->bio : 'Bio not found' ;?> &nbsp;&nbsp;&nbsp;<a href="" class="btn btn-danger btn-sm" id="edit_bio_btn" data_user_id="<?= Session::get('userId') ;?>" data-toggle="modal" data-target="#edit_bio_modal"><i class="fa fa-edit" title="Edit Bio"></i></a>
            <a href="" data-toggle="modal" data-target="#remove_bio_modal" class="btn btn-danger btn-sm ml-1" name="remove_bio" data_user_id="<?= Session::get('userId') ;?>"><i class="fa fa-trash-alt" title="Remove Bio"></i></a></p>
          <!-- <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>" id="hidden_bio_field" style="display: none;">
              <div class="form-group">
                <textarea rows="6" name="bio" class="form-control" placeholder="Edit Bio"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="submit_bio" class="btn btn-danger text-left d-block">Edit Bio</button>
              </div>
            </form> -->
<!--             <div class="container">
              <form id="hidden_bio_field" style="display: none;">
                <div class="form-group">
                <textarea rows="6" name="bio" class="form-control" placeholder="Edit Bio" id="hidden_textarea_input"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="submit_bio" class="btn btn-danger text-left d-block">Edit Bio</button>
              </div>
              </form>
            </div> -->
        <?php endif ; ?>
        </div>
<div class="jumbotron">
          <div class="container">
            <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-info"></i> Contact Info</h4>
          <hr class="my-3">
          <div style="opacity: 0.9">
          <a href="http://www.instagram.com/<?php isset($rows->instagram) ? print $rows->instagram : print '' ;?>" class="btn" target="_blank"><i class="fab fa-instagram"></i> <strong><?php isset($rows->instagram) ? print $rows->instagram : print 'N/A' ;?></strong></a>
            <a href="http://www.twitter.com/<?php isset($rows->twitter) ? print $rows->twitter : print '' ;?>" class="btn" target="_blank"><i class="fab fa-twitter"></i> <strong><?php isset($rows->twitter) ? print $rows->twitter : print 'N/A' ;?></strong></a>
            <a href="http://www.facebook.com/<?php isset($rows->facebook) ? print $rows->facebook : print '' ;?>" class="btn" target="_blank"><i class="fab fa-facebook-square"></i> <strong><?php isset($rows->facebook) ? print $rows->facebook : print 'N/A' ;?></strong></a>
            <a href="mailto:<?= $data->email ;?>" class="btn" target="_blank"><i class="fa fa-envelope"></i> <strong><?= $data->email ?></strong></a>
            <a href="tel:<?= $data->phone?>" class="btn" target="_blank"><i class="fa fa-phone"></i> <strong><?= $data->phone ?></strong></a>
            <br>
            <a href="" class="btn  btn-outline-dark my-4" data-toggle="modal" data-target="#social_info_modal">Add social media info <i class="fa fa-globe"></i></a>
            <?php if(isset($rows->instagram) || isset($rows->facebook) || isset($rows->twitter)): ?>
            <a href="" class="btn  btn-outline-dark my-4" data-toggle="modal" data-target="#edit_info_modal">Edit <i class="fa fa-pen"></i></a>
            <a href="" class="btn btn-outline-dark" data-toggle="modal" data-target="#social_info_remove">Remove <i class="fa fa-trash-alt"></i></a>
            <?php endif; ?>
            </div>
          </div>
          </div>

          <!-- All user posts -->

<div class="container">
  <div class="text-center mt-5">
    
  <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-cloud-upload-alt"></i> Uploads</h4>
    <hr class="my-3">
  </div>
  <div class="container d-flex justify-content-center mb-3">
    <a href="upload.php" class="btn btn-danger"><i class="fa fa-cloud-upload-alt"></i> Upload More</a>
  </div>
  <ul class="nav nav-tab mt-2 justify-content-center mb-2 section-tab-nav" id="target">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#new">New</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#old">Old</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#all">All</a>
  </li>

</ul>
</div>
</div>




<!-- MODALS -->



<!-- EDIT BIO MODAL -->
<!-- The Modal -->
<div class="modal" id="edit_bio_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Bio</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
      <div class="modal-body">
        <div class="form-group">
          <textarea id="hidden_textarea_input" name="bio" placeholder="Edit Bio" class="form-control" rows="10"><?= $rows->bio ;?></textarea>
        </div>
    </div>

          <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="edit_bio">Save Changes</button>
      </div>
    </form>
  </div>
</div>
</div>




<!-- REMOVE BIO MODAL -->
<!-- The Modal -->
<div class="modal" id="remove_bio_modal">
  <div class="modal-dialog">
    <div class="modal-content">
<form action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
      <!-- Modal Header -->
      <div class="modal-header">
        
        <h4 class="modal-title">Remove Bio</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->

      <div class="modal-body">
        <p class="lead"><strong>Are you sure you want to remove bio???</strong></p>
    </div>

          <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" name="delete_bio" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
      </form>
  </div>
</div>
</div>

<!-- EDIT SOCIAL MEDIA INFO MODAL -->
<!-- The Modal -->
<div class="modal" id="edit_info_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Social Media Info</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="mt-2" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <?php if(isset($rows->facebook)): ?>
        <div class="form-group">
        <label for=""><strong>Facebook Username</strong></label>      
        <input type="text" class="form-control" name="facebook_username" placeholder="Enter your facebook username" value="<?= $rows->facebook ?>">     
        </div>
        <?php endif ;?>
        <?php if(isset($rows->twitter)): ?>
        <div class="form-group">
        <label for=""><strong>Twitter Username</strong></label>
        <input type="text" class="form-control" name="twitter_username" placeholder="Enter your twitter username" value="<?= $rows->twitter ?>">
        </div>
        <?php endif ;?>
        <?php if(isset($rows->instagram)): ?>
        <div class="form-group">
        <label for=""><strong>Instagram Username</strong></label>
        <input type="text" class="form-control" name="instagram_username" placeholder="Enter your instagram username" value="<?= $rows->instagram ?>">
        </div> 
        <?php endif ;?>
        <input type="hidden" value="<?php echo Session::get('userId') ?>" name="user_id">      
      </div>

          <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="edit_social_info">Save Changes</button>
      </div>
    </form>
  </div>
</div>
</div>

<!-- UPDATE SOCIAL INFO MODAL -->
<!-- The Modal -->
<div class="modal" id="social_info_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add your social media Info</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div id="errorMsg" class="text-danger"></div>
        <p class="text-info">Click on social media icon to add or cancel</p>
        <div class="social_icons">
        <?php if(!isset($rows->facebook)): ?>
        <a href="#" id="facebook_btn" class="btn"><i class="fab fa-facebook"></i> Facebook</a>
        <?php endif ;?>
        <?php if(!isset($rows->twitter)): ?>
        <a href="#" id="twitter_btn" class="btn"><i class="fab fa-twitter"></i> Twitter</a>
        <?php endif ;?>
        <?php if(!isset($rows->instagram)): ?>
        <a href="#" id="instagram_btn" class="btn"><i class="fab fa-instagram"></i> Instagram</a>
        <?php endif ;?>
        </div>
        <form class="mt-2" id="social_media_form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <div class="form-group">
        <input type="text" class="form-control" name="facebook_username" id="facebook_username" placeholder="Enter your facebook username">     
        </div>
        <div class="form-group">
        <input type="text" class="form-control" name="twitter_username" id="twitter_username" placeholder="Enter your twitter username">
        </div>
        <div class="form-group">
        <input type="text" class="form-control" name="instagram_username" id="instagram_username" placeholder="Enter your instagram username">
        </div> 
        <input type="hidden" id="user_id" value="<?php echo Session::get('userId') ?>" name="user_id">      
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- REMOVE SOCIAL MEDIA INFO  MODAL -->
<!-- The Modal -->
<div class="modal" id="social_info_remove">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Remove Social media Info</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="">
        <?php if(isset($rows->facebook)): ?>
        <div class="form-group remove_social_container">
        <a href="" class="btn"><i class="fab fa-facebook"></i> FACEBOOK</a> <a href="" class="btn remove_social_info bg-light border-danger" id="facebook"><i class="fa fa-trash-alt text-danger"></i></a>
        </div>
        <?php endif ?>
        <?php if(isset($rows->twitter)): ?>
        <hr>
        <div class="form-group remove_social_container">
        <a href="" class="btn"><i class="fab fa-twitter"></i> TWITTER</a> <a href="" class="btn remove_social_info bg-light border-danger" id="twitter"><i class="fa fa-trash-alt text-danger"></i></a>
        </div>
        <?php endif ?>
        <?php if(isset($rows->instagram)): ?>
        <hr>
        <div class="form-group remove_social_container">
        <a href="" class="btn"><i class="fab fa-instagram"></i> INSTAGRAM</a> <a href="" class="btn remove_social_info bg-light border-danger" id="instagram"><i class="fa fa-trash-alt text-danger"></i></a>
        </div>
        <?php endif ?>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       

      </div>
    </form>
    </div>
  </div>
</div>



<!-- UPDATE SOCIAL INFO MODAL -->
<!-- The Modal -->
<div class="modal" id="Edit_work_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Work</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body mb-0">
<div class="form-container d-flex align-items-center justify-content-center">
  <form class="input-form text-center" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
    <?php if (isset($msg)) : ?>
      <?php echo $msg; ?>
  <?php endif ; ?>
  <div id="work_edit_errorMsg"></div>
    <div id="dropdown_input" class="text-left">
      <div class="form-group">
        <select class="form-control" id="category" name="category">
          <option class="category_option" selected="selected" disabled="disabled">Select Category:</option>
          <option class="category_option">Painting</option>
          <option class="category_option">Sketch</option>
          <option class="category_option">Graffiti</option>
          <option class="category_option">Picture Drawing</option>          
        </select>
      </div>

</div>




    <div id="manual_input">
    <div class="form-group">
      <input type="text" name="work_title" class="form-control form-control-lg mb-3" placeholder="Title of work" id="work_title" value="<?php echo $work_title; ?>">
    </div>

    <div class="form-group">
      <textarea class="form-control" rows="5" placeholder="Brief description of work" id="work_description" name="work_description"><?php echo $work_description; ?></textarea>
    </div>
    <div class="form-group">
      <input type="text" class="form-control form-control-lg" placeholder="Name of Picture" id="picture_name" name="picture_name" value="<?php echo $picture_name; ?>">
    </div>
    <input type="hidden" id="work_id" name="work_id" data_work_id="">

      <div class="form-group">
        <input type="file" class="form-control" accept="image/*;capture=camera" name="file" id="file_edit">
        <div class="d-flex align-items-center">
        <div class="jumbotron img_preview mt-1">
          <img src="" alt="Preview Image" id="img_preview_img_edit">
          <span><p class="lead text-dark" id="img_preview_text_edit">Image Preview</p></span>
        </div>

        <div class="jumbotron img_preview mt-1 preview_current_image ml-2">
          <img src="" alt="Current Image" id="current_image">

          <p class="lead text-dark"><strong>Current Image</strong></p>
        </div>
        </div>
      </div>
  </div>

  </form>

</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_work_btn">Save Changes</button>
      </div>
    </form>
    </div>
  </div>
</div>




<!-- View work Modal -->
<div class="modal fade" id="View_work_modal">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
         <div class="modal-header">
            <h4>Preview Work</h4>
            <span class="close" data-dismiss="modal">&times;</span> 
         </div>  
         <div class="modal-body">
          <div class="container">
          <img src="" id="preview_image_src" class="img-fluid w-100">
          </div>
         </div>

         <div class="modal-footer">
           <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>

       </div>
   </div> 
</div>
<!-- End of View work Modal -->

<!-- REMOVE WORK MODAL -->
<!-- The Modal -->
<div class="modal" id="Remove_work_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Remove Work</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="lead"><strong>ARE YOU SURE YOU WANT TO REMOVE THE SELECTED WORK??</strong></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="remove_work_btn" data_user_id="">Yes</button>

      </div>
    </form>
    </div>
  </div>
</div>


<!-- FOLLOWERS MODAL -->
<!-- The Modal -->
<div class="modal" id="followers_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Followers</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="followers_container"></div>
      </div>



    </div>
  </div>
</div>
<!-- END OF FOLLOWERS MODAL -->


<!-- FOLLOWING MODAL -->
<!-- The Modal -->
<div class="modal" id="following_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Users Following</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <div class="following_container"></div>

      </div>

    </div>
  </div>
</div>

<!-- FOLLOWING MODAL -->

<div class="container mt-4">

  <div class="tab-content">


    <!-- First tab starts here... -->
<div class="tab-pane container active" id="new">
    <!-- grid system row starts.. -->
<div class="row">
<?php foreach($results as $row): ?> 
<!--   <?php var_dump($row->id); ?> -->
<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?= $row->img_dir ;?>" class="img-fluid img-link" data_id="<?$row->id ;?>"> 
  <div class="btns test-btn" data_id="<?$row->user_Id ;?>">
    <span><a href="view_work.php?id=<?= $row->work_id ?>" class="view_link"><i class="fa fa-eye" data_user_id="<?= $row->user_Id ?>" data_post_id="<?= $row->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
    <span><i class="fa fa-heart" data_user_id="<?= $row->user_Id ?>" data_post_id="<?= $row->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></span>
    <span title="Comment"><a href="./comments.php?ci=<?= $row->work_id ?>" class="view_link"><i class="fa fa-comments" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->work_id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
 </div>

    </div> 
 <span class="work_action_btns"><a href="" class="btn edit_work" data_id="<?= $row->id ;?>" data-toggle="modal" data-target="#Edit_work_modal"><strong><i class="fa fa-edit"></i> Edit</strong></a>
<a href="" class="btn view_work" data_img_src="" data_id="<?= $row->id ;?>" data-toggle="modal" data-target="#View_work_modal"><strong><i class="fa fa-eye"></i> View</strong></a>
<a href="" class="btn remove_work" data_id="<?= $row->id ;?>" data-toggle="modal" data-target="#Remove_work_modal"><strong><i class="fa fa-trash-alt"></i> Remove</strong></a>

</span>
</div>

</div>
<?php endforeach ;?> 
</div>
</div>
<!-- First tab ends here -->



<!-- Second tab starts here -->

<div class="tab-pane container fade" id="old">
  <div class="row">
<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="./background/img11.jpg" class="img-fluid img-link">  
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 900</span>
    <span><i class="fa fa-heart"></i> 249</span>
    <span><i class="fa fa-comments"></i> 517</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div> 



</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img13.jpg" class="img-fluid img-link">   

  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 1k</span>
    <span><i class="fa fa-heart"></i> 900</span>
    <span><i class="fa fa-comments"></i> 340</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
   </div>


</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img100.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 3k</span>
    <span><i class="fa fa-heart"></i> 279</span>
    <span><i class="fa fa-comments"></i> 407</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img10.jpg" class="img-fluid img-link">   

  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 960</span>
    <span><i class="fa fa-heart"></i> 709</span>
    <span><i class="fa fa-comments"></i> 177</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>
  </div>
</div>
<!-- Second tab ends here -->


<!-- Third Tab starts here -->
<div class="tab-pane container fade" id="all">
  <div class="row">
<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="./background/img11.jpg" class="img-fluid img-link">  
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 10k</span>
    <span><i class="fa fa-heart"></i> 5k</span>
    <span><i class="fa fa-comments"></i> 3k</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div> 



</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img13.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 8k</span>
    <span><i class="fa fa-heart"></i> 6k</span>
    <span><i class="fa fa-comments"></i> 1k</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/blossoms.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 11k</span>
    <span><i class="fa fa-heart"></i> 7k</span>
    <span><i class="fa fa-comments"></i> 4k</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img100.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 9k</span>
    <span><i class="fa fa-heart"></i> 7k</span>
    <span><i class="fa fa-comments"></i> 4k</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="./background/img11.jpg" class="img-fluid img-link">  
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 900</span>
    <span><i class="fa fa-heart"></i> 249</span>
    <span><i class="fa fa-comments"></i> 517</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div> 



</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img13.jpg" class="img-fluid img-link">   

  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 1k</span>
    <span><i class="fa fa-heart"></i> 900</span>
    <span><i class="fa fa-comments"></i> 340</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
   </div>


</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img100.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 3k</span>
    <span><i class="fa fa-heart"></i> 279</span>
    <span><i class="fa fa-comments"></i> 407</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img10.jpg" class="img-fluid img-link">   

  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 960</span>
    <span><i class="fa fa-heart"></i> 709</span>
    <span><i class="fa fa-comments"></i> 177</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>


<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="./background/img1.jpg" class="img-fluid img-link"> 
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 200</span>
    <span><i class="fa fa-heart"></i> 179</span>
    <span><i class="fa fa-comments"></i> 57</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div> 

</div>

</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img13.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 300</span>
    <span><i class="fa fa-heart"></i> 279</span>
    <span><i class="fa fa-comments"></i> 47</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>
</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img10.jpg" class="img-fluid img-link">   
  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 90</span>
    <span><i class="fa fa-heart"></i> 79</span>
    <span><i class="fa fa-comments"></i> 17</span>
 </div>
<span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>

<div class="col-xs-12 col-sm-12 col-lg-3 col-md-6 btn-wrapper">
    <div class="Card"> 
    <div class="img img-wrapper">
      <img src="./background/img100.jpg" class="img-fluid img-link">   

  <div class="btns test-btn">
    <span><i class="fa fa-eye"></i> 50</span>
    <span><i class="fa fa-heart"></i> 27</span>
    <span><i class="fa fa-comments"></i> 13</span>
 </div>
 <span><a href="" class="btn d-block"><strong><i class="fa fa-edit"></i> Edit</strong></a></span>
    </div>


</div>

</div>
  </div>
</div>
</div>
</div>



        </div>
        </div>
</div>


<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./script.js"></script>
<script type="text/javascript" src="./js/timeago.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // var category;
    var file_input_img;
    // edit_img_src;
    $('.edit_work').click(function(e){
      e.preventDefault();
      var id= $(this).attr('data_id');
      var work_title = $('#work_title');
      var work_description = $('#work_description');
      var picture_name = $('#picture_name');
      var category = $('#category');
      var file_input = $('#file_edit');
      var img_preview_img = $('#img_preview_img');
      var current_image = $('#current_image');
      $.ajax({
        url:'server.php',
        method:'POST',
        dataType:'json',
        cache:false,
        data:{id:id,edit_work:1},
        success:function(response){
          // console.log(response);


          var work_id = $('#work_id').attr('data_work_id',response.id);
          work_description.text(response.work_description);
          work_title.val(response.work_title);
          picture_name.val(response.picture_name);
          // file_input.val(response.img_dir);
          // img_preview_img.css('display','block !important');
          current_image.css('display','block');
          current_image.css('border-radius','2px');
          current_image.attr('src',response.img_dir);


          current_image.parent().addClass('p-0');
          if ($('#file_edit').val() === '') {
            file_input_img = response.img_dir;
          }
          // var item = $('.category_option');

          // set category value
          // category.val() = response.category;
        //   var changed_category = $('#category').change();
        // if (!changed_category) {
        //     var category = response.category;
        //     alert(category);
        // }

          var option_items = $('.category_option');
          for (var i = 0; i < option_items.length; i++) {
            // console.log(option_items[i].value);
            if (option_items[i].value === response.category) {
              option_items[i].selected = 'selected';
            }
            
          }


        }
      });
    });

// Change Work Image Code
  var img_preview = $('.img_preview');
    var img_preview_img = $('#img_preview_img_edit');
    var img_preview_text = $('#img_preview_text_edit');

    $('#file_edit').change(function(){
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
        img_preview.removeClass('p-0');        
      }
    });


    // Make the Category option global for easy asscess from anywhere in the code
    // var category = (''); 

      // $('#category').change(function(){
      //   var option_items = $('.category_option');
      //   for (var i = 0; i < option_items.length; i++) {
      //     category = $(this).val();
      //   }
      // });


   $('#edit_work_btn').click(function(e){
      var work_id= $('#work_id').attr('data_work_id');
      var work_title = $('#work_title').val();
      var work_description = $('#work_description').val();
      var picture_name = $('#picture_name').val();
      var file_input = $('#file_edit').prop('files')[0];
  

      // loop through the category options and get the selected value
      var option_iterates = $('.category_option');
      for (var i = 0; i < option_iterates.length; i++) {
        // console.log(option_items[i].value);
        if (option_iterates[i].selected) {
          category = option_iterates[i].value;

        }
        
      }
      var file;
      if (file_input == undefined) {
        file_input_img = file_input_img;

        file = null;
      }else {
        var file = file_input;

      }
      var form_data = new FormData();
      form_data.append('file_input', file_input_img);
      form_data.append('file', file);
      form_data.append('work_id', work_id);
      form_data.append('category', category);
      form_data.append('work_title', work_title);
      form_data.append('work_description', work_description);
      form_data.append('picture_name', picture_name);
      form_data.append('edit_work_confirm', 1);

      if (work_description !== '' && work_title !== '' && picture_name !== '') {

        $.ajax({
          url:'server.php',
          method:'POST',
          contentType:false,
          processData:false,
          cache:false,
          dataType:'text',
          data:form_data,
          success:function(response){

            if (response === 'input_fields_empty') {

               $('#work_edit_errorMsg').html(`<div class="alert alert-danger p-3 mb-2" style="border-radius:0px !important">
                  <p class="mb-0">Please Fill in all inputs!</p>
                  </div>`); 
            }
            if (response === 'upload_success') {
              window.location = window.location;
            }
          }
        });
      }else {
        $('#work_edit_errorMsg').html(`<div class="alert alert-danger p-3 mb-2" style="border-radius:0px !important">
          <p class="mb-0">Please Fill in all inputs!</p>
          </div>`);
      }


});
   $('#edit_profile_info_btn').click(function(e){
    e.preventDefault();

   });


$('.view_work').click(function(e){
  e.preventDefault();
  // alert('clicked on item!');
  var img_src = $('#preview_image_src');
  var clicked_img = $(this).parent().parent().children().first().children().first().attr('src');
  img_src.attr('src', clicked_img);
  // alert(clicked_img);
  // console.log(clicked_img);
})
var remove_work_id;
$('.remove_work').click(function(e){
  e.preventDefault();
  remove_work_id = $(this).attr('data_id');
 // alert(work_id);

});
 $('#remove_work_btn').click(function(e){

  e.preventDefault();
  // alert(remove_work_id);
  $.ajax({
    url: "server.php",
    method: "POST",
    dataType:"text",
    cache: false,
    data:{remove_work_id:remove_work_id,remove_work_confirm:1},
    success:function(response){
      if (response === 'removed_successfully') {
        window.location = window.location;
      }else {
        return false;
      }
    }
  });
 });
 $('#facebook_username').hide();
 $('#twitter_username').hide();
 $('#instagram_username').hide();
 $('#facebook_btn').click(function(e){
  e.preventDefault();
  $('#facebook_username').toggle();
 });
 $('#twitter_btn').click(function(e){
  e.preventDefault();
  $('#twitter_username').toggle();
 });
 $('#instagram_btn').click(function(e){
  e.preventDefault();
  $('#instagram_username').toggle();
 });

 $('#social_media_form').submit(function(e) {
  e.preventDefault();
  
  let form_obj = $('#social_media_form');
  let form_data_obj = {};
  (function () {
      form_obj.find(":input").not("[type='submit']").not("[type='reset']").each(function () {
          var thisInput = $(this);
          form_data_obj[thisInput.attr("name")] = thisInput.val();
      });
  })();

  $.ajax({
    url: "server.php",
    method: "POST",
    // contentType: 'application/json',
    dataType: 'text',
    data: {form_data:form_data_obj,social_media_info:1},
    success:function(response) {
      if(response === 'social_info_updated') {
        window.location = window.location;
      }
    }
  });

 });

 $('.remove_social_info').click(function(e) {
  e.preventDefault();
  let social_field = $(this).attr('id');
  $.ajax({
    url: 'server.php',
    method: 'POST',
    dataType: 'text',
    data: {social_field:social_field, update_social:1},
    success:function(response) {
      if(response === 'social_info_removed') {
        window.location = window.location;
      }
    }
  });
 });
followers();
following();
// get followers request
function followers() {
  let user_id = <?php echo Session::get('userId') ?>;
  $.ajax({
    url: 'profile.php',
    method: 'GET',
    cache: false,
    data: {user_id:user_id,get_followers:1},
    success:function(response) {
        $('.profile_followers strong').text(response);
      
    }
  });
}

// get following request
function following() {
  let user_id = <?php echo Session::get('userId') ?>;
  $.ajax({
    url: 'profile.php',
    method: 'GET',
    cache: false,
    data: {user_id:user_id,get_following:1},
    success:function(response) {
        $('.profile_following strong').text(response);
      
    }
  });
}

// SEND REQUEST TO FETCH ALL THE USER_ID'S OF THE OTHER USERS THAT THIS PARTICULAR USER IS FOLLOWING
$('.profile_following').click(function(){
let user_id = <?php echo Session::get('userId') ?>;
  $.ajax({
    url: 'server.php',
    method: 'get',
    data: {user_id:user_id,following_info:1},
    success:function(response) {
      $('.following_container').html(response);
    }
  });
});


// SEND REQUEST TO FETCH ALL THE USER_ID'S OF THE OTHER USERS THAT THIS PARTICULAR USER FOLLOWERS
$('.profile_followers').click(function(){
  let user_id = <?php echo Session::get('userId') ?>;
    $.ajax({
      url: 'server.php',
      method: 'get',
      data: {user_id:user_id,followers_info:1},
      success:function(response) {
        $('.followers_container').html(response);
      }
    });
  });
  });
</script>
</body>
</html>