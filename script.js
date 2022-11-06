$(document).ready(function() {
    $('time.timeago').timeago();

    $('.back_btn').click(function(e){
      e.preventDefault();
      window.history.back();
    });
    
  // MOBILE MENU CODE FOR SIDEBAR DISPLAY
  var overlay = $(".sidebar_menu_overlay");
  var sidebar_menu = $(".sidebar_wrapper");
  $("#navbar_toggler_btn").click(function(e) {
    e.preventDefault();
    overlay.addClass("show");
    sidebar_menu.addClass("show");
  });

  $(".sidebar_menu_overlay").click(function(e) {
    e.preventDefault();
    overlay.removeClass("show");
    sidebar_menu.removeClass("show");
  });
  $("#close_sidebar_btn").click(function(e) {
    e.preventDefault();
    overlay.removeClass("show");
    sidebar_menu.removeClass("show");
  });

  // PROFILE PAGE JS
  //
  //
  var img_preview = $(".img_preview");
  var img_preview_img = $("#img_preview_img");
  var img_preview_text = $("#img_preview_text");

  $("#file_image").change(function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      img_preview_text.css("display", "none");
      img_preview_img.css("display", "block");
      img_preview.addClass("p-0");

      reader.addEventListener("load", function() {
        // console.log(this);

        img_preview_img.attr("src", this.result);
      });

      reader.readAsDataURL(file);
    } else {
      img_preview_text.css("display", "block");
      img_preview_img.css("display", "none");
      img_preview.removeClass("p-0");
    }
  });

  // // Remove bio request
  // $("#remove_bio_btn").click(function(e) {
  //   e.preventDefault();
  //   var data_user_id = $(this).attr("data-user-id");
  //   // Ajax request
  //   $.ajax({
  //     url: "profile.php",
  //     method: "POST",
  //     dataType: "text",
  //     data: {
  //       data_user_id: data_user_id,
  //       edit_bio: 1
  //     },
  //     success: function(response) {
  //       // alert('sent!!!');
  //       if (response === "bio_removed") {
  //         window.location = window.location;
  //       }
  //     }
  //   });
  // });

  // EDIT BIO REQUEST
  // $("#edit_bio_btn").click(function(e) {
  //   // alert('clicked');
  //   e.preventDefault();
  //   var data_user_id = $(this).attr("data_user_id");
  //   $.ajax({
  //     url: "server.php",
  //     method: "POST",
  //     data: { data_user_id: data_user_id, edit_bio: 1 },
  //     success: function(response) {
  //       var hidden_field = $("#hidden_textarea_input");
  //       hidden_field.show().text(response);
  //       // hidden_field;
  //     }
  //   });
  // });

  // UPDATE BIO REQUEST

  $("#bio_edit_btn").click(function(e) {
    e.preventDefault();

    var bio_text = $("#hidden_textarea_input").val();
    var user_id = $("#hidden_user_id").attr("data_user_id");
    var errorMsgContainer = $("#bio_edit_errMsg");
    if (bio_text !== "") {
      $.ajax({
        url: "server.php",
        method: "POST",
        dataType: "text",
        data: { bio_text: bio_text, user_id: user_id, edit_bio_confirm: 1 },
        success: function(response) {
          if (response === "bio_updated_successfully") {
            window.location = window.location;
          }
        }
      });
    } else {
      errorMsgContainer.html(`<div class="alert alert-danger p-3 mb-3" style="border-radius:0px !important">
          <p class="mb-0">Please Input Bio Info Or cancel the Operation!</p>
          </div>`);
    }
  });

  $("#remove_image").click(function(e) {
    e.preventDefault();
    var data_user_id = $(this).attr("data_user_id");

    $.ajax({
      url: "profile.php",
      method: "POST",
      dataType: "text",
      data: { remove_image: 1, data_user_id: data_user_id },
      success: function(response) {
        if (response === "profile_image_updated") {
          window.location = window.location;
        }
      }
    });
  });

  // END OF PROFILE PAGE JS
  //
  //

  //
  //
  //
  // MAIN PAGE JS
  //
  //
  // $('#popover-avatar').popover({
  //   html: true,
  //   container: 'body',
  //   content: function(){
  //     return $('.dropdown-menu').html();
  //     }
  // });

  var pass = $("#pass");
  var pass_signIn = $("#Password");
  var verify_pass = $("#Vpassword");
  $(".fa-eye-slash").click(function() {
    if (pass.attr("type") == "password") {
      $visibility = $(this);
      pass.attr("type", "text");
      pass_signIn.attr("type", "text");
      verify_pass.attr("type", "text");
      $visibility.removeClass("fa-eye-slash");
      $visibility.addClass("fa fa-eye");
    } else {
      pass.attr("type", "password");
      pass_signIn.attr("type", "password");
      verify_pass.attr("type", "password");
      $visibility.removeClass("fa-eye");
      $visibility.addClass("fa fa-eye-slash");
    }
  });

  var gender = "male";
  $("#gender_select").change(function() {
    var gender_option = $(".gender_option");

    for (var i = 0; i < gender_option.length; i++) {
      gender = $(this).val();
    }
  });
  $("#submit").click(function(e) {
    e.preventDefault();

    var username = $("#Username").val();
    var email = $("#Email").val();
    var password = $("#Password").val();
    var verify_password = $("#Vpassword").val();
    var phone_number = $("#Phone").val();
    if (
      username !== "" &&
      email !== "" &&
      password !== "" &&
      verify_password !== "" &&
      phone_number !== ""
    ) {
      $("#errorMsg").text("");

      $.ajax({
        url: "server.php",
        method: "POST",
        dataType: "text",
        data: {
          register: 1,
          username: username,
          email: email,
          password: password,
          verify_password: verify_password,
          phone_number: phone_number,
          gender: gender
        },
        success: function(response) {
          var username = $("#Username");
          var email = $("#Email");
          var password = $("#Password");
          var verify_password = $("#Vpassword");
          var phone_number = $("#Phone");

          if (response === "userTaken") {
            $("#errorMsg").text("Username already taken by another user!");
            username.css("border-color", "#dc3545");
          } else {
            username.css("border-color", "");
          }
          if (response === "userTooLong") {
            $("#errorMsg").text("Username is too long! max of 25 characters.");
            username.css("border-color", "#dc3545");
          } else {
            username.css("border-color", "");
          }
          if (response === "invalidUser") {
            $("#errorMsg").text(
              "Username contains invalid characters - (Username must be between 3-30 characters long)!"
            );
            username.css("border-color", "#dc3545");
          } else {
            username.css("border-color", "");
          }
          if (response === "invalidEmail") {
            $("#errorMsg").text("Invalid Email Address!");
            email.css("border-color", "#dc3545");
          } else {
            email.css("border-color", "");
          }
          if (response === "passwordMismatch") {
            $("#errorMsg").text("The two passwords didn't match!");
            password.css("border-color", "#dc3545");
            verify_password.css("border-color", "#dc3545");
          } else {
            password.css("border-color", "");
            verify_password.css("border-color", "");
          }

          if (response === "success") {
            $("#successMsg").text("Account Created Successfully!!!");
            username.val("");
            email.val("");
            password.val("");
            verify_password.val("");
            phone_number.val("");
          }
        }
      });
    } else {
      // var username = $('#Username');
      // var email = $('#Email');
      // var password = $('#Password');
      // var verify_password = $('#Vpassword');
      $("#errorMsg").text("Please fill all inputs!");
      // alert('enter all fields');
      // username.css('border-color', '#dc3545');
      // email.css('border-color', '#dc3545');
      // password.css('border-color', '#dc3545');
      // verify_password.css('border-color', '#dc3545');
    }
  });

  var modal = $("#simpleModal");
  var closeBtn = $(".closeBtn");
  var modalBtn = $(".img-link");
  var controlBtn = $(".controlBtn");
  var modalContent = $(".modal-content");
  $(".img-link").click(function(event) {
    var clicked_img = $(this);
    var name = clicked_img
      .parent()
      .parent()
      .next()
      .text();
    var imgPath = clicked_img
      .parent()
      .parent()
      .next()
      .children(".card-image")
      .attr("src");

    var userImg = $("#userImg");
    // alert(imgPath);
    var img = clicked_img.attr("src");
    var modalImg = $("#modalImg");
    modalImg.attr("src", `${img}`);
    $("span.name").html(
      `<a href="#" style="text-decoration:none">${name}</a> <small class="ml-2 text-secondary" style="opacity:0.8"> 2019-09-18 18:06:07</small>`
    );
    userImg.attr("src", `${imgPath}`);
    modal.css("display", "flex");
    $(".modal-content").addClass("transition");
  });
  closeBtn.click(function() {
    modal.css("display", "none");
    $(".modal-content").addClass("transition");
  });
  // modal.click(function(e){
  //   modal.css('display','none');
  //   if (e.target == controlBtn || modalContent) {
  //   modal.css('display','flex');
  //   }
  // })

  // LOGIN REQUSET AND VALIDATION
  $("#loginBtn").click(function(e) {
    e.preventDefault();

    var email = $("#email").val();
    var password = $("#pass").val();
    var remember_checked = $("#remember_me").prop('checked');
    var remember;
    if(remember_checked) {
      remember = "on";
    }else {
      remember = "off";
    }
    

    if (email != "" && password != "") {
      // PASSED
      $("#errorMsg").text("");
      $.ajax({
        url: "server.php",
        method: "POST",
        dataType: "text",
        data: {
          logIn: 1,
          email: email,
          remember:remember,
          password: password
        },
        success: function(response) {
          var Email = $("#email");
          var Password = $("#pass");
          console.log(response);
          if (response == "failed") {
            $("#logInerrorMsg")
              .html(`<div class="alert alert-danger p-3 mb-0" style="border-radius:0px !important">
          <p class="mb-0">That didn't work, please try again!</p>
          </div>`);
          } else {
            window.location = window.location;
          }
        }
      });
    } else {
      // FAILED
      $("#logInerrorMsg").text("Please fill all inputs!");
      $("#email").css("border-color", "#dc3545");
      $("#pass").css("border-color", "#dc3545");
    }
  });
  // END OF LOGIN REQUEST

  // });

  // Validate User logged in or not for mobile and small screens
  $("#mobile_upload_btn").click(function(e) {
    e.preventDefault();
    var loggedIn = $(this).attr("data_logged_in");
    if (loggedIn !== "") {
      return true;
    } else {
      // alert('You need to log in before proceeding with the operation!');
      $("#mobile_logIn").click();
      $("#logInerrorMsg").text(
        "You need to log Into your Account before proceeding!"
      );
      return false;
    }
  });

  // Validate User login or not

  $("#upload_btn").click(function() {
    var loggedIn = $(this).attr("data_logged_in");
    if (loggedIn !== "") {
      return true;
    } else {
      // alert('You need to log in before proceeding with the operation!');
      $("#login").click();
      $("#logInerrorMsg").text(
        "You need to log Into your Account before proceeding!"
      );
      return false;
    }
  });

  $("#signin_btn").click(function(e) {
    e.preventDefault();
    $("#signin").click();
  });

  $("#login").click(function() {
    $("#logInerrorMsg").text("");
  });

  $("#mobile_logIn").click(function(e) {
    e.preventDefault();
    $("#logInerrorMsg").text("");
  });

  // INSERT SOCIAL MEDIA INFO REQUEST
  $("#insert_info_btn").click(function(e) {
    e.preventDefault();
    // alert('clicked');
    var facebook_username = $("#facebook").val();
    var instagram_username = $("#instagram").val();
    var user_id = $("#user_id").attr("data_user_id");
    if (facebook_username !== "" || instagram_username !== "") {
      $("#errorMsg").html("");
      // PASSED
      // alert('passed!');
      $.ajax({
        url: "server.php",
        method: "POST",
        dataType: "text",
        cache: false,
        data: {
          facebook_username: facebook_username,
          instagram_username: instagram_username,
          user_id: user_id,
          edit_social_info: 1
        },
        success: function(response) {
          // console.log(response);
          if (response === "social_info_updated") {
            window.location = window.location;
          }
        }
      });
    } else {
      // FAILED
      $("#errorMsg")
        .html(`<div class="alert alert-danger p-3 mb-2" style="border-radius:0px !important">
      <p class="mb-0">Please Fill in all fields!</p>
      </div>`);
    }
  });

  // REMOVE SOCIAL MEDIA INFO REQUEST

  $("#remove_info_btn").click(function(e) {
    e.preventDefault();
    var user_id = $(this).attr("data_user_id");
    $.ajax({
      url: "server.php",
      method: "POST",
      cache: false,
      dataType: "text",
      data: { user_id: user_id, remove_social_info: 1 },
      success: function(response) {
        if (response === "social_info_removed") {
          window.location = window.location;
        }
      }
    });
  });
