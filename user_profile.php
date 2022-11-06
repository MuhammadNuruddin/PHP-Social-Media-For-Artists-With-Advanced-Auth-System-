<?php 
require_once 'core/init.php';


// IF THE GET - Q_USER NOT SET, REDIRECT TO THE HOMEPAGE
if (!$username = Input::get('q_user')) {
  Redirect::to('index.php');
}else {
  $user = new User($username);
  if (!$user->exists()) {
    Redirect::to(404);
  }else {
    $data = $user->data();
  }
}

  // var_dump($data);

// if (isset($_GET['q_user'])) {

//   // FETCH THE USER PROFILE WITH THE USERNAME/ID PASSED IN THE URL
//   $username = mysqli_real_escape_string($conn, $_GET['q_user']);
//   $user_data_query = "SELECT * FROM users WHERE username = '$username'";
//   $user_query_result = mysqli_query($conn, $user_data_query);
//   $user_query_num_rows = mysqli_num_rows($user_query_result);

//   $row = mysqli_fetch_assoc($user_query_result);
//   $user_id = $row['user_id'];

  // IF USER LOGGED IN : REDIRECT HIM/HER TO THEIR RESPECTIVE PROFILE PAGE
  // ELSE, REDIRECT TO A NORMAL USER PROFILE PAGE
    if (Session::exists('loggedIn')) {
        if ($data->id == Session::get(Config::get('session.session_name'))) {
      Redirect::to('profile.php');
    }
    
  }
$username = Input::get('q_user');
$new_user = DB::connect()->select('users', array('username', '=', $username));
$new_user_rows = $new_user->results();
foreach($new_user_rows as $row) {
  $user_id = $row->id;
  // var_dump($user_id);
  // die();
}
$user_info = DB::connect()->select('additional_user_info', array('user_id', '=', $user_id));
$uir = $user_info->results();
foreach ($uir as $key) {
  // var_dump($key->bio);
  $rows = $key;
}
// $user_info = new User();
// if ($user_info->find_info($user_id) {
//   $rows = $user_info->user_info();
// }else {
//   $rows = null;
// }

$works = DB::connect()->select('work', array('user_Id', '=', $data->id));
$results = $works->results();
  // SELECT THE USER WORKS FROM THE WORK TABLE

//   $query = "SELECT * FROM work WHERE user_Id =".$user_id."";
//   $query_result = mysqli_query($conn, $query);
//   // $data = mysqli_fetch_assoc($query_result);

// }else {
//   header('Location: index.php');
// }
if(Session::exists('username')) {
$follow_user_id = $user_id;
$id = Session::get('userId');
$check_exist = DB::connect()->pdo_select('follow','=',array('follower_id','follows_user_id'),array($id,$follow_user_id));
$count_check = count($check_exist->pdo_results());
}


?>



