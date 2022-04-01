const userid = id ;
const api_path = "http://localhost/mediashare/php/api/" ;
const lib_path = "http://localhost/mediashare/resources" ;
$.getScript( lib_path +"/js/users.js", function() {
    console.log("Script{users.js} loaded but not necessarily executed ");
});
$(document).ready(()=>{
   
    // validator user name   
    $("#editnameform").validate({
        rules: {
            name:{
                required : true   
            }
        },
        messages: {
            name : { 
                required : "الرجاء إدخال قيمة اولا " 
                }    
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    });  
    // end  validator name 
    // validator email 
    $("#emailform").validate({
        rules: {
            email:{
                required : true   ,
                email : true 
            }
        },
        messages: {
            email : { 
                required : "الرجاء إدخال قيمة اولا " ,
                email : " example@gmail.com الرجاء إدخال تنسيق بريد الكتروني صحيح مثل " 
                }    
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    }); 
    // end validator email 
    // validator passowrd 
    $("#passowrdfrom").validate({
        rules: {
            oldpassword:{
                required : true   
            },
            newpassword:{
                required : true   
            },
            confirmpassowrd:{
                required : true   
            }
        },
        messages: {
            oldpassword : { 
                required : "الرجاء إدخال قيمة اولا " ,
            },  
            newpassword : { 
                required : "الرجاء إدخال قيمة اولا " ,
            }, 
            confirmpassowrd : { 
                required : "الرجاء إدخال قيمة اولا " ,
                },
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    }); 
   
    //  api to edit user name 
    $("#btn-edit-name").on('click' ,()=>{
        if($("#editnameform").valid() === true) {
            username = $("#newname").val();
            $.ajax({
                
                url : api_path +"editusername.php" , 
                type: "POST" ,
                data:{"id": userid , "name" : username } ,
                success:function(data , status){
                  result  = JSON.parse(data);
                  if(result.status === true){
                        alert("تم تعديل الاسم بنجاح ");
                        $("#td-username").text(username);
                  }else{
                   $("#result_edit_name").text(result.error);
                  }
                },
                error : function (jqXhr, textStatus, errorMessage) { 
                    // error callback 
                    alert('Error: ' + errorMessage); 
                }
            });
        }
       
    });
    // api edit user email
    $("#btn-edit-email").on('click' ,()=>{
        if($("#emailform").valid() === true) {
            email = $("#newemail").val();
            $.ajax({
                
                url : api_path +"editemail.php" , 
                type: "POST" ,
                data:{"id": userid , "email" : email } ,
                success:function(data , status){
                  result  = JSON.parse(data);
                  if(result.status === true){
                        alert("تم تعديل البريد الالكتروني بنجاح ");
                        $("#td-email").text(email);
                  }else{
                   $("#result-edit-email").text(result.error);
                  }
                },
                error : function (jqXhr, textStatus, errorMessage) { 
                    // error callback 
                    alert('Error: ' + errorMessage); 
                }
            });
        }
       
    });
    // api edit password 
    $("#btn-edit-password").on('click' ,()=>{
        if($("#passowrdfrom").valid() === true) {
            old = $("#oldpassword").val();
            newp = $("#newpassword").val();
            confirm = $("#confirmpassowrd").val();
            if(newp === confirm){
                $.ajax({
                    url : api_path +"editpassword.php" , 
                    type: "POST" ,
                    data:{"id": userid , "old" : old , "new" : newp , "confirm"  : confirm} ,
                    success:function(data , status){
                      result  = JSON.parse(data);
                      if(result.status === true){
                            alert("تم تعديل كلمة المرور بنجاح ");
                            $("#result-edit-password").text("تم تعديل كلمة المرور بنجاح ");
                      }else{
                       $("#result-edit-password").text(result.error);
                      }
                    },
                    error : function (jqXhr, textStatus, errorMessage) { 
                        // error callback 
                        alert('Error: ' + errorMessage); 
                    }
                });
            }else{
                $("#result-edit-password").text("إن كلمة السر و تاكيدها غير متطابقين");
            }
           
        }
       
    });
   
    
    

    $("#btn-delete-user-account").on('click' , ()=>{
        conf = confirm("هل انت متاكد من انك تريد حذف الحساب");
        if(conf === true){
            $.ajax({
                url: api_path + "deleteAccount.php" ,
                type: "GET" ,
                data:{'id' : userid},
                success :function(data){
                    result = JSON.parse(data);
                    if(result.status === true){
                        window.location.href = result.href ;
                    }
                },
                error : function(jqxhr,textStatus , errorMessage){
                    alert('error' + errorMessage);
                }
            });
        }
        
    });
   

   
    
});