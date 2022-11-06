<?php 

require_once 'core/init.php';


// REGISTER USER SCRIPT

if (Input::get('register')) {
	// if (Token::check(Input::get('token'))) {

	$salt = substr(Hash::salt(), 0, 32);
	$username = Input::get('username');
	$phone_number = Input::get('phone_number');
	$email = Input::get('email');
	$password = Input::get('password');
	$verify_password = Input::get('verify_password');
	$gender = Input::get('gender');
	if (empty($username) || empty($email) || empty($password) || empty($verify_password)) {
		exit('emptyFields');
		}else {
			$user_check = DB::connect()->select('users', array('username', '=', $username));
		if ($user_check->count()) {
			exit('userTaken');
		}
		else if (strlen($username) > 30) {
			exit('userTooLong');
		}
		else if (strlen($password) < 6) {
			exit('passwordTooShort');
		}
		else if (!preg_match('/^[a-z\d]{3,30}$/i', $username)) {
			exit('invalidUser');
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			exit('invalidEmail');
		}
		$query = DB::connect()->select('users', array('email', '=', $email));
		if ($query->count()) {
			exit('invalidEmail');
		}
		else if ($password !== $verify_password) {
			exit('passwordMismatch');
		}else {
			// Add user here...
			$ePassword = Hash::make($password, $salt);
			$user = new User();
			$user->create(array(
				'username' => $username,
				'password' => $ePassword,
				'salt' => $salt,
				'email' => $email,
				'phone' => $phone_number,
				'gender' => $gender,
				'type' => 1
			));
			exit('success');
		}
	}
// }
}

// END OF REGISTER SCRIPT //


// ----------------------------------------------------------------- //

// Login script

if (Input::get('logIn')) {
	// if (Token::check(Input::get('token'))) {
	
	$email = Input::get('email');
	$password = Input::get('password');
	$remember = (Input::get('remember') === "on") ? true : false;
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$user = new User();
			$login = $user->login($email, $password, $remember);

			if ($login) {
				Session::put('loggedIn', true);
				Session::put('username', $user->data()->username);
				Session::put('email', $user->data()->email);
				Session::put('userId', $user->data()->id);
				exit('success'); 
			}else {
				exit('failed');
			}
}else{
	exit('failed');
}
// }
}

// ------------------------- End of Login script ----------------------






if (Input::get('social_media_info')) {
	$form_inputs = Input::get('form_data');
	// foreach ($form_inputs as $input => $value) {
		$facebook_username = $form_inputs['facebook_username'];
		$instagram_username = $form_inputs['instagram_username'];
		$twitter_username = $form_inputs['twitter_username'];
		$user_id = $form_inputs['user_id'];
		if($facebook_username == '') {
			$facebook_username = null;
		}
		if($instagram_username == '') {
			$instagram_username = null;
		}
		if($twitter_username == '') {
			$twitter_username = null;
		}
	// }
	// exit($facebook_username);
	$user_check = DB::connect()->select('additional_user_info', array('user_id', '=', $user_id));
	$row = $user_check->first();
	if(!$user_check->count()) {
		$user = DB::connect()->insert('additional_user_info', array(
			'user_id' => $user_id,
			'facebook' => $facebook_username,
			'instagram' => $instagram_username,
			'twitter' => $twitter_username
		));
		if($user) {
		Session::flash('success', 'Social Info added Successfully!');
		exit('social_info_updated');
		}
	}else {

	

	// $delete_user = DB::connect()->delete('additional_user_info', array('user_id', '=', $user_id));
	// if($delete_user) {
	// 	$query = DB::connect()->insert('additional_user_info', array(
	// 		'user_id' => $user_id,
	// 		'facebook' => $facebook_username,
	// 		'instagram' => $instagram_username,
	// 		'twitter' => $twitter_username
	// 	));	
	// }
	if(isset($row->facebook)) {
		$facebook_username = isset($facebook_username) ? $facebook_username : $row->facebook;
	}else {
		$facebook_username = $facebook_username;
	}
	if(isset($row->instagram)) {
		$instagram_username = isset($instagram_username) ? $instagram_username : $row->instagram;
	}else {
		$instagram_username = $instagram_username;
	}
	if(isset($row->twitter)) {
		$twitter_username = isset($twitter_username) ? $twitter_username : $row->twitter;
	}else {
		$twitter_username = $twitter_username;
	}
	$query = DB::connect()->update_additional_info('additional_user_info', $user_id, array(
			'facebook' => $facebook_username,
			'instagram' => $instagram_username,
			'twitter' => $twitter_username
	));
}

	if($query) {
		Session::flash('success', 'Social Info added Successfully!');
		exit('social_info_updated');
	}
}

