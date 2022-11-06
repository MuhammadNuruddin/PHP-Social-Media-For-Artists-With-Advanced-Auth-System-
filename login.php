<?php
require_once 'core/init.php';
// Login script

if (Input::exists()) {
	// if (Token::check(Input::get('token'))) {
	
	$email = Input::get('email');
	$password = Input::get('password');
	$remember = (Input::get('remember') === "on") ? true : false;
  if(empty($email) || empty($password)) {
    Session::flash('error', 'Please fill in all fields!');
  }else {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$user = new User();
			$login = $user->login($email, $password, $remember);

			if ($login) {
				Session::put('loggedIn', true);
				Session::put('username', $user->data()->username);
				Session::put('email', $user->data()->email);
				Session::put('userId', $user->data()->id);
        Session::flash('success', 'Login Success!');
        Redirect::to('index.php');
				// exit('success'); 
        // header("refresh:1; url=".$_SERVER['PHP_SELF']."");
        // refresh current page
			}else {
				// exit('failed');
        Session::flash('error', 'That didn\'t work, please try again!');
			}
}else{
  Session::flash('error', 'Invalid Email address!');
	// exit('failed');
}
  }
		

// }
}

// ------------------------- End of Login script ----------------------
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Xtrim - Login</title>
	<link href="./fontawesome/css/all.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <style type="text/css" rel="stylesheet">
  body{
  padding: 0;
  margin: 0;
  color: #666;
  background: #f0f7f4;
  }

* {
    box-sizing: border-box;
}
  .form-container {
  width: 100%;
  height: 100vh;
  }
  .input-form {
    max-width: 100%;
    width: 600px;
    padding: 15px;
    margin: auto;
  }
  .form-control {
    font-size: 15px;
    min-height: 48px;
    font-weight: lighter !important;
    opacity: 0.98;
  }
  .form-control:focus {
    box-shadow: none !important;
    outline: 0px !important;
  }
  .forgot-link {
    font-size: 14px;
  }
  .forgot-link label {
    margin-bottom: 0;
  }
  .input-form a {
    text-decoration: none;
    color: #666;
  }
  .input-form a:hover {
    opacity: 0.8;
  }
  .btn-custom {
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    min-height: 48px;
  }
  @media (max-width: 465px) and (min-width: 100px){
    .input-form > h1 {
      font-size: 2.8rem;
    }
  }

    </style>
</head>
<body>

<div class="form-container d-flex align-items-center justify-content-center">
<a href="" class="btn btn-light ml-2 mt-3 back_btn"><i class="fa fa-arrow-left"></i> Back</a>
<hr>
  <form class="input-form text-center" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ;?>">
  <?php if(Session::exists('error')): ?>
      <div class="alert alert-danger py-3 rounded-0 mb-4"><strong><?= Session::flash('error'); ?></strong></div>
    <?php endif ?>
    <?php if(Session::exists('success')): ?>
      <div class="alert alert-success py-3 rounded-0 mb-4"><strong><?= Session::flash('success'); ?></strong></div>
    <?php endif ?>
<?php if(Session::exists('home')): ?>
      <div class="alert alert-success py-3 rounded-0 mb-4"><strong><?= Session::flash('home'); ?></strong></div>
    <?php endif ?>
    <hr>
    <div class="form-group">
      <input type="email" name="email" class="form-control form-control-lg mb-3" placeholder="Enter your Email Address" value="<?php Input::get('email') ? print Input::get('email') : '' ?>">
    </div>

    <div class="form-group">
      <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your Password">
    </div>
    <div class="forgot-link d-flex justify-content-between">
      <div class="form-check custom-control custom-checkbox">
        <input type="checkbox" name="remember" value="on" class="custom-control-input" id="save_password">
        <label for="save_password" class="custom-control-label">Remember Me</label>
      </div>
      <a href="./forgot_password.php">Forgot Password?</a>
    </div>
    <button type="submit" name="logIn" class="btn btn-primary btn-custom btn-block btn-lg mt-4">Login</button>
    <p class="mt-3 font-weight-normal">Don't have an account? <a href="signup.php"><strong>Create Account</strong></a></p>
  </form>
</div>

<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
</script>	
</body>
</html>