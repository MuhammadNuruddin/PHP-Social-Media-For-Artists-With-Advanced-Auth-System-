<?php
require_once 'core/init.php';
if (Input::exists()) {

	$errors = array();
	$validate = new Validate();
	$validation = $validate->check($_POST,array(
		'username' => array(
			'required' => true,
			'min' => 2,
			'max' => 30,
			'unique' => 'users',
			'field_name' => 'Username'
		),
    'email' => array(
			'required' => true,
			'field_name' => 'Email',
      'unique' => 'users',
      'pattern' => 'email'
		),
		'password' => array(
			'required' => true,
			'min' => 6,
			'field_name' => 'Password'
		),
		'verify_password' => array(
			'required' => true,
			'matches' => 'password',
			'field_name' => 'Confirm Password'
		),
		'gender' => array(
			'required' => true,
			'field_name' => 'Gender'
		)

	));

	if ($validation->passed()) {
		// Session::flash('success','You registered successfully!');
		// header("Location: index.php");
		$salt = substr(Hash::salt(), 0, 32) ;
		$user = new User();
		try {
			
			$user->create(array(
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt,
				'email' => Input::get('email'),
				'phone' => Input::get('phone'),
        'gender' => Input::get('gender'),
				'type' => 1
				)
			);

			Session::flash('home', 'You have been registered successfully and can now log in');
			Redirect::to('login.php');

		} catch (Exception $e) {
			die($e->getMessage());
		}
	}else {
		foreach ($validation->errors() as $error) {
			array_push($errors, $error);
		}
	}

}
// header("refresh:2; url=https://faithpays.org/donation-management-software/");
// refresh current page
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Xtrim - Signup</title>
	<link href="./fontawesome/css/all.min.css" rel="stylesheet">
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <style>
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
  <?php if(isset($errors)): ?>
  <div class="alert alert-danger">
  <?php foreach($errors as $error) : ?>
  <p class="text-left my-0"><i class="fa fa-times"></i> <?= $error ;?></p>
 <?php endforeach ;?>
  </div>
  <?php endif ;?>
  <hr>
    <div class="form-group">
      <input type="text" name="username" class="form-control form-control-lg mb-3" placeholder="Choose Username" value="<?php Input::get('username') ? print Input::get('username') : '' ?>">
    </div>

    <div class="form-group">
      <input type="email" name="email" class="form-control form-control-lg mb-3" placeholder="Email Address" value="<?php Input::get('email') ? print Input::get('email') : '' ?>">
    </div>

    <div class="form-group">
      <input type="text" name="phone" class="form-control form-control-lg mb-3" placeholder="Mobile Number" value="<?php Input::get('phone') ? print Input::get('phone') : '' ?>">
    </div>
  <div class="form-group">
            <select id="gender_select" name="gender" class="form-control">
              <option selected="selected" disabled="disabled"><strong>Select Gender:</strong></option>
              <option class="gender_option" value="male">Male</option>
              <option class="gender_option" value="female">Female</option>
              <option class="gender_option" value="other">Other</option>
            </select>
  </div>
    <div class="form-group">
      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
    </div>

    <div class="form-group">
      <input type="password" name="verify_password" class="form-control form-control-lg" placeholder="Re-type Password">
    </div>
    <div class="forgot-link">

      <div class="form-check custom-control custom-checkbox text-left">
        <input type="checkbox" name="accept_terms_condition" class="custom-control-input" id="accept" required="required">
        <label for="accept" class="custom-control-label">I read and accept the</label> <a href="#"><strong>Terms and conditions of use.</strong></a>
      </div>
    </div>
    <button type="submit" class="btn btn-primary btn-custom btn-block btn-lg mt-4 create-btn">Create Account</button>
    <p class="mt-3 font-weight-normal">Already have an account? <a href="login.php"><strong>Login</strong></a></p>
  </form>
</div>

<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  
  // $(".create-btn").attr('disabled','disabled');
  $("#accept").change(function() {
    if($("#accept").prop('checked') == false) {
    $(".create-btn").attr('disabled','disabled');
  }else {
    $(".create-btn").attr('disabled',null);
  }
  });
    // alert('yes');
    
  // }
});
</script>	
</body>
</html>