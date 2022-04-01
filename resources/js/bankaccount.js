$(document).ready(()=>{
    // validate forms  
    const api_path = "http://localhost/mediashare/php/api/" ;
    $("#add-account-form").validate({
        rules: {
            'add-account':{
                required : true   
            },
            "add-password":{
                required : true 
            },
            "add-count":{
                required : true 
            }

        },
        messages: {
            'add-account': { 
                required : "الرجاء إدخال قيمة اولا " 
                },
            "add-password": { 
                required : "الرجاء إدخال قيمة اولا " 
                },
            "add-count": { 
                required : "الرجاء إدخال قيمة اولا " 
                }     
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    }); 
    $("#del-account-form").validate({
        rules: {
            'del-account':{
                required : true   
            },
            "del-password":{
                required : true 
            }

        },
        messages: {
            'del-account': { 
                required : "الرجاء إدخال قيمة اولا " 
                },
            "del-password": { 
                required : "الرجاء إدخال قيمة اولا " 
                }    
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    });
    $("#edit-account-form").validate({
        rules: {
            'edit-account':{
                required : true   
            },
            "edit-password":{
                required : true 
            },
            "edit-count":{
                required : true 
            }

        },
        messages: {
            'edit-account': { 
                required : "الرجاء إدخال قيمة اولا " 
                },
            "edit-password": { 
                required : "الرجاء إدخال قيمة اولا " 
                },
            "edit-count": { 
                required : "الرجاء إدخال قيمة اولا " 
                }     
        },
        errorElement: "em" ,
        errorClass : "error" ,
        onsubmit: false , 
        onclick: true 
        
    });    

    $("#add-new-account").on('click' , ()=>{
        if($("#add-account-form").valid() === true) {
            account = $("#add-account").val() ;
            password = $("#add-password").val();
            count    = $("#add-count").val();
            $.ajax({
                
                url : api_path +"addBankAccount.php" , 
                type: "POST" ,
                data:{"account": account , "password" : password , 'count' : count } ,
                success:function(data , status){
                  result  = JSON.parse(data);
                  if(result.status === true){
                        $("#result-add-new-account").text(" تم إضافة الحساب بنجاح ");
                        
                  }else{
                   $("#result-add-new-account").text(result.error);
                  }
                },
                error : function (jqXhr, textStatus, errorMessage) { 
                    // error callback 
                    alert('Error: ' + errorMessage); 
                }
            });
            getAllAccount();
        }
    });
    $("#btn-del-account").on('click' , ()=>{
        if($("#del-account-form").valid() === true) {
            account = $("#del-account").val() ;
            password = $("#del-password").val();
            $.ajax({
                
                url : api_path +"delBankAccount.php" , 
                type: "POST" ,
                data:{"account": account , "password" : password  } ,
                success:function(data , status){
                  result  = JSON.parse(data);
                  if(result.status === true){
                        $("#result-del-account").text(" تم حذف الحساب بنجاح ");
                        
                  }else{
                   $("#result-del-account").text(result.error);
                  }
                },
                error : function (jqXhr, textStatus, errorMessage) { 
                    // error callback 
                    alert('Error: ' + errorMessage); 
                }
            });
        }
        getAllAccount();
    });
    $("#edit-count-account").on('click' , ()=>{
        if($("#edit-account-form").valid() === true) {
            account = $("#edit-account").val() ;
            password = $("#edit-password").val();
            count    = $("#edit-count").val();

            $.ajax({
                
                url : api_path +"editBankAccount.php" , 
                type: "POST" ,
                data:{"account": account , "password" : password  , "count" :count } ,
                success:function(data , status){
                  result  = JSON.parse(data);
                  if(result.status === true){
                        $("#result-edit-count").text(" تم تعديل  الحساب بنجاح ");
                        
                  }else{
                   $("#result-edit-count").text(result.error);
                  }
                },
                error : function (jqXhr, textStatus, errorMessage) { 
                    // error callback 
                    alert('Error: ' + errorMessage); 
                }
            });
        }
        getAllAccount();
    });
    
   
    function showAllAcount(listAccout){
        $("#Accounts").empty();
        listAccout.forEach(account => {
            $("#Accounts").append("<tr>  <td> "+account.name+" </td> <td> "+ account.password +" </td> <td> "+ account.count+" </td> </tr>");
        });
       
    }
    function getAllAccount(){
        $.ajax({
                
            url : api_path +"getAllBankAccount.php" , 
            type: "GET" ,
            
            success:function(data , status){
              result  = JSON.parse(data);
              if(result.status === true){
                showAllAcount(result.list);         
                    
              }else{
               $("#account-error").text(result.error);
              }
            },
            error : function (jqXhr, textStatus, errorMessage) { 
                // error callback 
                alert('Error: ' + errorMessage); 
            }
        });
    }
    getAllAccount();
  
});