if (Input::get('update_social')) {
	// $user_id = $_POST['user_id'];
	// $query = "UPDATE users SET facebook = null, instagram = null WHERE user_id =".$user_id." ";
	// if (mysqli_query($conn,$query)) {
	// 	exit('social_info_removed');

	// }
	$field = Input::get('social_field');
	// $social_field = '';
	if($field == 'facebook') {
		$social_field = 'facebook';
	}else if($field == 'twitter') {
		$social_field = 'twitter';
	}else {
		$social_field = 'instagram';
	}
	$user_id = Session::get('userId');
	$query = DB::connect()->update_additional_info('additional_user_info', $user_id, array(
		$social_field => null
	));
	if($query) {
		Session::flash('success', ''.ucwords($social_field).' Info removed Successfully!');
		exit('social_info_removed');
	}
}


// EDIT BIO CODE

// if (Input::get_item('edit_bio')) {
// 	$user_id = Input::get('data_user_id');
// 	$output = '';
// 	// $query = "SELECT * FROM users WHERE user_id = ".$user_id."";
// 	$query = DB::connect()->select('additional_user_info', array('user_id', '=', $user_id));
// 	// $rows = mysqli_query($conn,$query);
// 	// foreach ($rows as $row) {
// 	// 	$output .= $row['bio'];
// 	// }
// 	while ($row = $query->first()) {
// 		$output .= $row->bio;
// 	}
// 	echo $output;
// }



// // CONFIRM BIO EDIT CODE

// if (isset($_POST['edit_bio_confirm'])) {
// 	$bio_text = mysqli_real_escape_string($conn,$_POST['bio_text']);
// 	$user_id = $_POST['user_id'];
// 	$query = "UPDATE users set bio = '".$bio_text."' WHERE user_id = ".$user_id."";
// 	if (empty(trim($bio_text))) {
// 	$query = "UPDATE users set bio = null WHERE user_id = ".$user_id."";
// 	}
// 	if (mysqli_query($conn,$query)) {
// 		exit('bio_updated_successfully');
// 	}
// }

if (Input::get('edit_work')) {
	$id = Input::get('id');
	$query = DB::connect()->select('work', array('id', '=', $id));
	// $query = mysqli_query($conn, "SELECT * FROM work WHERE id = ".$id."");
	$output = array();

	// DIDN'T WORK OUT WITH WHILE LOOP

	// while ($row = $query->results()) {
	// 	$output = ['work_title' => $row->work_title,
	// 				'work_description' => $row->work_description,
	// 				'picture_name' => $row->img_name,
	// 				'category' => $row->category,
	// 				'id' => $row->id,
	// 				'img_dir' => $row->img_dir
	// 			];
	// }
	// USE FOREACH LOOP

	foreach($query->results() as $row) {
		$output = ['work_title' => $row->work_title,
					'work_description' => $row->work_description,
					'picture_name' => $row->img_name,
					'category' => $row->category,
					'id' => $row->id,
					'img_dir' => $row->img_dir
				];
	}
	echo json_encode($output);
}


// Edit work code 

