<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> new account </title>
    <link rel="stylesheet" href="../../resources/bootstrap-5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/css/signin.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      .form-signin{
        box-shadow: 3px 10px 22px 2px #aaa !important;
        border-radius: 24px !important;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .error{
        color:red ;
      }
    </style>

</head>
<body class="text-center" >


     
        <main class="form-signin" accept-charset="utf-8">
            <form id="signupForm" method="POST" action="signup.php">
            <img class="mb-4" src="../../resources/images/logo3.png" alt="logo" width="72" height="57">
              <h1 class="h3 mb-3 fw-normal"> إنشاء حساب جديد </h1>
              <div class="form-floating">
                <input type="text" class="form-control"  id="username" name="userName" placeholder="username" require>
                <label for="signupName">اسم المستخدم</label>
              </div>
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="userEmail" placeholder="name@example.com" require>
                <label for="signupemail">البريد الالكتروني</label>
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="userPassword" placeholder="Password" require>
                <label for="signuppassword">كلمة المرور </label>
              </div>
              <div class="form-floating">
                <input type="password" class="form-control" id="confirmpassword" name="confirmPassword" placeholder="Password" require>
                <label for="signuppasswordconfirm"> تاكيد كلمة المرور  </label>
              </div>
              <button class="w-100 btn btn-lg btn-primary" id="btn-signup"  type="button">إنشاء حساب جديد</button>
              <a href="./index.php"> 
                 <button class=" mt-4 w-100 btn btn-secondary btn-lg "  role="button"  type="button">
                    إالغاء 
                 </button> 
                 
              </a>
              <div id="signupErrorMsg"  class="error" >

              </div>
            </form>
    </main>
      
    <?php 
        
        require_once "./layout/_linksjs.php" ;

    ?>
    
          <script> 
            $(document).ready(()=>{
              $("#signupForm").validate({
                  rules:{
                      userName:{
                          required : true 
                      },
                      userEmail : { 
                          required : true ,
                          email :true 
                      },
                      userPassword :{
                          required : true,
                          minlength: 4
                      },
                      confirmPassword:{
                          required : true ,
                          minlength: 4
                      }

                  },
                  messages: {
                      userEmail : { 
                          required : "pleass enter email" ,
                          email :"pleass entre valid email like : example@gmail.com" 
                          },
                          userName : { 
                              required : "pleass enter value " 
                              
                          }, 
                      userPassword :{
                          required : "pleass enter password" ,
                          minlength: "pleass enter word biger than 4 character"
                      },
                      confirmPassword :{
                          required : "pleass enter password" ,
                          minlength: "pleass enter word biger than 4 character"
                      }  
                  },
                  errorElement: "em" ,
                  errorClass : "error" ,

                        
              });
              function showresult(msg){  
                  $("#signupErrorMsg").empty().append(msg) ;
              }
              $("#btn-signup").click( ()=>{
                  if( $("#signupForm").valid() ===true){
                    username          = $("#username").val() ;
                    email         = $("#email").val() ;
                    password          = $("#password").val();
                    confirmPassword   = $("#confirmpassword").val();
                    if(confirmPassword != password){
                      console.log("error password ")
                      showresult("كلمة المرور و تاكيدها غير متطابقان ") ;
                      return ;
                    }else{
                      $.ajax({
                        url : "http://localhost/mediashare/php/api/apinewaccount.php" , 
                        type: "POST" ,
                        data:{"username": username , "email" : email , "password" : password} ,
                        success:function(data , status){
                          result  = JSON.parse(data);
                          if(result.status === true){
                            window.location.href = result.href ;
                          }else{
                            showresult(result.error);
                          }
                        },
                        error : function (jqXhr, textStatus, errorMessage) { 
                            // error callback 
                            alert('Error: ' + errorMessage); 
                        }
                      });
                    }
                  }
              });

              
            });
          </script>

    
</body>
</html>