<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title><?= $data->username ?> - Profile</title>
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
      .profile_image_container {
        height: 20rem;
        object-fit:cover;
      }
      .gender_text {
        font-size: 1.5rem;
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
<!-- HOLD LOGGEDIN SESSION -->
<p class="d-none" data_logged_in="<?php Session::exists('username') ? print true : print false  ?>" id="log_check" data_auth_id="<?php Session::get('userId') ? print Session::get('userId') : print false  ?>"></p>
<!-- login modal toggle -->
<p class="d-none" id="user_profile_id" data_user_profile_id="<?php echo $row->id ?>"></p>
<a href="" class="d-none" id="login" data-target="#Login" data-toggle="modal">Login</a>

<div class="container mt-3">


  <div class="row justify-content-center pt-5">
    <div class="col-md-4">
      <div class="m-3">
        <?php if($data->avatar == null): ?>
        <img src="./profile_image/default_image.jpg" class="profile_image_container img-fluid border rounded-circle border-danger p-1">
        <?php else: ?>
          <img src="<?php echo $data->avatar ;?>" class="profile_image_container img-fluid border rounded-circle w-100 border-danger p-1">
        <?php endif; ?>

      </div>
        </div>
  </div>



          <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        <div class="bio-section text-center">
          <h4 class="display-4 my-3" style="font-size: 2.3rem"> <i class="fa fa-user-tie"></i> <?= $data->username ?></h4>
          <div class="container">
              <h4 class="display-4 gender_text"><strong>Gender: <?= $data->gender ;?></strong></h4>
              <hr>
            </div>

            <!-- follow details -->
            
            <span class="followed_badge text-primary"></span><br>
            
            <a href="" class="btn btn-primary mt-3" id="follow_btn" data_user_id="<?= $row->id ?>"><strong>Follow</strong></a>
            <ul class="nav nav-tab my-4 justify-content-center mb-2 section-tab-nav" id="target">
            <li class="nav-item">
              <a data-toggle="modal" data-target="#followers_modal" class="nav-link text-danger followers" data-toggle="tab"><strong></strong> Followers</a>
            </li>
            <li class="nav-item">
              <a data-toggle="modal" data-target="#following_modal" class="nav-link text-danger following" data-toggle="tab"><strong></strong> Following</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-danger" data-toggle="tab"><strong><?= $works->count() ?></strong> Works</a>
            </li>
          </ul>

            
          <div class="jumbotron">
          <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-info-circle"></i> Bio</h4>
          <hr class="my-3">
         
          <?php if($rows->bio == null): ?>
          
            <p class="lead mb-3"><strong>Bio not available for this user.</strong></p>
            <?php else: ?>
          <p class="lead mb-5" style="font-size: 1.2rem"><?= $rows->bio ;?></p>

        <?php endif ; ?>
        </div>

          <div class="container jumbotron">
            <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-info"></i> Contact Info</h4>
          <hr class="my-3">
          <div class="container">
            <p class="lead text-info">If you like <strong><?= $data->username ?>'s</strong> Work, Follow the links below to link up or E-mail!</p>
          </div>
          <div style="opacity: 0.9">
            <a href="https://www.instagram.com/<?php isset($rows->instagram) ? print $rows->instagram : print '' ;?>" class="btn" target="_blank"><i class="fab fa-instagram"></i> <strong><?php isset($rows->instagram) ? print $rows->instagram : print 'N/A' ;?></strong></a>
            <a href="https://www.twitter.com/<?php isset($rows->twitter) ? print $rows->twitter : print '' ;?>" class="btn" target="_blank"><i class="fab fa-twitter"></i> <strong><?php isset($rows->twitter) ? print $rows->twitter : print 'N/A' ;?></strong></a>
            <a href="https://www.facebook.com/<?php isset($rows->facebook) ? print $rows->facebook : print '' ;?>" class="btn" target="_blank"><i class="fab fa-facebook-square"></i> <strong><?php isset($rows->facebook) ? print $rows->facebook : print 'N/A' ;?></strong></a>
            <a href="mailto:<?= $data->email?>" class="btn" target="_blank"><i class="fa fa-envelope"></i> <strong><?= $data->email ?></strong></a>
            <a href="tel:<?= $data->phone?>" class="btn" target="_blank"><i class="fa fa-phone"></i> <strong><?= $data->phone ?></strong></a>
            
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



<!-- Login Modal -->
<div class="modal fade" id="Login">
   <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
            <h4>Login</h4>
            <span class="close" data-dismiss="modal">&times;</span> 
         </div>  
         <div class="modal-body">
          <p id="logInerrorMsg" class="text-danger text-center"></p>
            <form>
              <label><strong>Email</strong></label>
            <input type="email" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Enter Your Email Address" required="required" id="email">
            <label><strong>Password</strong></label>
            <div class="pass_container p-0 m-0">
            <input type="password" name="" class="navbar-xtrim-search-input mb-3 Lform" placeholder="Type in your Password" required="required" id="pass"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
            </div>

            <div class="custom-control custom-checkbox my-2">
              <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me">
              <label class="custom-control-label" for="remember_me">Remember Me</label>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate() ;?>" id="login_token">
            <div class=" mt-4 d-flex justify-content-between align-items-center">
            <!-- <button type="button" class="btn btn-success">Login</button> -->
            <input type="submit" id="loginBtn" name="" class="btn btn-primary btn-lg" value="Login" style="border-radius: 2px">
            <a href="./forgot_password.php" class="lead forgot">I forgot my password</a>
            </div>
            <hr class="my-4">
            <div class="container d-flex justify-content-center">
              
              <p class="lead" style="font-size: 1.3rem">Don't have an account? <a href="./signup.php">Create Account</a></p>
            </div>
            </form>
         </div>

       </div>
   </div> 
</div>
<!-- End of Login Modal -->

<!-- The View Image Modal -->
<div class="modal" id="view_image">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Preview</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <img src="" id="preview_img_modal" class="img-fluid w-100">

          <!-- <p class="lead mt-2 mb-0" style="color: black"><strong id="work_title_text"></strong></p>
          <p id="work_description_text" class="lead my-0"></p> -->
          <a href="" class="mt-2 btn btn-primary" id="read_more_btn">More Info</a>

        </div>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

    </div>
  </div>
</div>

          <!-- All user posts -->
<div class="container">
  <div class="text-center mt-1">
    
  <h4 class="display-4" style="font-size: 2rem"><i class="fa fa-cloud-upload-alt"></i> Works by this user.</h4>
    <hr class="mb-4">
  </div>
<div class="container pt-2">
  <div class="row">
    <?php foreach($results as $row): ?>
    <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3 btn-wrapper">
        <div class="Card">
        <div class="img img-wrapper">
          <img src="<?= $row->img_dir ;?>" class="img-fluid img-link" data_post_id="<?= $row->id ?>" data_user_id="<?= $row->user_id ;?>" data-toggle="modal" data-target="#view_image"> 
      <div class="btns test-btn" data_user_id="<?= $row->user_Id ;?>">
        <span><a href="view_work.php?id=<?= $row->id ?>" class="view_link"><i class="fa fa-eye" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
        <span><i class="fa fa-heart" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></span>
        <span title="Comment"><a href="./comments.php?ci=<?= $row->work_id ?>" class="view_link"><i class="fa fa-comments" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->work_id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
     </div>
        </div> 

    </div>
    <div>
    <p class="d-none work_title" data_work_title="<?php echo ucwords($row->work_title) ?>"></p>
    <p class="d-none work_description" data_work_description="<?php echo ucfirst($row->work_description) ?>"></p>
    </div>
    </div>

<?php endforeach ; ?>
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
    $('.img-link').click(function(){
      let post_id = $(this).attr('data_post_id');
    // var work_title = $(this).parent().parent().next().children().first().attr('data_work_title');
    // var work_description = $(this).parent().parent().next().children().last().attr('data_work_description');
      // alert(work_title);
      // $('#work_title_text').text(work_title);
      // $('#work_description_text').text(work_description);
      // console.log(work_title);
      $("#read_more_btn").attr('href','view_work.php?id='+post_id+'');
      var img_src = $(this).attr('src');
      $('#preview_img_modal').attr('src',img_src);

    });
    function check_loggedInUser() {
    var element = $("#log_check").attr("data_logged_in");
    if (element) {
      return true;
    } else {
      return false;
    }
  }
// get_followers();
check_follow();


// send request on button click



// check for followed / unfollowed records in database
function check_follow() {
  if(check_loggedInUser()) {
    let follow_user_id = <?php echo $user_id ?>;
    let follower_id = <?php echo Session::get('userId') ?>;
   
    $.ajax({
      url: 'server.php',
      method: 'GET',
      dataType: 'text',
      data: {follower_id:follower_id,follow_user_id:follow_user_id,get_follows:1},
      success:function(response) {
 

        if(response === 'user_follows') {
          $('.followed_badge').html('Following <i class="fa fa-check"></i>');
          $('#follow_btn strong').text('unfollow');
        }else {
          $('.followed_badge').html('');
          $('#follow_btn strong').text('follow');
        }
      }
    });
  }
}
  });
</script>
</body>
</html>