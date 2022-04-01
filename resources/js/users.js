

$(document).ready(()=>{
    const userid = id ;
    const api_path = "http://localhost/mediashare/php/api/" ;
      // statrt profile method 
          //  function show how match user used from his storage 
          function showspaceused(size , totalsize , formatSize , freeMemmory){

            $("#free-memory").val(freeMemmory);
          
            avr = size * 100 / totalsize ;
            avr = Math.round( ( avr + Number.EPSILON ) * 100 ) / 100 ;
            $("#storag").css('width' , avr+"%");
            $("#storag").removeClass(); 
            $("#storag").text(avr+"%");
            $("#storag").addClass('progress-bar'); 
            if(avr >=50 && avr <75){
                $("#storag").addClass('bg-success');
            }else if(avr >=75 && avr <85){
                $("#storag").addClass('bg-warning');
            }else if(avr >=85 ){
                $("#storag").addClass('bg-danger');
            }
            $("#memory-write").empty().append( formatSize + " / " + totalsize +"GB");
            
        }
        //

        //function get storag used 
        function getStorge(userid){
        
            $.ajax({
                url: api_path + "getstorag.php" ,
                data: {'id' : userid } ,
                type: "POST" ,
                success :function(data){
                    console.log(data);
                    result = JSON.parse(data);
                    if(result.status === true){
                        
                        showspaceused(result.size , result.total , result.formatSize , result.freeMemory);
                        // alert(result.size + " / " + result.total);
                    }
                },
                error : function(jqxhr,textStatus , errorMessage){
                    alert('error' + errorMessage);
                }
            });
        }
        $("#add-space-form").validate({
            rules: {
                "add-account":{
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
                "add-account" : { 
                    required : "الرجاء إدخال قيمة اولا " ,
                },  
                "add-password" : { 
                    required : "الرجاء إدخال قيمة اولا " ,
                }, 
                "add-count" : { 
                    required : "الرجاء إدخال قيمة اولا " ,
                    },
            },
            errorElement: "em" ,
            errorClass : "error" ,
            onsubmit: false , 
            onclick: true 
            
        });
        // totalprice
        $("#add-count").on('change' , ()=>{
            count = $("#add-count").val();
            $.ajax({
                url: api_path + "gettotalprice.php" ,
                data:{'count' : count},
                type: "POST" ,
                success :function(data){
                    result = JSON.parse(data);
                    if(result.status === true){
                        $("#totalprice").text("السعر الاجمالي : " +  result.price);
                    }
                },
                error : function(jqxhr,textStatus , errorMessage){
                    alert('error' + errorMessage);
                }
            });
        });

        //apt add more space
        $("#btn-add-space").on('click' , ()=>{
            if($("#add-space-form").valid() === true){
                account  = $("#add-account").val(); 
                password = $("#add-password").val();
                count    = $("#add-count").val();
                $.ajax({
                    url: api_path + "addMemory.php" ,
                    data:{"id" : userid , "account" : account , "password" : password , "count" : count} ,
                    type:"POST" ,
                    success: function(data){
                        result = JSON.parse(data) ;
                        if(result.status === true){
                            $("#totalprice").text("تم إضافة مساحة إضافية بنجاح ") ;
                            getStorge(userid);
                        }else{
                            alert("ERROR :" + result.error);
                        }
                    },
                    error : function(jqxhr , textStatus , errorMessage){
                        alert("ERROR : " + errorMessage);
                    }
                });
            }
        });
        $("#btn-loguot").on('click' , ()=>{
            $.ajax({
                url: api_path + "logout.php" ,
                type: "GET" ,
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
        });
         getStorge(userid);

});