if (Input::get('edit_work_confirm')) {
	$file = '';
	$img_new_dir = '';
	$work_id = Input::get('work_id');
	$work_title = Input::get('work_title');
	$work_description = Input::get('work_description');
	$category = Input::get('category');
	$picture_name = Input::get('picture_name');
	$img_dir = Input::get('file_input');
	// $img_new_dir = '';
	if (isset($_FILES['file']['name'])) {
		$file = $_FILES['file'];
	}
	

	// $file = $_POST[$_FILES['file_input']];
	if (empty($work_title) || empty($work_description) || empty($category) || empty($picture_name)) {
		exit('input_fields_empty');
	}else {


		// run code section if user selects new image
	if ($file != null) {
		$img_init_name = explode('\\', $img_dir);
		$img_name = end($img_init_name);
		$fileExt = explode('.', $img_name);
		$fileActualExt = strtolower(end($fileExt));

		$fileNewName = uniqid('',true).".".$fileActualExt;
        $img_new_dir = 'uploads/'.$fileNewName;
        move_uploaded_file($_FILES['file']['tmp_name'], $img_new_dir);
	}else {

		// use old picture
		$img_new_dir = $img_dir;
	}


// exit('success');
		// $sql = mysqli_query($conn, "SELECT * FROM work WHERE id = ".$work_id."");
		$sql = DB::connect()->select('work', array('id', '=', $work_id));
		foreach ($sql->results() as $row) {
			$old_image = $row->img_dir;
		}
		
		// while ($row = mysqli_fetch_assoc($sql)) {
			
		// }
		
		
        // $query = "UPDATE work SET category = '$category',work_title = '$work_title',work_description = '$work_description', img_name = '$picture_name',img_dir = '$img_new_dir' WHERE id=".$work_id."";
		$query = DB::connect()->update('work', $work_id, array(
			'category' => $category,
			'work_title' => $work_title,
			'work_description' => $work_description,
			'img_name' => $picture_name,
			'img_dir' => $img_new_dir
		));
        if ($query) {
			// work on the functionality
        	// unlink("".$old_image."");
        	exit('upload_success');
        }		
	}




	// $fileActualExt = strtolower($img_ext);
 //  	$allowed = array('jpg','png','jpeg','gif');


        // 

        
        // ADD TO DATABASE HERE
        // $query = "INSERT INTO work(user_id,category,work_title,work_description,img_name,img_dir) VALUES(".$_SESSION['userId'].",'$category','$work_title','$work_description','$picture_name','$file_dir')";

          // $msg = '<div class="alert alert-success py-3 rounded-0 mb-4"><strong>Successfully uploaded!</strong></div>';

  // if (in_array($fileActualExt, $allowed)) {
    
  //   if ($fileError === 0) {
  //     if ($fileSize > 5000000) {
  //       exit('file_too_big');    
  //     }else {

  //       }         
  //       }
  //   }else {
  //   	exit('error_img_upload');
  //     // $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>There was an error uploading your file!</strong></div>';

  //   }

  // }else {
  // 	exit('invalid_img_format');
  //   // $msg = '<div class="alert alert-danger py-3 rounded-0 mb-4"><strong>Invalid file format; only jpg, jpeg,png, and gif allowed!</strong></div>';
  // }
}

if (Input::get('remove_work_confirm')) {
	$work_id = Input::get('remove_work_id');
	// $work_id = mysqli_real_escape_string($conn, $_POST['remove_work_id']);
	$remove_query = DB::connect()->delete('work', array('id', '=', $work_id));
	// $remove_query = "DELETE FROM work WHERE id=".$work_id."";
	if (!$remove_query->error()) {
		exit('removed_successfully');
	}

}

