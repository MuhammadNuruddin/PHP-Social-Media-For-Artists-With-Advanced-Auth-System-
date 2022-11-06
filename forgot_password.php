<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Xtrim - Forgot password</title>
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
<form>

<p class="text-info">Please enter correct email address... You will receive a reset link through the email address you submit.</p>

    <div class="form-group">
      <input type="email" name="email" class="form-control form-control-lg mb-3" placeholder="Enter your Email Address">
    </div>

    <div class="form-group">
      <input type="submit" name="password_reset" class="form-control btn-primary form-control-lg" value="Proceed">
    </div>
    
  </form>
</div>

<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/jquery-3.3.1.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
</script>	
</body>
</html>