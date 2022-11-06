<?php 
require_once 'core/init.php';


// IF THE GET - Q_USER NOT SET, REDIRECT TO THE HOMEPAGE
if (!$work_id = Input::get('id')) {
  Redirect::to('index.php');
}else {

  // $user_id = isset(Session::exists('userId')) ? Session::get('userId') : null;
  if(Session::exists('userId')) {
    $user_id = Session::get('userId');
  }else {
    $user_id = null;
  }

  // check table if work_id exist, add count to it
  $count_check = DB::connect()->select('views', array('work_id', '=', $work_id));
  $views_count = $count_check->results()[0]->count;
  // var_dump($views_count+1);
  if($views_count >= 1) {
    DB::connect()->update_reaction('views', $work_id, array(
      'count' => $views_count + 1,
      'action' => 'view'
    ));
  }else {
    $query = DB::connect()->insert('views',array(
      'user_id' => $user_id,
      'work_id' => $work_id,
      'count' => 1,
      'action' => 'view'
    ));
  }
  $work = DB::connect()->select('work', array('id','=',$work_id));
  if ($work->count() < 1) {
    Redirect::to(404);
  }else {
    $data = $work->results()[0];
    $user = new User($data->user_Id);

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
//     if (Session::exists('loggedIn')) {
//         if ($data->id == Session::get(Config::get('session.session_name'))) {
//       Redirect::to('profile.php');
//     }
    
//   }
// $username = Input::get('q_user');
// $new_user = DB::connect()->select('users', array('username', '=', $username));
// $new_user_rows = $new_user->results();
// foreach($new_user_rows as $row) {
//   $user_id = $row->id;
//   // var_dump($user_id);
//   // die();
// }
// $user_info = DB::connect()->select('additional_user_info', array('user_id', '=', $user_id));
// $uir = $user_info->results();
// foreach ($uir as $key) {
//   // var_dump($key->bio);
//   $rows = $key;
// }
// // $user_info = new User();
// // if ($user_info->find_info($user_id) {
// //   $rows = $user_info->user_info();
// // }else {
// //   $rows = null;
// // }

// $works = DB::connect()->select('work', array('user_Id', '=', $data->id));
// $results = $works->results();
  // SELECT THE USER WORKS FROM THE WORK TABLE

//   $query = "SELECT * FROM work WHERE user_Id =".$user_id."";
//   $query_result = mysqli_query($conn, $query);
//   // $data = mysqli_fetch_assoc($query_result);

// }else {
//   header('Location: index.php');
// }

?>



<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>(<?= $data->work_title ?>) - Details</title>
	<!-- <link href="./public/css/all.min.css" rel="stylesheet"> -->
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
    .work_description {
        font-family:sansation_bold;
    } 
    /* .work_description .list-group-item {
        background: white !important;
    } */
    .work_description .list-group-item b {
        opacity:0.8;
    }
    .work_image {
        height:21rem;
    }
    .test-btn {
        opacity:0.8 !important;
        justify-content: space-between;
    }
    .test-btn span {
      transition: all 0.5s ease;
        font-size: 1.5rem;
    }
    .test-btn span:hover > i {
      transform: scale(1.1);
    }
    </style>
</head>
<body>
<a href="" class="btn btn-light ml-2 mt-3 back_btn"><i class="fa fa-arrow-left"></i> Back</a>
<hr>
<!-- HOLD LOGGEDIN SESSION -->
<p class="d-none" data_logged_in="<?php Session::exists('username') ? print true : print false  ?>" id="log_check" data_auth_id="<?php Session::get('userId') ? print Session::get('userId') : print false  ?>"></p>
<!-- login modal toggle -->
<a href="" class="d-none" id="login" data-target="#Login" data-toggle="modal">Login</a>

<div class="container mt-5 pt-2">
    <div class="row justify-content-center align-items-start">
        <div class="col-md-4">
            <img src="<?= $data->img_dir ?>" alt="<?= $data->img_name ?>" class="w-100 work_image img-fluid"><br>
            <div class="btns test-btn mt-3" data_user_id="<?= Session::get('userId') ;?>">
                <span><i class="fa fa-eye" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $data->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></span>
                <span><i class="fa fa-heart" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $data->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></span>
                <span title="Comment"><a href="./comments.php?ci=<?= $data->id ?>" class="view_link"><i class="fa fa-comments" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $data->id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
            </div>
            <hr>
            <div>
            <!-- <form action="">
            <div class="form-group">
            <textarea name="" placeholder="Enter Your Comment here..." class="form-control"></textarea>
            </div>
            <div class="form-group">
            <input type="submit" value="Comment">
            </div>
            </form> -->
            <a href="comments.php?ci=<?= $data->id ?>" title="Comment" class="btn btn-light">View Comments</a>

            </div>
        </div>
        <div class="col-md-6">
        <ul class="list-group list-group-flush work_description">
            <li class="list-group-item"><b>Title:</b> <?= ucwords($data->work_title) ?></li>
            <li class="list-group-item"><b>Category:</b> <?= ucwords($data->category) ?></li>
            <li class="list-group-item"><b>Art name:</b> <?= ucwords($data->img_name) ?></li>
            <li class="list-group-item"><b>Description:</b> <?= ucwords($data->work_description) ?></li>
            <li class="list-group-item"><b>Tag:</b> <?= ucwords($data->tag) ?></li>
            <li class="list-group-item"><b>Artist Name:</b> <?= ucwords($user->data()->username) ?></li>
            <?php $date_time = date("d-M-Y", strtotime($data->uploaded_on)); ?>
            <li class="list-group-item"><b>Time:</b> <?= $date_time ?></li>
        </ul>
        <a href="user_profile.php?q_user=<?= $user->data()->username ?>" class="btn btn-primary float-right mt-2">View Artist Profile</a>
        </div>
    </div>
    
</div>





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

<!-- Guest comment -->
<!-- The Modal -->
<div class="modal" id="guest_comment_modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Guest Comment</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
             
      <form action="" class="w-100 mt-3">
            <h4><b>Add a comment</b></h4>
            <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter your fullname">
            </div>
            <div class="form-group">
            <textarea name="" placeholder="Enter Your Comment here..." class="form-control"></textarea>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Comment">
            </div>
            </form>
      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer justify-content-start">

      </div> -->

    </div>
  </div>
</div>
<!-- MODALS -->
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./script.js"></script>
<script type="text/javascript" src="./js/timeago.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $('time.timeago').timeago();
    $('.img-link').click(function(){
    var work_title = $(this).parent().parent().next().children().first().attr('data_work_title');
    var work_description = $(this).parent().parent().next().children().last().attr('data_work_description');
      // alert(work_title);
      $('#work_title_text').text(work_title);
      $('#work_description_text').text(work_description);
      // console.log(work_title);
      var img_src = $(this).attr('src');
      $('#preview_img_modal').attr('src',img_src);

    });

  });
</script>
</body>
</html>