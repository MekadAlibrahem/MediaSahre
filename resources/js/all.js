$(document).ready(function(){
    //  functions 
   
    RESOURCES_Path = "../../resources/" ;
    // change images in  servise  section 
        $("#servise-card-collaborate").hover(
            () =>{
                $("#img-collaborate").attr("src"  , RESOURCES_Path + "images/collaborate_color.svg" );
            } ,
            () =>{
                $("#img-collaborate").attr("src" ,RESOURCES_Path + "images/collaborate.svg") ;

            }
        );
        $("#servise-card-store").hover(
            ()=>{
                $("#img-store").attr("src"  , RESOURCES_Path + "images/store_color.svg" );
            } ,
            () => {
                $("#img-store").attr("src", RESOURCES_Path + "images/store.svg");

            }
        );
        $("#servise-card-access").hover(
            function(){
                $("#img-access").attr("src"  ,RESOURCES_Path +  "images/access_color.svg" );
            } ,
            function(){
                $("#img-access").attr("src" ,RESOURCES_Path + "images/access.svg") ;

            }
        );
    //
    

   
    //chake value in froms 
    $("#btn-login").click( ()=>{
          $("#loginForm").validate({
                rules: {
                    email:{
                        required : true ,
                        email:true 
                    },
                    password: {
                        required : true ,
                        minlength : 4
                    }

                },
                messages: {
                    email : { 
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
             
                onkeydown : false , 
                onfocusout :false ,
                success: function() {
                    console.log("done");
                }
                
            });  
        // end click fucntion       
    });
    
    $("#btn-signup").click( ()=>{
        $("#signupForm").validate({
            rules:{
                userName:{
                    required : true 
                },
                userEmail : { 
                    required : "pleass enter email" ,
                    email :"pleass enter valid email like : example@gmail.com" 
                 },
                userPassword :{
                    required : "pleass enter password" ,
                    minlength: "pleass enter word biger than 4 character"
                },
                confirmPassword:{
                    required : "pleass enter password" ,
                    minlength: "pleass enter word biger than 4 character"
                }

            },
            messages: {
                userEmail : { 
                    required : "pleass enter email" ,
                    email :"pleass entre valid email like : example@gmail.com" 
                    },
                    userName : { 
                        required : "pleass enter value " ,
                        
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
            onkeyup: false ,
            onkeydown : false , 
            onclick : false ,
            onfocusout :false ,
            success: function() {
                console.log("done");
            }
        });
        
    });
    

  
});