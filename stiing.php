<?php include 'conn.php'; 

$query = "SELECT users.user_id, users.username,users.profile_image,work.id,work.user_Id,work.work_description,work.work_title,work.uploaded_on,work.img_dir,work.img_dir FROM users INNER JOIN work ON users.user_id = work.user_Id ORDER BY work.uploaded_on DESC LIMIT 0,12";
$result = mysqli_query($conn,$query);
$rows = mysqli_fetch_assoc($result);

// $user_id = $result['user_Id'];
// $sql = mysqli_query($conn, "SELECT * FROM users WHERE user_id=".$user_id."");

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
	<link href="../fontawesome/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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

    </style>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body class="bg-light">




<div class="navbar-xtrim navbar navbar-expand-md">
	<div class="xtrim"><a href="#" class="navbar-brand text-white"><span class="ex">X</span>TRIM</a></div>
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
            <?php if(isset($_SESSION['username'])): ?>
              <h4 class="display-4 my-2"><?php echo $_SESSION['username'] ;?></h4>
            <li><a href="profile.php" class="btn pl-0 btn-customized">Profile <i class="fa fa-user-cog"></i></a></li>
            <li><a href="" class="btn pl-0 btn-customized">Settings <i class="fa fa-cogs"></i></a></li>
            <li><a href="logout.php" class="btn pl-0 btn-customized">Logout <i class="fa fa-sign-out-alt"></i></a></li>
              <?php else: ?>
            <li><a href="" class="btn pl-0 btn-customized" data-toggle="modal" id="mobile_logIn" data-target="#Login">Login <i class="fa fa-sign-in-alt"></i></a></li>
            <li><a href="" class="btn pl-0 btn-customized" data-toggle="modal" data-target="#Register">Register <i class="fa fa-user-plus"></i></a></li>
            <li><a href="" class="btn pl-0 btn-customized" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>" id="mobile_upload_btn">Upload <i class="fa fa-cloud-upload-alt"></i></a></li>
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
    <a href="upload.php" class="navbar-xtrim-item navbar-xtrim-button btn btn-danger" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>" id="upload_btn">Upload <i class="fa fa-cloud-upload-alt"></i></a>
                <!-- <img src="../image/person.jpg" id="popover-avatar" data-placement="bottom" title="Account">
				<ul class="dropdown-menu dropdown-menu-right navbar-xtrim-dropdwon-menu">
					<li><a href="" data-target="#Login" data-toggle="modal">Login <i class="fa fa-sign-in-alt"></i></a></li>
					<hr class="my-0 mx-3 bg-light ">
					<li><a href="" data-target="#Register" data-toggle="modal">Register <i class="fa fa-user-plus"></i></a></li>
				</ul> -->
			<!-- </div> -->
		</div>
  <div>
        <?php if (isset($_SESSION['loggedIn'])): ?>
          <div class="dropdown">
            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" style="background: transparent;border:transparent;">
            <span class="navbar-xtrim-button"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?></span>
            </button>
            <div class="dropdown-menu">
              <a href="logout.php" class="btn btn-outline-light navbar-xtrim-button dropdown-item" style="display: flex;justify-content: space-between;align-items: center;">Logout <i class="fa fa-sign-out-alt"></i></a>
              <a href="profile.php" class="btn btn-outline-light navbar-xtrim-button dropdown-item" style="display: flex;justify-content: space-between;align-items: center;">Profile <i class="fa fa-user-cog"></i></a>
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
            <input type="email" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Email Address" required="required" id="email">
            <div class="pass_container p-0 m-0">
            <input type="password" name="" class="navbar-xtrim-search-input mb-3 Lform" placeholder="Password" required="required" id="pass"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
            </div>
            <div class=" mt-4 d-flex justify-content-between align-items-center">
            <!-- <button type="button" class="btn btn-success">Login</button> -->
            <input type="submit" id="loginBtn" name="" class="btn btn-primary btn-lg" value="Login" style="border-radius: 2px">
            <a href="" class="lead forgot">I forgot my password</a>
            </div>
            </form>
         </div>

       </div>
   </div> 
