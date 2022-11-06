<?php 


require_once 'core/init.php';



// $query = "SELECT users.user_id, users.username,users.profile_image,work.id,work.user_Id,work.work_description,work.work_title,work.uploaded_on,work.img_dir,work.img_dir FROM users INNER JOIN work ON users.user_id = work.user_Id ORDER BY work.uploaded_on DESC LIMIT 0,12";
// $result = mysqli_query($conn,$query);

$query = DB::connect()->query("SELECT users.id, users.username,users.avatar,work.id as work_id,work.user_Id,work.work_description,work.work_title,work.uploaded_on,work.img_name,work.img_dir FROM users INNER JOIN work ON users.id = work.user_Id ORDER BY work.uploaded_on DESC LIMIT 0,18");

$rows = $query->results();

// var_dump($rows);
// foreach ($rows as $row) {
//   var_dump($row);
// }

// $user_id = $result['user_Id'];
// if (isset($_SESSION['userId'])) {
//   $sql = "SELECT * FROM users WHERE user_id=".$_SESSION['userId']."";
//   $sql_result = mysqli_query($conn, $sql);
//   $sql_row = mysqli_fetch_assoc($sql_result);
// }


// while ($sql_result = mysqli_fetch_assoc($sql)) {
//  $username = $sql_result['username'];
//  $user_profile_image = $sql_result['profile_image'];
//  $userID = $sql_result['user_id'];
// }


?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Xtriim - Index</title>
  <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700,900" rel="stylesheet">
	<link href="./fontawesome/css/all.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">
      #gender_select {
        box-shadow: none !important;
        outline: none !important;
      }
      .modal {
        height: 100vh !important;
        width: 100vw !important;
        overflow-x: hidden !important;
      }



        @media (min-width: 90px) and (max-width: 768px){
        .hero-text h4.display-4 {
            color:white;
            font-size: 2.2rem !important;
            font-weight: bold;
        }
        .hero-text h5,h6 {
          font-size: 1.1rem !important;
        }
    

    }
        @media (min-width: 90px) and (max-width: 340px){
        .hero-text h4.display-4 {
            color:white;
            font-size: 2rem !important;
            font-weight: bold;
        }
        .hero-text h5,h6 {
          font-size: 0.9rem !important;
        }
        
        .hero-text h4.text-success {
          font-size: 0.8rem !important;
        }

    }
    @media (orientation: landscape) and (max-width: 768px) {
        .hero-text h4.display-4 {
            color:white;
            font-size: 2rem !important;
            font-weight: bold;
            margin-top: 0.4rem;
        }
        .hero-text h5,h6 {
          font-size: 0.9rem !important;
        }
        
        .hero-text h4.text-success {
          margin-top: 0.2rem !important;
          font-size: 0.8rem !important;
        }      
    }
    #work_description_text {
      width: 90%;
      padding-right: 0.7rem;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
      position: relative;
    }

    .dropdown-toggle::after {
      display: none !important;
    }

    .error-border {
      border: 1px solid #dc3545 !important;
    }
    #work_description_text {
      opacity: 0.79;
      font-size: 1rem;
    }
    #dynamic_hero_image {
      transition: all 1s ease-in-out;
      animation:change 1s linear;
      background-position: center;
      background-size: cover;
    }
    /* @keyframes change {
  0% {
    opacity:1;
  100% {
    opacity:0.8;
  }
} */

    </style>
    <link rel="stylesheet" type="text/css" href="./style.css">

</head>
<body class="bg-light">



<div class="navbar-xtrim navbar navbar-expand-md">
  <div class="container">
	<div class="xtrim"><a href="./index.php" class="navbar-brand text-white"><?php echo Config::get('app.name'); ?></a></div>
<form class="navbar-xtrim-search">
			<div class="search">
				<input type="text" name="" class="navbar-xtrim-search-input" id="searchInput" placeholder="Search Something">
			<button type="submit" class="navbar-xtrim-search-btn">
				<i class="fa fa-search"></i>
			</button></div>
			