if (Input::get('post_reaction')) {

	$user_id = Input::get('user_id');
	$post_id = Input::get('post_id');
	$reaction = Input::get('reaction');
	$data = array();
	// $test = DB::connect()->action_test("SELECT *",'users','=',array('username','groups'),array('nura',1));
// var_dump($test);
	$user_check = DB::connect()->pdo_select('reaction','=',array('user_id','work_id'),array($user_id,$post_id));
	// $user_check = DB::connect()->execute("SELECT * FROM reaction WHERE user_id = '$user_id' AND work_id = '$post_id'");
	// $user_check_query = mysqli_query($conn, "SELECT * FROM rating_info WHERE user_id = '$user_id' AND work_id = '$post_id'");
	$count = count($user_check->pdo_results());
	if ($count > 0) {
		// USER EXIST - DELETE POST

		// CHECK REACTION TO CONFIRM QUERY TO RUN

		// $query = "DELETE FROM rating_info WHERE work_id = '$post_id' AND user_id = '$user_id'";
		// if (mysqli_query($conn,$query)) {
		// 	echo json_encode($data = ['reaction' => 'unliked', 'post_id' => $post_id]);
		// }
		$query = DB::connect()->pdo_delete('reaction','=',array('user_id','work_id'),array($user_id,$post_id));
		// $query = DB::execute("DELETE FROM reaction WHERE work_id = '$post_id' AND user_id = '$user_id'");
		if($query) {
			echo json_encode($data = ['reaction' => 'unliked', 'post_id' => $post_id]);
		}
	// if ($reaction === 'unlike') {

	// 	$query = "INSERT INTO rating_info(work_id,user_id,rating_action) VALUES('$post_id','$user_id','$reaction')";
	// 	if (mysqli_query($conn,$query)) {
	// 		echo json_encode($data = ['reaction' => 'liked', 'post_id' => $post_id]);
	// 	}



	// }

	}else {
		// USER DOESN'T EXIST - ADD POST
		if ($reaction === 'unlike' || $reaction === 'like') {
			$reaction = 'like';
			$query = DB::connect()->insert('reaction', array(
				'user_id' => $user_id,
				'work_id' => $post_id,
				'reaction' => $reaction
			));
			if($query) {
				echo json_encode($data = ['reaction' => 'liked', 'post_id' => $post_id]);
			}
			// $query = "INSERT INTO rating_info(work_id,user_id,rating_action) VALUES('$post_id','$user_id','$reaction')";
			// if (mysqli_query($conn,$query)) {
			// 	echo json_encode($data = ['reaction' => 'liked', 'post_id' => $post_id]);
			// }
		}
		
	}



}



// // CODE TO GET THE LIKES COUNT FROM THE DB

if (Input::get('get_likes_confirm')) {
	// $query = mysqli_query($conn, "SELECT * FROM rating_info");
	$query = DB::connect()->query("SELECT * FROM reaction");
	$data_work_id = array();
	// $data_user_id = array();
	// $user_ids = array();
	// $row = mysqli_fetch_assoc($query);
	foreach ($query->results() as $row) {

		// $index_query = mysqli_query($conn, "SELECT * FROM rating_info WHERE work_id = ".$row['work_id']." AND user_id=".$row['user_id']."");
		// $index_query = DB::connect()->pdo_query("SELECT *",'reaction','=',array('work_id','user_id'),array($row->work_id,$row->user_id));
		// $num_rows = mysqli_num_rows($index_query);
		// $rows = mysqli_fetch_assoc($index_query);
		// $rows = $index_query;
		// $data = [$row['user_id']];
		array_push($data_work_id, $row->work_id);
		// array_push($data_user_id, $rows['user_id']);
			// $data .= ['count' => ];
		
		
		
		// $index_result = mysqli_fetch_assoc($index_query);
		// array_push($data, $num_rows);
	
	}


	$work_id = array_count_values($data_work_id);

	
	echo json_encode($work_id);


}

// function to get comments count

if(Input::get('get_comments_count')) {
	$query = DB::connect()->query("SELECT * FROM comments");
	$data_work_id = array();
	foreach($query->results() as $row) {
		array_push($data_work_id, $row->work_id);
	}
	$work_id = array_count_values($data_work_id);
	exit(json_encode($work_id));
}

if (Input::get('user_liked_posts')) {
	$auth_user_id = Input::get('auth_user_id');
	$output = array();
	$query = DB::connect()->select('reaction',array('user_id','=',$auth_user_id));
	// $query = mysqli_query($conn, "SELECT * FROM rating_info WHERE user_id = ".$auth_user_id."");
	foreach($query->results() as $row) {
		array_push($output, $row->work_id);
	}
	// while ($row = mysqli_fetch_assoc($query)) {
	// 	array_push($output, $row['work_id']);
	// }
	exit(json_encode($output));
}

// FUNCTION TO GET WORKS FOR THE HERO IMAGE
if(Input::get('get_works')) {
	$query = DB::connect()->query("SELECT * FROM work ORDER BY uploaded_on DESC");
	$results = $query->results();
	exit(json_encode($results));
}

// function to get views count 
if(Input::get('get_views_confirm')) {
	$query = DB::connect()->query("SELECT * FROM views");
	$output = array();	
	foreach ($query->results() as $row) {
		array_push($output, array($row->work_id => $row->count));
	}
	exit(json_encode($output));
}