reaction();
  // Validate User login or not
  function reaction() {
    $(".fa-heart").click(function(e) {
      var loggedIn = $(this).attr("data_logged_in");
      var reaction;
      var current_element = $(this).attr("data_liked");
      if (loggedIn !== "") {
        if (current_element == "0") {
          reaction = "like";
        }
  
        if (current_element == "1") {
          reaction = "unlike";
        }
        var user_id = $(this).attr("data_user_id");
        var post_id = $(this).attr("data_post_id");
        $.ajax({
          url: "server.php",
          method: "POST",
          dataType: "json",
          data: {
            user_id: user_id,
            post_id: post_id,
            reaction: reaction,
            post_reaction: 1
          },
          success: function(response) {
  
            get_likes_count();
            user_liked_posts();
            var count_likes = $(".fa-heart");
            if (response.reaction === "liked") {
              for (var i = 0; i < count_likes.length; i++) {
                if (
                  count_likes[i].getAttribute("data_post_id") ==
                    response.post_id &&
                  count_likes[i].getAttribute("data_liked") == "0"
                ) {
                  count_likes[i].setAttribute("data_liked", "1");
                  count_likes[i].style.color = "#dc3545";
                  count_likes[i].classList.add("liked");
                  // alert('liked');
                }
                // console.log(count_likes[i].attributes.data_post_id.value);
              }
            }
            if (response.reaction === "unliked") {
              for (var i = 0; i < count_likes.length; i++) {
                if (
                  count_likes[i].getAttribute("data_post_id") ==
                    response.post_id &&
                  count_likes[i].getAttribute("data_liked") == "1"
                ) {
                  count_likes[i].setAttribute("data_liked", "0");
                  count_likes[i].style.color = null;
                  count_likes[i].classList.remove("liked");
                  // alert('liked');
                }
                // console.log(count_likes[i].attributes.data_post_id.value);
              }
            }
  
            // console.log($(this));
            // if (response === "post_liked") {
            //   $(this).attr("data_liked", "1");
            //   $(this).css("color", "lightblue !important");
            //   alert($(this));
            //   console.log($(this));
            // }
            // if (response === "post_unliked") {
            //   $(this).attr("data_liked", "0");
            //   alert("post unliked");
            // }
            // console.log($(this));
          }
        });
      } else {
        // alert('You need to log in before proceeding with the operation!');
        $("#login").click();
        $("#logInerrorMsg").text(
          "You need to log Into your Account before proceeding!"
        );
        return false;
      }
    });
  }



  get_comments_count();
  get_views_count();

  // setInterval(function(){
  get_likes_count();
  // },3000);

  // FUNCTIONS TO SEND REQUEST TO server

  function get_likes_count() {
    $.ajax({
      url: "server.php",
      method: "POST",
      dataType: "json",
      data: { get_likes_confirm: 1 },
      success: function(response) {
        // console.log(response);
        // alert(response);
        let count_likes = $(".fa-heart");
        // var arr_len = Math.floor(response.length/2);
        // var data_work_id = response.slice(0,arr_len + 1);
        // var data_user_id = response.slice(arr_len, response.length - 1);
        // if (check_loggedInUser()) {
        //   var loggedInUser = response.slice(-1, response.length);
        // }else {
        //   var loggedInUser = false;
        // }
        // var loggedInUser = response.slice()

        let work_id = [];
        let counts = [];



        for (item in response) {
          work_id.push(item);
          counts.push(response[item]);
        }


        for (var i = 0; i < count_likes.length; i++) {
          if (work_id.includes(count_likes[i].getAttribute("data_post_id"))) {
            var index = work_id.indexOf(
              count_likes[i].getAttribute("data_post_id")
            );

            count_likes[i].nextElementSibling.textContent =
              "" + counts[index] + "";
          } else {
            count_likes[i].nextElementSibling.textContent = "0";
          }
        }

      }
    });
  }

  // function to get views count
  function get_views_count() {
    $.ajax({
      url: "server.php",
      method: "POST",
      dataType: "json",
      data: { get_views_confirm: 1 },
      success: function(response) {
        let count_likes = $(".fa-eye");
        for (let i = 0; i < count_likes.length; i++) {
          count_likes[i].nextElementSibling.textContent = "0";
          for (let index = 0; index < response.length; index++) {
            for(item in response[index]) {
              if(count_likes[i].getAttribute("data_post_id") == item) {            
                count_likes[i].nextElementSibling.textContent = response[index][item];
              }
            }
        }

      }
    }
    });
  }



  function check_loggedInUser() {
    var element = $("#log_check").attr("data_logged_in");
    if (element) {
      return true;
    } else {
      return false;
    }
  }
  let loggedInUser;

  user_liked_posts();

  // CONSOLE LOG SHORTHAND FUNCTION TO SAVE TIME

  function cl(value) {
    return console.log(value);
  }

  // FUNCTION TO GET USERS PER POST(LIKES)

  function user_liked_posts() {
    if (check_loggedInUser()) {
      // LOGGED_IN - RETURN TRUE AND SEND REQUEST
      var auth_user_id = $("#log_check").attr("data_auth_id");
      $.ajax({
        url: "server.php",
        method: "POST",
        dataType: "json",
        data: { auth_user_id: auth_user_id, user_liked_posts: 1 },
        success: function(response) {
          let items = $(".fa-heart");
          for (var i = 0; i < items.length; i++) {
            for (let ii = 0; ii < response.length; ii++) {
              if (items[i].getAttribute('data_post_id') == response[ii]) {
                items[i].style.color = "#dc3545";
              }
              
            }
          }
        }
      });
    } else {
      // NOT LOGGED_IN - RETURN FALSE
      return false;
    }
  }