</form>
<!-- Mobile Navbar -->
        <nav class="mobile_navbar">
          <div class="sidebar_wrapper mt-3">
            <div class="my-4">
            <span>
              <a href="" class="btn" id="close_sidebar_btn"><i class="fa fa-times"></i></a>
            </span>
            </div>
          <ul class="sidebar_menu">
            <?php if(Session::exists('username') || Cookie::exists(Config::get('remember.cookie_name'))): ?>
              <h4 class="display-4 my-2"><?php echo Session::get('username') ;?></h4>
            <li><a href="profile.php" class="btn pl-0 btn-customized">Profile <i class="fa fa-user-cog"></i></a></li>
            <li><a href="" class="btn pl-0 btn-customized">Settings <i class="fa fa-cogs"></i></a></li>
            <li><a href="logout.php" class="btn pl-0 btn-customized">Logout <i class="fa fa-sign-out-alt"></i></a></li>
              <?php else: ?>
            <li><a href="" class="btn pl-0 btn-customized" data-toggle="modal" id="mobile_logIn" data-target="#Login">Login <i class="fa fa-sign-in-alt"></i></a></li>
            <li><a href="" class="btn pl-0 btn-customized" data-toggle="modal" data-target="#Register">Register <i class="fa fa-user-plus"></i></a></li>
            <li><a href="upload.php" class="btn pl-0 btn-customized" data_logged_in="<?php Session::get('username') ? print true : print false  ?>" id="mobile_upload_btn">Upload <i class="fa fa-cloud-upload-alt"></i></a></li>
          <?php endif ; ?>
            <li class="divider my-3"></li>
            <li><a href="" class="menu-links">About Us</a></li>
            <li><a href="" class="menu-links">Services</a></li>
            <li><a href="" class="menu-links">Contact Us</a></li>
            <li><a href="" class="menu-links">Works</a></li>
            <li><a href="" class="menu-links">Media</a></li>
          </ul>
          </div>
          <div class="sidebar_menu_overlay"></div>
        </nav> 
	<div class="navbar-xtrim-right hidden-xs hidden-sm">


<!-- 		<a href="" class="navbar-xtrim-item navbar-xtrim-link" style="text-decoration: none;">
			<div class="badge-container">
				<i class="far fa-bell"></i>
				<div class="badge badge-blue" style="font-weight: lighter;">6</div>
			</div>
		</a> -->

		<!-- <div class="navbar-xtrim-item"> -->
			<div class="dropdown">
  <a href="#target" class="navbar-xtrim-item navbar-xtrim-button btn mr-1 text-white" style="background-color: transparent;border-color: transparent;">Exlpore <i class="fa fa-globe"></i></a>
    <a href="upload" class="navbar-xtrim-item navbar-xtrim-button btn btn-danger" data_logged_in="<?php Session::exists('username') ? print true : print false  ?>" id="upload_btn">Upload <i class="fa fa-cloud-upload-alt"></i></a>
                <!-- <img src="../image/person.jpg" id="popover-avatar" data-placement="bottom" title="Account">
				<ul class="dropdown-menu dropdown-menu-right navbar-xtrim-dropdwon-menu">
					<li><a href="" data-target="#Login" data-toggle="modal">Login <i class="fa fa-sign-in-alt"></i></a></li>
					<hr class="my-0 mx-3 bg-light ">
					<li><a href="" data-target="#Register" data-toggle="modal">Register <i class="fa fa-user-plus"></i></a></li>
				</ul> -->
			<!-- </div> -->
		</div>
  <div>
        <?php if (Session::exists('loggedIn') || Cookie::exists(Config::get('remember.cookie_name'))): ?>
          <div class="dropdown">
            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" style="background: transparent;border:transparent;">
              <span class="navbar-xtrim-button"><strong><b><i class="fa fa-user mr-1"></i><?php echo Session::get('username'); ?></b></strong></span> 

            </button>

            
            <div class="dropdown-menu">
              <a href="./logout.php" class="btn btn-outline-light navbar-xtrim-button dropdown-item" style="display: flex;justify-content: space-between;align-items: center;">Logout <i class="fa fa-sign-out-alt"></i></a>
              <a href="./profile.php" class="btn btn-outline-light navbar-xtrim-button dropdown-item" style="display: flex;justify-content: space-between;align-items: center;">My profile <i class="fa fa-user-cog"></i></a>
              <a class="dropdown-item btn btn-outline-light navbar-xtrim-button" href="#" style="display: flex;justify-content: space-between;align-items: center;">Settings <i class="fa fa-cogs"></i></a>
            </div>
          </div>
          
          <?php else:  ?>
            <a href="" class="btn btn-dark navbar-xtrim-button mr-1" id="login" data-target="#Login" data-toggle="modal" style="background-color: transparent;border-color: transparent;">Login <i class="fa fa-sign-in-alt"></i></a>
            <a href="" class="btn btn-danger navbar-xtrim-button" id="signin" data-target="#Register" data-toggle="modal">Register <i class="fa fa-user-plus"></i></a>
      <?php endif; ?>
      </div>

	</div>
	   <button type="button" class="navbar-toggler" data-toggle="collapse" id="navbar_toggler_btn" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" style="border-color: transparent;">
            <span><i class="fas fa-bars text-white"></i></span>
        </button>   