</div>
<!-- End of Login Modal -->

<!-- Register Modal -->

<div class="modal fade" id="Register">
   <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
            <h4>Register Account</h4>
            <span class="close" data-dismiss="modal">&times;</span> 
         </div>  
         <div class="modal-body">
          <p id="errorMsg" class="text-danger text-center"></p>
          <p class="text-success text-center"><strong id="successMsg"></strong></p>
            <form class="mt-2">
            <input type="text"  id="Username" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Choose Username">

            <input type="email"  id="Email" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Email Address">
            <input type="tel"  id="Phone" name="" class="navbar-xtrim-search-input mb-4 mt-1 Lform" placeholder="Phone Number">
            <label><strong>Select Gender:</strong></label>
            <select id="gender_select" class="form-control mb-4" style="border-radius: 0">
              <option class="gender_option" selected="selected">Male</option>
              <option class="gender_option">Female</option>
              <option class="gender_option">Other</option>
            </select>
            <div class="pass_container p-0 m-0">
            <input type="password"  id="Password" name="" id="passSignIn" class="navbar-xtrim-search-input mb-4 Lform" placeholder="Password"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
          </div>
            <div class="pass_container p-0 m-0">
            <input type="password"  id="Vpassword" name="" id="vpass" class="navbar-xtrim-search-input mb-4 Lform" placeholder="Re-type Password"><span id="visibility"><i class="fa fa-eye-slash"></i></span>
          </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" checked="checked" name="check" class="custom-control-input" id="custom_check" required="required">
                    <label class="custom-control-label" for="custom_check" style="font-size: 100%;font-weight:bold;">
                        I read and accept the <a href="#">terms and conditions.</a>
                    </label> 
                </div>
            </div>
            <input type="submit" id="submit" name="" class="btn btn-primary btn-lg mt-2" value="Create Account" style="border-radius: 2px">
            </form>
         </div>

       </div>
   </div> 
</div>
<!-- End of Register Modal -->

<!-- <div class="xtrim-wrapper">
	<div class="sidebar"></div>
	<div class="main-content"></div>
	<div class="all-files"></div>	
</div> -->

       <div class="hero-image">
           <div class="container hero-text">
            <h4 class="display-4">The Home of beautiful paintworks and drawings.</h4>
            <h5 class="lead">Show the world how creative you are by showcasing some of your artworks.</h5>  
            <h6 class="lead">Upload, access, and share your drawings/paintings from any device, from anywhere in the world</h6> 
            <?php if(isset($_SESSION['loggedIn'])): ?>

            <h4 class="text-success mt-4">Upload your best work <br> and stand a chance to compete in the <br><strong><a href="" class="text-white d-inline-block mt-3"><span class="design_challenge"><i class="fa fa-medal"></i> Design Of the Week Challenge <i class="fa fa-medal"></i></span></a></strong></h4>
            <a href="upload.php" class="btn btn-danger btn-lg mt-3" style="border-radius: 1px">Upload Now  <i class="fa fa-upload"></i></a>
            <?php else : ?>
            <a href="" class="btn btn-danger btn-lg mt-3" style="border-radius: 1px" id="signin_btn">Sign Up Now</a>
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
          <div class="my-2 d-flex"><img src="" class="uploaded_by_user_img card-image">
            <p class="lead"><strong class="uploaded_by_username"></strong></p>
          </div>
          <img src="" id="preview_img_modal" class="img-fluid w-100">

          <p class="lead mt-2 mb-0" style="color: black"><strong id="work_title_text"></strong></p>
          <p id="work_description_text" class="lead my-0"></p><a href="" id="read_more_text">Read More</a>

        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<div class="container-fluid mb-3 bg-light" style="border-top: 3px solid silver;border-bottom: 2px solid silver">

<!-- Nav tabs -->
<div class="container">
  <ul class="nav nav-tab mt-2 justify-content-center mb-2 section-tab-nav" id="target">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">New</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">Popular</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu2">Best Works</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu3">Top Rated Artists</a>
  </li>
