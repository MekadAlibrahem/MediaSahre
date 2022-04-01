<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> login page </title>
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

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      .form-signin{
        box-shadow: 3px 10px 22px 2px #aaa !important;
        border-radius: 24px !important;
      }
      .error{
        color:red ;
    }
    </style>

</head>
<body class="text-center">


     
    <main class="form-signin">
         <form  id="loginForm" accept-charset="utf-8"  >
            <img class="mb-4" src="../../resources/images/logo3.png" alt="logo" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal"> تسجيل الدخول </h1>
            <div class="form-floating" >
                <input type="text"  class="form-control" id="login-username" name="username" placeholder="name" require>
                <label for="login-email">اسم المستخدم </label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="login-Password" name="password" placeholder="Password" require>
                <label for="login-Password">كلمة المرور </label>
            </div>
            <button class="w-100 btn btn-lg  btn-primary" id="btn-login"  type="button">تسجيل الدخول </button>
            <a href="./index.php"> 
                <button class=" mt-4 w-100 btn btn-secondary btn-lg "  role="button"  type="button">
                    إالغاء 
                </button> 
                
            </a>
            <div id="loginErrorMsg" class="error" >
                
            </div>
        </form>
    </main>
      
    <?php 
        
        require_once "./layout/_linksjs.php" ;

    ?>
    
          <script> 
            $(document).ready(()=>{
                //  قواعد تحقق من إدخالات المستخدم 
                $("#loginForm").validate({
                        rules: {
                            username:{
                                required : true ,
                               
                            },
                            password: {
                                required : true ,
                                minlength : 4
                            }

                        },
                        messages: {
                            username : { 
                                required : "pleass entry email" ,
                                email :"pleass entre valid email like : example@gmail.com" 
                                },
                            password :{
                                required : "pleass entr password" ,
                                minlength: "pleass entre word biger than 4 character"
                            } 
                        },
                        errorElement: "em" ,
                        errorClass : "error" ,
                        onsubmit: false , 
                        onclick: true 
                        
                    });  
                //
                function showresult(data){
                    
                    document.getElementById("loginErrorMsg").innerHTML = data ;
                }

                $("#btn-login").on('click' ,()=>{
                if( $("#loginForm").valid() === true ){
                    username = $("#login-username").val() ; 
                    password = $("#login-Password").val() ;
                    $.ajax( "http://localhost/mediashare/php/api/apilogin.php" , 
                    {
                        type : "POST" ,
                        data : {'username' :  username , 'password' : password   } ,
                        success : function(data , status){
                            result = JSON.parse(data) ;
                            if(result.status === true){
                                window.location.href = result.href;
                            }else{ 
                                showresult("اسم المستخدم او كلمة المرور غير صحيح");
                            }
                           
                        },
                        error : function (jqXhr, textStatus, errorMessage) { 
                            // error callback 
                            alert('Error: ' + errorMessage); 
                        }
                    }
                    );
                    
                }
            });
           
            

            });
          </script>

    
</body>
</html>