</div> 
</div>





<!-- HOLD LOGGEDIN SESSION -->
<p class="d-none" data_logged_in="<?php Session::exists('username') ? print true : print false  ?>" id="log_check" data_auth_id="<?php Session::get('userId') ? print Session::get('userId') : print false  ?>"></p>




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
              
              <p class="lead" style="font-size: 1.3rem">Don't have an account? <a href="./signup.php" data-target="#Register" data-toggle="modal">Create Account</a></p>
            </div>
            </form>
         </div>

       </div>
   </div> 
</div>
<!-- End of Login Modal -->

<!-- Register Modal -->

<div class="modal fade" id="Register">
   <div class="modal-dialog modal-lg">
       <div class="modal-content">
         <div class="modal-header">
            <h4>Register Account</h4>
            <span class="close" data-dismiss="modal">&times;</span> 
         </div>  
         <div class="modal-body">
          <p id="errorMsg" class="text-danger text-center"></p>
          <p class="text-success text-center"><strong id="successMsg"></strong></p>
            <form class="mt-2">
              <label><strong>Username</strong></label>
            <input type="text"  id="Username" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Choose Username">
            <label><strong>Email</strong></label>
            <input type="email"  id="Email" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Email Address">
            <label><strong>Phone</strong></label>
            <input type="tel"  id="Phone" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Phone Number">
            <label><strong>Select Gender:</strong></label>
            <select id="gender_select" class="form-control mb-4" style="border-radius: 0">
              <option class="gender_option" selected="selected">Male</option>
              <option class="gender_option">Female</option>
              <option class="gender_option">Other</option>
            </select>
            <label><strong>Password</strong></label>
            <div class="pass_container p-0 m-0">
            <input type="password"  id="Password" name="" id="passSignIn" class="navbar-xtrim-search-input mb-4 Lform" placeholder="Password"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
          </div>
          <label><strong>Confirm password</strong></label>
            <div class="pass_container p-0 m-0">
            <input type="password"  id="Vpassword" name="" id="vpass" class="navbar-xtrim-search-input mb-4 Lform" placeholder="Re-type Password"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate() ;?>" id="signin_token">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="check" class="custom-control-input" id="custom_check" required="required">
                    <label class="custom-control-label" for="custom_check" style="font-size: 100%;font-weight:bold;">
                        I read and accept the <a href="#">terms and conditions.</a>
                    </label> 
                </div>
            </div>
            <input type="submit" id="submit" name="" class="btn btn-primary btn-lg mt-2" value="Create Account" style="border-radius: 2px">
            <hr class="my-4">
            <div class="container d-flex justify-content-center">
              
              <p class="lead" style="font-size: 1.3rem">Already have an account? <a href="./login.php" id="close_signin_modal">Login</a></p>
            </div>
            </form>
         </div>

       </div>
   </div> 
</div>
<!-- End of Register Modal -->

<!-- COMMENT MODAL -->
<!-- The Modal -->
<div class="modal" id="comment_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Comments</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" style="overflow-y:scroll;height:15rem">
            <div class="comments"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-start">
        <?php if(Session::exists('username')): ?>
          <form class="w-100 mt-3">
            
            <h4><b>Add a comment</b></h4>
            <p class="text-danger comment_error mt-2"></p>
            <div class="form-group">
            <textarea name="comment_text" id="comment_text" placeholder="Enter Your Comment here..." class="form-control"></textarea>
            </div>
            <input type="hidden" id="user_id" value="<?= Session::get('userId') ?>">
            <div class="form-group">
            <input type="submit" id="submit_comment" class="btn btn-primary" value="Comment">
            </div>
            
            </form>
            <?php else: ?>
            <p class="text-danger mt-2">Sorry, You're not logged in... <a href="./login.php" class="btn btn-light">Login</a> | <a href="#" data-toggle="modal" data-target="#guest_comment_modal" title="Guest Comment" class="btn btn-light">Comment as guest</a></p>
            
            <?php endif; ?>
      </div>

    </div>
  </div>
</div>
<!-- END OF COMMENT MODAL -->

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

<!-- guest comment -->
<!-- <div class="xtrim-wrapper">
	<div class="sidebar"></div>
	<div class="main-content"></div>
	<div class="all-files"></div>	
