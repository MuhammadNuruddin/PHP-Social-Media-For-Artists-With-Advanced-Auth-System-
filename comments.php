<?php 
require_once 'core/init.php';


// // IF THE GET - Q_USER NOT SET, REDIRECT TO THE HOMEPAGE
// if (!$work_id = Input::get('id')) {
//   Redirect::to('index.php');
// }else {

//   // $user_id = isset(Session::exists('userId')) ? Session::get('userId') : null;
//   if(Session::exists('userId')) {
//     $user_id = Session::get('userId');
//   }else {
//     $user_id = null;
//   }

//   // check table if work_id exist, add count to it
//   $count_check = DB::connect()->select('views', array('work_id', '=', $work_id));
//   $views_count = $count_check->results()[0]->count;
//   // var_dump($views_count+1);
//   if($views_count >= 1) {
//     DB::connect()->update_reaction('views', $work_id, array(
//       'count' => $views_count + 1,
//       'action' => 'view'
//     ));
//   }else {
//     $query = DB::connect()->insert('views',array(
//       'user_id' => $user_id,
//       'work_id' => $work_id,
//       'count' => 1,
//       'action' => 'view'
//     ));
//   }
//   $work = DB::connect()->select('work', array('id','=',$work_id));
//   if ($work->count() < 1) {
//     Redirect::to(404);
//   }else {
//     $data = $work->results()[0];
//     $user = new User($data->user_Id);

//   }
// }



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
	<title>Xtriim - Comments</title>
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

    </style>
</head>
<body>
<a href="" class="btn btn-light ml-2 mt-3 back_btn"><i class="fa fa-arrow-left"></i> Back</a>
<hr>
<!-- HOLD LOGGEDIN SESSION -->
<p class="d-none" data_logged_in="<?php Session::exists('username') ? print true : print false  ?>" id="log_check" data_auth_id="<?php Session::get('userId') ? print Session::get('userId') : print false  ?>"></p>
<!-- login modal toggle -->
<p class="d-none" id="data_work_id" data_work_id="<?= Input::get('ci') ;?>"></p>
<a href="" class="d-none" id="login" data-target="#Login" data-toggle="modal">Login</a>
<div class="container mt-4">
    
    <div class="row justify-content-center">
    
    <div class="col-xs-12 col-sm-12 col-lg-8 col-md-6">
    <?php if (Session::exists('username')): ?>
        <form class="w-100 mt-3">
     
            <h4><b>Add a comment</b></h4>
            <p class="text-danger comment_error mt-2"></p>
            <div class="form-group">
            <textarea name="comment_text" id="comment_text" placeholder="Enter Your Comment here..." class="form-control"></textarea>
            </div>
            <input type="hidden" id="user_id" value="<?= Session::get('userId') ?>">
            <input type="hidden" id="work_id" value="<?= Input::get('ci') ?>">
            <div class="form-group">
            <input type="submit" id="submit_comment" class="btn btn-primary" value="Comment">
            </div>
            
            </form>
    <?php else: ?>
        <form action="" class="w-100 mt-3">

            <h4><b>Add public comment</b></h4>
            <p class="text-info">Sorry you are not logged in, but you can comment as a guest</p>
            <p class="text-danger guest_comment_error mt-2"></p>
            <div class="form-group">
            <input type="text" id="guest_fullname" class="form-control" placeholder="Enter your fullname">
            </div>
            <div class="form-group">
            <textarea name="" id="guest_comment" placeholder="Enter Your Comment here..." class="form-control"></textarea>
            </div>
            <input type="hidden" id="work_id" value="<?= Input::get('ci') ?>">
            <div class="form-group">
            <input type="submit" id="guest_comment_btn" class="btn btn-primary" value="Comment">
            </div>
            </form>
    <?php endif ;?>
    <hr>
    <div class="d-flex justify-content-between mb-5"><h2>Comments</h2> <h4>#<span id="comment-count"></span></h4></div>
    <div class="comments" style="overflow-y:scroll">

    </div>

    </div>
    </div>
</div>
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./script.js"></script>
<script type="text/javascript" src="./js/timeago.js"></script>

<script>
$(document).ready(function(){
  $('time.timeago').timeago();
      // let comment = $('.comment');
  // console.log(comment);
      // count = 0;
      // for (let index = 0; index < comment.length; index++) {
      //   count++; 
      // }
      
      
      // $('#comment-count').text(count);
});
</script>
</body>
</html>