// get work tag from database and filter base on that
if(Input::get('filter_tab')) {
	$tag = Input::get('filter_text');
	// $query = DB::connect()->select('work', array('tag', '=', $tag));
	$query = DB::connect()->query("SELECT users.id, users.username,users.avatar,work.id as work_id,work.tag,work.user_Id,work.work_description,work.work_title,work.uploaded_on,work.img_name,work.img_dir FROM users INNER JOIN work ON users.id = work.user_Id ORDER BY work.uploaded_on DESC");
	// $output = array();
	$output = '';
	$logged_in;
	$profile_image;
	$results = $query->results();
	foreach ($results as $row) {
		if($row->tag == $tag || $tag == 'All') {
			if(Session::exists('username')) {
				$logged_in = true;
			}else {
				$logged_in = false;
			}

			if(isset($row->avatar)) {
				$profile_image = $row->avatar;
			}else {
				$profile_image = "./profile_image/default_image.jpg";
			}
			$output .= '<div class="col-xs-12 col-sm-12 col-lg-2 col-md-6 btn-wrapper">
			<div class="Card">
			<div class="img img-wrapper">
			  <img src="'.$row->img_dir.'" class="img-fluid img-link" data_user_id="'.$row->id.'" data-toggle="modal" data-target="#view_image" data_post_id="'.$row->work_id.'"> 
		  <div class="btns test-btn" data_user_id="'.Session::get("userId").'">
			<span><a href="view_work.php?id='.$row->work_id.'" 
			class="view_link"><i class="fa fa-eye" data_user_id="'.Session::get("userId").'"
			 data_post_id="'.$row->work_id.'" data_liked="0" data_logged_in="'.$logged_in.'"></i> <strong></strong></a></span>
			<span><i class="fa fa-heart" data_user_id="'.Session::get("userId").'" data_post_id="'.$row->work_id.'" data_liked="0" data_logged_in="'.$logged_in.'"></i> <strong></strong></span>
			<span data-toggle="modal" data-target="#comment_modal" title="Comment"><i class="fa fa-comments" data_user_id="'.Session::get('userId').'" data_post_id="'.$row->work_id.'" data_liked="0" data_logged_in="'.$logged_in.'"></i> 57</span>
		 </div>
			</div> 
		
		</div>
		<span class="my-3" style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src="'.
		$profile_image.'" class="card-image">  <a href="user_profile.php?q_user='.$row->username .'">'.$row->username .'</a></span>
		<div>
		<p class="d-none work_title" data_work_title="'.ucwords($row->work_title).'"></p>
		<p class="d-none work_description" data_work_description="'.ucfirst($row->work_description).'"></p>
		</div>
		</div>';
		// $output.= $row->img_dir;
			// array_push($output, $row->img_name);
		}
	}
	echo $output;
}

// FOLLOW REQUEST SCRIPT
if(Input::get('follow_request')) {
	$follow_user_id = Input::get('follow_user_id');
	$user_id = Session::get('userId');
	$check_exist = DB::connect()->pdo_select('follow','=',array('follower_id','follows_user_id'),array($user_id,$follow_user_id));
	if(count($check_exist->pdo_results()) > 0) {
		// user exist - already followed user
		$query = DB::connect()->pdo_delete('follow','=',array('follower_id','follows_user_id'),array($user_id,$follow_user_id));
		if($query) {
			exit('unfollow');
		}
	}else {
	// user never followed the selected user
		$query = DB::connect()->insert('follow', array(
			'follower_id' => $user_id,
			'follows_user_id' => $follow_user_id
		));
		if($query) {
			exit('follow');
		}
	}
	
	
}

// get followed script
if(Input::get('get_follows')) {
	$follower_id = Input::get('follower_id');
	$follow_user_id = Input::get('follow_user_id');
	$check_exist = DB::connect()->pdo_select('follow','=',array('follower_id','follows_user_id'),array($follower_id,$follow_user_id));
	if(count($check_exist->pdo_results()) > 0) {
		// user exist - already followed user
		exit('user_follows');
	}
}

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