</div> -->

       <div class="hero-image" id="dynamic_hero_image">
           <div class="container hero-text">
            <h4 class="display-4 bold-text">The Home for your beautiful paintworks and drawings.</h4>
            <h5 class="lead">Show the world how creative you are by showcasing some of your artworks today.</h5>  
            <h6 class="lead">Upload, access, and share your drawings/paintings from any device, from anywhere in the world</h6> 
            <?php if(Session::exists('loggedIn')): ?>

            <h4 class="text-success mt-4">Upload your best work <br> and stand a chance to compete in the <br><strong><a href="" class="text-white d-inline-block mt-3"><span class="design_challenge"><i class="fa fa-medal"></i> Design Of the Week Challenge <i class="fa fa-medal"></i></span></a></strong></h4>
            <a href="upload.php" class="btn btn-danger btn-lg mt-3" style="border-radius: 1px">Upload Now  <i class="fa fa-upload"></i></a>
            <?php else : ?>
            <a href="./signup.php" class="btn btn-danger btn-lg mt-3" style="border-radius: 1px">Sign Up Now</a>
          <?php endif ; ?>
           </div>
       </div>

<div>
</div>



<!-- <div class="Modal" id="simpleModal">
   <span><i class="far fa-caret-square-left btnLeft controlBtn"></i></span>
   <span><i class="far fa-caret-square-right btnRight controlBtn"></i></span>
 <div class="Modal-content">
   <div class="modal-head">
         <div class="right">
            <div class="info">
               <img src="../image/person.jpg" id="userImg" style="width: 40px;border-radius: 50%;height: 40px;border: 1px solid rgba(0,0,0,0.3)">
               <span class="name"><a href="#" style="text-decoration: none;color: rgba(0,0,0,0.7);">Cybernetic_Organism</a></span>
            </div>
            <span class="closeBtn"><i class="far fa-window-close"></i></span>
         </div>
   </div>
         
   
    <div class="container px-0">
      <div class="img-container">
        <img src="../background/img1.jpg" class="img-fluid" id="modalImg"> 
      </div>
       
    </div>
 </div>  
</div> -->


<!-- The View Image Modal -->
<div class="modal" id="view_image">
  <div class="modal-dialog">
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

          <a href="" class="btn btn-primary my-3" id="read_more_btn">More Info</a>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MESSAGE FOR DISABLED JAVASCRIPT -->

<noscript>
  <div class="container my-4">
    <div class="alert alert-danger">
    <strong>You need to enable JAVASCRIPT before using this site!</strong>
    </div>    
  </div>

</noscript>

<div class="container-fluid mb-3 bg-light" style="border-top: 3px solid silver;border-bottom: 2px solid silver">

<!-- Nav tabs -->
<div class="container">
  <ul class="nav nav-tab mt-2 justify-content-center mb-2 section-tab-nav" id="target">
  <li class="nav-item">
    <a class="nav-link nav-filter active" data-toggle="tab" href="#New">New</a>
  </li>
  <li class="nav-item">
    <a class="nav-link nav-filter" data-toggle="tab" href="#Popular">Popular</a>
  </li>
  <li class="nav-item">
    <a class="nav-link nav-filter" data-toggle="tab" href="#All">All</a>
  </li>
</ul>
</div>
</div>
<div class="container">
 
<!-- <hr class="mt-0 mb-2 bg-danger">   -->

<!-- Tab panes -->
<div class="tab-content">
    <!-- First tab starts here... -->
<div class="tab-pane container active" id="All">
    <!-- grid system row starts.. -->
<div class="row filter_results">

<?php foreach($rows as $row): ?> 

<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?= $row->img_dir ;?>" class="img-fluid img-link" data_user_id="<?= $row->id ;?>" data-toggle="modal" data-target="#view_image" data_post_id="<?= $row->work_id ?>"> 
  <div class="btns test-btn" data_user_id="<?= Session::get('userId') ;?>">
    <span><a href="view_work.php?id=<?= $row->work_id ?>" class="view_link"><i class="fa fa-eye" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->work_id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
    <span><i class="fa fa-heart" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->work_id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></span>
    <span title="Comment"><a href="./comments.php?ci=<?= $row->work_id ?>" class="view_link"><i class="fa fa-comments" data_user_id="<?= Session::get('userId') ?>" data_post_id="<?= $row->work_id ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> <strong></strong></a></span>
 </div>
    </div> 