</ul>
</div>
</div>
<div class="container">
 
<!-- <hr class="mt-0 mb-2 bg-danger">  -->

<!-- Tab panes -->
<div class="tab-content">
    <!-- First tab starts here... -->
<div class="tab-pane container active" id="home">
    <!-- grid system row starts.. -->
<div class="row">


<?php foreach($result as $row): ?>
<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?php echo $row['img_dir'] ;?>" class="img-fluid img-link" data_user_id="<?php echo $row['user_id'] ;?>" data-toggle="modal" data-target="#view_image"> 
  <div class="btns test-btn" data_user_id="<?php echo $_SESSION['userId'] ;?>">
    <span><i class="fa fa-eye" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 200</span>
    <span><i class="fa fa-heart" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 179</span>
    <span><i class="fa fa-comments" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 57</span>
 </div>
    </div> 

</div>
<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="<?php 
isset($row['profile_image']) ? print $row['profile_image'] : print 'profile_image/default_image.jpg';?>" class="card-image">  <a href="user_profile.php?q_user=<?php echo $row['username'] ;?>"><?php echo $row['username'] ;?></a></span>
<div>
<p class="d-none work_title" data_work_title="<?php echo ucwords($row['work_title']) ?>"></p>
<p class="d-none work_description" data_work_description="<?php echo ucfirst($row['work_description']) ?>"></p>
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
  




  <div class="tab-pane container fade" id="menu1">

<div class="row">
<?php foreach($result as $row): ?>
<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?php echo $row['img_dir'] ;?>" class="img-fluid img-link" data_user_id="<?php echo $row['user_id'] ;?>">  
  <div class="btns test-btn" data_user_id="<?php echo $_SESSION['userId'] ;?>">
    <span><i class="fa fa-eye" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 900</span>
    <span><i class="fa fa-heart" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 249</span>
    <span><i class="fa fa-comments" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 517</span>
 </div>

    </div> 



</div>
<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="<?php 
isset($row['profile_image']) ? print $row['profile_image'] : print 'profile_image/default_image.jpg';?>" class="card-image">  <a href=""><?php echo $row['username'] ;?></a></span>
</div>
<p class="d-none work_title" data_work_title="<?php echo ucwords($row['work_title']) ?>"></p>
<p class="d-none work_description" data_work_description="<?php echo ucfirst($row['work_description']) ?>"></p>
<?php endforeach ; ?>
</div>
<hr>
<!-- end of grid row -->
<div class="container d-flex align-items-center justify-content-center my-4">
    <button class="btn btn-danger btn-lg">Load More</button>
</div>
  </div>
  




  <div class="tab-pane container fade" id="menu2">

<div class="row">
<?php foreach($result as $row): ?>
<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?php echo $row['img_dir'] ;?>" class="img-fluid img-link" data_user_id="<?php echo $row['user_id'] ;?>">  
  <div class="btns test-btn" data_user_id="<?php echo $_SESSION['userId'] ;?>">
    <span><i class="fa fa-eye" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 10k</span>
    <span><i class="fa fa-heart" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 5k</span>
    <span><i class="fa fa-comments" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 3k</span>
 </div>

    </div> 



</div>
<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="<?php 
isset($row['profile_image']) ? print $row['profile_image'] : print 'profile_image/default_image.jpg';?>" class="card-image">  <a href=""><?php echo $row['username'] ;?></a></span>
</div>
<p class="d-none work_title" data_work_title="<?php echo ucwords($row['work_title']) ?>"></p>
<p class="d-none work_description" data_work_description="<?php echo ucfirst($row['work_description']) ?>"></p>
<?php endforeach; ?>
</div>
<hr>
<!-- end of grid row -->
<div class="container d-flex align-items-center justify-content-center my-4">
    <button class="btn btn-danger btn-lg">Load More</button>
</div>
  </div>




<div class="tab-pane container fade" id="menu3">