// get the nnumber of comments a particular work has

function get_comments_count() {
  $.ajax({
    url: 'server.php',
    method: 'GET',
    dataType: 'JSON',
    data: {get_comments_count:1},
    success:function(response) {
      let count_likes = $(".fa-comments");


      let work_id = [];
      let counts = [];



      for (item in response) {
        work_id.push(item);
        counts.push(response[item]);
      }


      for (var i = 0; i < count_likes.length; i++) {
        if (work_id.includes(count_likes[i].getAttribute("data_post_id"))) {
          var index = work_id.indexOf(
            count_likes[i].getAttribute("data_post_id")
          );

          count_likes[i].nextElementSibling.textContent =
            "" + counts[index] + "";
        } else {
          count_likes[i].nextElementSibling.textContent = "0";
        }
      }
    }
  });
}


/*
Get current nav-tab text and fetch the matched rows from database

*/

$('.nav-filter').click(function(e){
  let filter_text = $(this).attr('href');
  let text = filter_text.slice(1,filter_text.length);
// alert(text);
  $.ajax({
    url: 'server.php',
    method: 'GET',
    dataType: 'html',
    data:{filter_text:text,filter_tab:1},
    success:function(response) {
      $('.filter_results').html(response);
      reaction();
      get_views_count();

      get_likes_count();
      user_liked_posts();
        $('.img-link').click(function(){
          let post_id = $(this).attr('data_post_id');
          let img_src = $(this).attr('src');
          $('#preview_img_modal').attr('src',img_src);
          $("#read_more_btn").attr('href','view_work.php?id='+post_id+'');
        });
      
    }
  });
});
get_following();
get_followers();