</div>
<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="<?php 
isset($row->avatar) ? print $row->avatar : print './profile_image/default_image.jpg';?>" class="card-image">  <a href="user_profile.php?q_user=<?php echo $row->username ;?>"><?= $row->username ;?></a></span>
<div>
<p class="d-none work_title" data_work_title="<?= ucwords($row->work_title) ;?>"></p>
<p class="d-none work_description" data_work_description="<?= ucfirst($row->work_description) ;?>"></p>
</div>
</div>

 <?php endforeach ; ?> 

</div>
<hr>
<!-- end of grid row -->
<div class="container d-flex align-items-center justify-content-center my-4">
    <button class="btn btn-danger btn-lg">Load More</button>
</div>
</div>
<!-- end of first Tab -->

   
</div><!-- end of container -->
</div>




<div id="newsletter" class="section">
            <!-- container -->
    
                <!-- /row -->
            
            <!-- /container -->
        </div>





<footer id="footer">
 <div class="section" style="background: #E4E7ED;">
                <!-- container -->
                <div class="container">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-4 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">About Us</h3>
                                <p class="lead text-info">We unveil your creativity to the world. By simply uploading some of your works, we promote them you. Just keep 'em coming!</p>
                                <ul class="footer-links">
                                    <li><a href="#"><i class="fa fa-map-marker-alt"></i>Muhammad Nuruddin</a></li>
                                    <li><a href="tel:09039668763"><i class="fa fa-phone"></i>Call - 09039668763</a></li>
                                    <li><a href="mailto:Nuruddin6ix@gmail.com"><i class="far fa-envelope"></i>Email - Nuruddin6ix@gmail.com</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Categories</h3>
                                <ul class="footer-links">
                                    <li><a href="./index.php?tag=Hot-Deals">Hot Deals</a></li>
                                    <li><a href="./index.php?category=painting">Nature Painting</a></li>
                                    <li><a href="./index.php?category=sketch">Color Sketching</a></li>
                                    <li><a href="./index.php?category=sketch">Pencil Sketch</a></li>
                                    <li><a href="./index.php?category=graffiti">Graffiti</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="clearfix visible-xs"></div>

                        <div class="col-md-4 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Information</h3>
                                <ul class="footer-links">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /row -->
                </div>
                <!-- /container -->
            </div>
<div id="bottom-footer" class="section">
                <div class="container">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span class="copyright">
                                XTRIM Copyright © 2019 All rights reserved || Designed and developed by <a href="https://www.github.com/MuhammadNuruddin" target="_blank" style="font-size: 1.2rem;text-decoration: none;">MuhammadNuruddin</a>
                            </span>
                        </div>
                    </div>
                        <!-- /row -->
                </div>
                <!-- /container -->
            </div>   
</footer>
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="./script.js"></script>
<script type="text/javascript" src="./js/timeago.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    $("#submit").attr('disabled','disabled');
  $("#custom_check").change(function() {
    if($("#custom_check").prop('checked') == false) {
    $("#submit").attr('disabled','disabled');
  }else {
    $("#submit").attr('disabled',null);
  }
  });


    $('.img-link').click(function(){
      let uploaded_by_username = $(this).parent().parent().next().children().last().text();
      let uploaded_by_user_img = $(this).parent().parent().next().children().first().attr('src');
      let post_id = $(this).attr('data_post_id');
      $('.uploaded_by_user_img').attr('src',uploaded_by_user_img);
      $('.uploaded_by_username').text(uploaded_by_username).addClass('ml-1');

    // let work_title = $(this).parent().parent().next().next().children().first().attr('data_work_title');
    // let work_description = $(this).parent().parent().next().next().children().last().attr('data_work_description');
    //   $('#work_title_text').text(work_title);
    //   $('#work_description_text').text(work_description);
      let img_src = $(this).attr('src');
      $('#preview_img_modal').attr('src',img_src);
      $("#read_more_btn").attr('href','view_work.php?id='+post_id+'');
    });

$('#close_signin_modal').click(function(){
$('#Register').modal('hide');
$('#Login').modal('show');
});


// console.log(img_dirs);

  // Function to grab works from database
  get_works();

function get_works() {
  $.ajax({
    url: 'server.php',
    method: 'GET',
    dataType: 'JSON',
    data:{get_works:1},
    success:function(response) {
      let i = 0;
      setInterval(() => {
        document.getElementById('dynamic_hero_image').style.backgroundImage = 'url('+response[i].img_dir+')'; 
        i++;
        if(i == response.length) {
          i = 0;
        }
      }, 10000);
    }
  });
}

  });
</script>
</body>
</html>
