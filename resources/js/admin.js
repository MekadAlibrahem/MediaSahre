
const userid = id ;
const api_path = "http://localhost/mediashare/php/api/"  ;

function deleteUser(userid){
    conf = confirm("هل انت متاكد من انك تريد حذف الحساب");
    if(conf === true){
        $.ajax({
            url: api_path + "deleteUser.php" ,
            type: "GET" ,
            data:{'id' : userid},
            success :function(data){
                result = JSON.parse(data);
                if(result.status === true){
                    alert("تم حذف المستخدم بنجاح");
                    getAllUser();
                }else{
                    alert('error' + result.error);
                }
            },
            error : function(jqxhr,textStatus , errorMessage){
                alert('error' + errorMessage);
            }
        });
    }
}
    
function getUserCount(){
    $.ajax({
        url: api_path + "getUserCount.php" ,
        type: "GET" ,
        success :function(data){
            
            result = JSON.parse(data);
            if(result.status === true){
                $("#count-user").text(result.count);
            }else{
                alert(result.error);
                
            }
        },
        error : function(jqxhr,textStatus , errorMessage){
            alert('error' + errorMessage);
            
        }
    });
}

function getAllMemoryUsed(){
    $.ajax({
        url:api_path + "getAllMemoryUsed.php" ,
        type:"GET" ,
        success :function(data){
            
            result = JSON.parse(data);
            if(result.status === true){
                
                $("#memory-paid").text(result.count);
            }else{
                alert(result.error);
                
            }
        },
        error : function(jqxhr,textStatus , errorMessage){
            alert('error' + errorMessage);
            
        }
    });
}

function showUser(listUsers){
    $("#all-user").empty();
    listUsers.forEach(user => {
        $("#all-user").append("<tr> <td> "+user.userName +" </td><td> "+user.email +" </td><td> "+user.lastLogin +" </td><td>"+user.memory+"</td><td> <button onclick= 'deleteUser("+user.id+")' class='btn btn-danger form-control'><i class='fa fa-trash'></i></button> </td> </tr>");
    });
}
function getAllUser(){
    $.ajax({
        url:api_path + "getAllUser.php" ,
        type:"GET" ,
        success :function(data){
            
            result = JSON.parse(data);
            if(result.status === true){
                showUser(result.list);
            }else{
                alert(result.error);
                
            }
        },
        error : function(jqxhr,textStatus , errorMessage){
            alert('error' + errorMessage);
            
        }
    });
}

function getSizeMemory(){
    $.ajax({
        url:api_path + "getSizeMemory.php" ,
        type:"GET" ,
        success: function(data){
            result = JSON.parse(data);
            if(result.status === true){
                $("#size-memory").val(result.size);

            }else{
                alert(result.error);
                
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
    });
}

function getPriceMemory(){
    $.ajax({
        url:api_path + "getPriceMemory.php" ,
        type:"GET" ,
        success: function(data){
            result = JSON.parse(data);
            if(result.status === true){
                $("#price-memory").val(result.price);

            }else{
                alert(result.error);
                
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
    });
}
function getAllMemory(){
    $.ajax({
        url:api_path + "getAllMemory.php" ,
        type:"GET" ,
        success: function(data){
            result = JSON.parse(data);
            if(result.status === true){
                $("#all-memory").val(result.size);

            }else{
                alert(result.error);
                
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
    });
}
            
$(document).ready(()=>{

    getUserCount();    
    getAllMemoryUsed();   
    getAllUser();
    getSizeMemory();
    getPriceMemory();
    getAllMemory();
    $("#btn-edit-size-memory").on('click' , ()=>{
        newSize = $("#size-memory").val();

        $.ajax({
            url:api_path + "editSizeMemory.php" ,
            data:{'newSize' : newSize} ,
            type:"POST" ,
            success: (data)=>{
                result = JSON.parse(data);
                if(result.status === true){
                    $("#size-memory").val(result.size);
                    $("#result-edit-size-memory").empty().append("<p  style='color:green' > تم التعديل بنجاح</p>")

    
                }else{
                    $("#result-edit-size-memory").empty().append("<p  style='color:red' >"+ result.error +"</p>")
                    
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    });
    $("#btn-edit-price-memory").on('click' , ()=>{
        newPrice = $("#price-memory").val();

        $.ajax({
            url:api_path + "editPriceMemory.php" ,
            data:{'newSize' : newPrice} ,
            type:"POST" ,
            success: (data)=>{
                result = JSON.parse(data);
                if(result.status === true){
                    $("#price-memory").val(result.price);
                    $("#result-edit-price-memory").empty().append("<p  style='color:green' > تم التعديل بنجاح</p>")

    
                }else{
                    $("#result-edit-price-memory").empty().append("<p  style='color:red' >"+ result.error +"</p>")
                    
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    });
    $("#btn-edit-all-memory").on('click' , ()=>{
        newSize = $("#all-memory").val();

        $.ajax({
            url:api_path + "editallMemory.php" ,
            data:{'newSize' : newSize} ,
            type:"POST" ,
            success: (data)=>{
                result = JSON.parse(data);
                if(result.status === true){
                    $("#all-memory").val(result.size);
                    $("#result-edit-all-memory").empty().append("<p  style='color:green' > تم التعديل بنجاح</p>")

    
                }else{
                    $("#result-edit-all-memory").empty().append("<p  style='color:red' >"+ result.error +"</p>")
                    
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    });
     
});