// follow request
$('#follow_btn').click(function(e){
  
e.preventDefault();
let follow_user_id = $(this).attr('data_user_id');

  if(check_loggedInUser()) {
    $.ajax({
      url: 'server.php',
      method: 'POST',
      dataType: 'text',
      data:{follow_user_id:follow_user_id,follow_request:1},
      success(response) {
        get_following();
        get_followers();
        if(response === 'follow') {
          $('.followed_badge').html('Following <i class="fa fa-check"></i>');
          $('#follow_btn strong').text('unfollow');
        }else {
          $('.followed_badge').html('');
          $('#follow_btn strong').text('follow');
        }
      }
    });
  }else {
    $("#login").click();
    $("#logInerrorMsg").text("You need to log Into your Account before proceeding!");
  }
});


// get followers request
function get_followers() {
  let user_id = $('#user_profile_id').attr('data_user_profile_id');
  $.ajax({
    url: 'server.php',
    method: 'GET',
    data: {user_id:user_id,get_followers:1},
    success:function(response) {
        $('.followers strong').text(response);
      
    }
  });
}

// get following request
function get_following() {
  let user_id = $('#user_profile_id').attr('data_user_profile_id');
  $.ajax({
    url: 'server.php',
    method: 'GET',
    data: {user_id:user_id,get_following:1},
    success:function(response) {
        $('.following strong').text(response);
      
    }
  });
}
// $('.fa-comments').click(function(e){
//   let comment_error = $('.comment_error');
//   comment_error.text(''); 
//   let user_id = $(this).attr('data_user_id');
//   work_id = $(this).attr('data_post_id');
//   get_comments(work_id);