// THIS SCRIPT HANDLES THE COMMENT REQUEST AND ADDS IT TO THE DATABASE TABLE - COMMENT
if(Input::get('comment')) {
	$user_id = Input::get('user_id');
	$work_id = Input::get('work_id');
	$comment_text = trim(Input::get('comment_text'));
	$guest = 'No';
	if(empty($comment_text)) {
		exit('empty_fields');
	}else {
		$query = DB::connect()->insert('comments', array(
			'user_id' => $user_id,
			'work_id' => $work_id,
			'comment' => $comment_text,
			'guest' => $guest
		));
		if($query) {
			exit('comment_added');
		}
	}
}

// THIS SCRIPT HANDLES THE GUEST COMMENT REQUEST AND ADDS IT TO THE DATABASE TABLE - COMMENT
if(Input::get('guest_comment')) {
	$work_id = Input::get('work_id');
	$name = Input::get('guest_name');
	$id = hash('sha256', uniqid());
	$salt = substr($id, 0, 6);

	$comment_text = trim(Input::get('comment_text'));
	$guest = 'Yes';
	if(empty($comment_text) || empty($name)) {
		exit('empty_fields');
	}else {
		$query = DB::connect()->insert('comments', array(
			'work_id' => $work_id,
			'comment' => $comment_text,
			'guest' => $guest,
			'guest_name' => $name.'-'.$salt
		));
		if($query) {
			exit('comment_added');
		}
	}
}


// function to fetch comments for the clicked work from the database
if(Input::get('get_comments')) {
	$output = '';
	$work_id = Input::get('work_id');
	$query = DB::connect()->select('comments', array('work_id', '=', $work_id));
	if(!$query->count()) {
		exit('<h6 class="text-center text-info">No comments for this work yet...</h6>');
	}else {
		foreach($query->results() as $row) {
			$user = DB::connect()->select('users', array('id', '=', $row->user_id));
			$user_check;
			if(!$user->count()) {
				$user_check = null;
			}else {
				$user_check = $user->first();
			}
			if($user_check !== null) {
				$username = $user_check->username;
			}else {
				$username = $row->guest_name;
			}
			
			$output .= '<div class="comment">
			<h5 class="mb-0"><span style="font-family:sansation_bold">'.$username.'</span> 
			<small class="text-secondary float-right"><time class="timeago" datetime="'.$row->commented_on.'">'.$row->commented_on.'</time></small></h5>
			<p class="mb-1">'.$row->comment.'</p>
			<a class="" href="">Reply</a>
			</div>';
		}
		exit($output);
	}
}


// GET FOLLOWING USERS INFO FROM DB
if(Input::get('following_info')){
	$user_id = Input::get('user_id');
	$output = '';
	$query = DB::connect()->select('follow', array('follower_id', '=', $user_id));
	if($query) {
		// $user = new User()
		foreach($query->results() as $row) {
			$user = new User($row->follows_user_id);
			$info = $user->data();
			$profile_image;
			if(isset($info->avatar)) {
				$profile_image = $info->avatar;
			}else {
				$profile_image = './profile_image/default_image.jpg';
			}
			$output .= '<p><span style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src='.$profile_image.' class="card-image">  <a href="user_profile.php?q_user='.$info->username.'">'.$info->username.'</a></span>
			</p><hr />';
		}
		echo $output;
		
	}
}


// GET FOLLOWING USERS INFO FROM DB
if(Input::get('followers_info')){
	$user_id = Input::get('user_id');
	$output = '';
	$query = DB::connect()->select('follow', array('follows_user_id', '=', $user_id));
	if($query) {
		// $user = new User()
		foreach($query->results() as $row) {
			$user = new User($row->follower_id);
			$info = $user->data();
			$profile_image;
			if(isset($info->avatar)) {
				$profile_image = $info->avatar;
			}else {
				$profile_image = './profile_image/default_image.jpg';
			}
			$output .= '<p><span style="display: inline-block;font-weight: lighter;opacity: 0.8"><img src='.$profile_image.' class="card-image">  <a href="user_profile.php?q_user='.$info->username.'">'.$info->username.'</a></span>
			</p><hr />';
		}
		echo $output;
		
	}
}