<div class="row">
<?php foreach($result as $row): ?>
<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
    <div class="Card">
    <div class="img img-wrapper">
      <img src="<?php echo $row['img_dir'] ?>" class="img-fluid img-link" data_user_id="<?php echo $row['user_id'] ;?>">  
  <div class="btns test-btn" data_user_id="<?php echo $row['user_id'] ;?>">
    <span><i class="fa fa-eye" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 60k</span>
    <span><i class="fa fa-heart" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 17k</span>
    <span><i class="fa fa-comments" data_user_id="<?= $_SESSION['userId'] ?>" data_post_id="<?= $row['id'] ?>" data_liked="0" data_logged_in="<?php isset($_SESSION['username']) ? print true : print false  ?>"></i> 5k</span>
 </div>

   </div> 



</div>
<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="<?php 
isset($row['profile_image']) ? print $row['profile_image'] : print 'profile_image/default_image.jpg';?>" class="card-image">  <a href=""><?php echo $row['username'] ;?></a></span>
</div>
<p class="d-none work_title" data_work_title="<?php echo ucwords($row['work_title']) ?>"></p>
<p class="d-none work_description" data_work_description="<?php echo ucfirst($row['work_description']) ?>"></p>
<?php endforeach; ?>
</div>
<hr>
<!-- end of grid row -->
<div class="container d-flex align-items-center justify-content-center my-4">
    <button class="btn btn-danger btn-lg">Load More</button>
</div>
</div>
   
</div><!-- end of container -->
</div>






<div id="newsletter" class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="newsletter">
                            <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                            <form>
                                <input class="input Lform" type="email" placeholder="Enter Your Email Address" required>
                                <button class="newsletter-btn btn btn-danger"><i class="fa fa-envelope"></i> Subscribe</button>
                            </form>
                            <ul class="newsletter-follow">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-pinterest"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
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
                                <p class="lead text-info">We unveil your creativity to the world. By simply uploading some of your works, we promote your works and designs for you. Just keep it coming!</p>
                                <ul class="footer-links">
                                    <li><a href="#"><i class="fa fa-map-marker-alt"></i>Galadima Ward, Double Pocket Street</a></li>
                                    <li><a href="#"><i class="fa fa-phone"></i>09039668763</a></li>
                                    <li><a href="#"><i class="far fa-envelope"></i>cyberneticOrgarnism@email.com</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-6">
                            <div class="footer">
                                <h3 class="footer-title">Categories</h3>
                                <ul class="footer-links">
                                    <li><a href="#">Hot Deals</a></li>
                                    <li><a href="#">Nature Painting</a></li>
                                    <li><a href="#">Color Sketching</a></li>
                                    <li><a href="#">Pencil Sketch</a></li>
                                    <li><a href="#">Graffiti</a></li>
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
                                XTRIM Copyright © 2019 All rights reserved || Designed and developed by <a href="#" target="_blank" style="font-size: 1.2rem;text-decoration: none;">Cyborg-X11</a>
                            </span>
                        </div>
                    </div>
                        <!-- /row -->
                </div>
                <!-- /container -->
            </div>   
</footer>
<script src="../bootstrap/bootstrap/dist/js/popper.min.js"></script>
<script src="../bootstrap/bootstrap/dist/js/jquery-3.3.1.min.js"></script>
<script src="../bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.img-link').click(function(){
      var uploaded_by_username = $(this).parent().parent().next().children().last().text();
      var uploaded_by_user_img = $(this).parent().parent().next().children().first().attr('src');
      $('.uploaded_by_user_img').attr('src',uploaded_by_user_img);
      $('.uploaded_by_username').text(uploaded_by_username).addClass('ml-1');
      // alert(uploaded_by_username);
      // console.log(uploaded_by_user_img);
      // console.log(uploaded_by_username);

    var work_title = $(this).parent().parent().next().next().children().first().attr('data_work_title');
    var work_description = $(this).parent().parent().next().next().children().last().attr('data_work_description');
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