let data_work_id = $('#data_work_id').attr('data_work_id');

// SUBMIT COMMENT REQUEST
$('#submit_comment').click(function(e){
  e.preventDefault();
  let user_id = $('#user_id').val();
  let work_id = $('#work_id').val();

  let comment_text = $('#comment_text').val();
  if(comment_text == '') {
    comment_error.text('Please Input some texts!');
  }else {
    comment_text = comment_text;
    $.ajax({
      url: 'server.php',
      method: 'POST',
      dataType:'text',
      data: {user_id:user_id,work_id:work_id,comment_text:comment_text,comment:1},
      success:function(response) {
        get_comments(data_work_id);
        if(response === 'empty_fields') {
          comment_error.text('Please Input some texts...');
        }else {
         $('#comment_text').val(''); 
        }
      }
    });
  }
});

// SUBMIT GUEST COMMENT REQUEST
$('#guest_comment_btn').click(function(e){
  e.preventDefault();
  let work_id = $('#work_id').val();

  let comment_text = $('#guest_comment').val();
  let guest_name = $('#guest_fullname').val();
  if(comment_text == '' || guest_name == '') {
    $('.guest_comment_error').text('Please fill in all fields!');
  }else {
    comment_text = comment_text;
    guest_name = guest_name;
    $.ajax({
      url: 'server.php',
      method: 'POST',
      dataType:'text',
      data: {work_id:work_id,comment_text:comment_text,guest_name:guest_name,guest_comment:1},
      success:function(response) {
        get_comments(data_work_id);
        if(response === 'empty_fields') {
          $('.guest_comment_error').text('Please Input some texts...');
        }else {
         $('#guest_comment').val('');
         $('#guest_fullname').val(''); 
        }
      }
    });
  }
});
// });
get_comments(data_work_id);

setInterval(function(){
  get_comments(data_work_id);
},5000);

function get_comments(work_id) {
  $.ajax({
    url: 'server.php',
    method: 'GET',
    data: {get_comments:1,work_id:work_id},
    success:function(response) {
      $('time.timeago').timeago();
      $('.comments').html(response);
      let count = $('.comment').length;
      $('#comment-count').text(count)
      $('time.timeago').timeago();

    }
  });
}


// SEND REQUEST TO FETCH ALL THE USER_ID'S OF THE OTHER USERS THAT THIS PARTICULAR USER IS FOLLOWING
$('.following').click(function(){
let user_id = $('#user_profile_id').attr('data_user_profile_id');
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
$('.followers').click(function(){
  let user_id = $('#user_profile_id').attr('data_user_profile_id');
    $.ajax({
      url: 'server.php',
      method: 'get',
      data: {user_id:user_id,followers_info:1},
      success:function(response) {
        $('.followers_container').html(response);
      }
    });
  });
  //

  //
  //
  //
  // END OF MAIN PAGE JS
  //
  //
});

