
const userid= id; 
const api_path = "http://localhost/mediashare/php/api/"  ;
const lib_path = "http://localhost/mediashare/resources" ;
var fileid  = 0 ;


$.getScript( lib_path +"/js/users.js", function() {
    console.log("Script {{user.js}} loaded but not necessarily executed");
});
$.getScript( lib_path +"/js/JSZip.js", function() {
    console.log("Script {{JSZip.js}} loaded but not necessarily executed");
});
$.getScript( lib_path +"/js/copy.js", function() {
    console.log("Script {{copy.js}} loaded but not necessarily executed");
});


function copylink(text) {
    var input = document.createElement('textarea');
    input.innerHTML = text;
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    alert("تم نسخ الرابط");
    return result;
}
function editName(id ){
    fileid = id ;  
}
function getListView(fileid){
    $.ajax({
        url:api_path + "getListView.php" ,
        data:{'fileid': fileid , 'userid' : userid },
        type:"POST" ,
        success: function(data){
            result = JSON.parse(data);
            console.log(data);
            if(result.status === true){
                showListView(result.listView ,fileid);
            }else{
                $("#view-list").empty().append("<em style='color:red;'>"+result.error+"</em>");  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
    });
}
function lock(id){
    fileid = id ;
    getListView(id);
}
function deleteFile(id){
    fileid = id ;
    courentfolder = $("#courent-folder").val();
    conf = confirm("هل انت متاكد من انك تريد حذف هذا الملف او المجلد");
    if(conf === true){
        $.ajax({
            url:api_path + "deleteFile.php" ,
            data:{'fileid': fileid , 'userid' : userid },
            type:"POST" ,
            
            success: function(data){
                getFilesInDir(userid , courentfolder );
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    }
                          
}
function download(id){
    $.ajax({
        url:api_path + "downloadMyfile.php" ,
        data:{'fileid': id , 'userid' : userid },
        type:"POST" ,
        success: function(data){
            result = JSON.parse(data);
            if(result.status === true){
             window.open(api_path + "/download/downloads.php?f="+result.f,"newwindowname",'_blank', 'toolbar=0,location=0,menubar=0');
                
            }else{
                alert(result.error);  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
    });
    
}
function showFiles(list){
    $("#list-files").empty();
    list.forEach(item => {
        icon ="fa fa-folder" ;
        if(item.isFile === 1){
        icon = "fa fa-file" ;
        }
        row = " <tr class='file-item' >"+ 
                "<td> <input type='checkbox' class='form-check'  name='"+ item.name +"'  value='"+ item.id +"' > </td>" +
                "<td class=''><button   ondblclick='getFilesInDir("+userid+" ,"+item.id+");'> <i class= '"+icon+"'>  </i> "+item.name+"</button> </td>" +
                "<td> "+item.type+" </td>"+
                "<td id='size_file_"+item.id+"' > "+item.size+"  </td>"+
                "<td> "+
                    "<div class='btn-group text-end' role='group' aria-label='Basic mixed styles example'>"+
                    "<button class='btn btn-primary' type='button' onclick='copylink(\'"+item.link+"\');'> <i class='fa fa-link'> </i></button>" +
                    "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#modelEditFileName' type='button' onclick='editName("+item.id+");'> <i class='fa fa-edit'> </i></button>" +
                    "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#' type='button' onclick='download("+item.id+");'> <i class='fa fa-download'> </i></button>" +
                    "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#modelEditType' type='button' onclick='lock("+item.id+");'  > <i class='fa fa-lock'> </i></button>" +
                    "<button class='btn btn-danger' type='button' onclick='deleteFile("+item.id+");' > <i class='fa fa-trash'> </i></button>"  +

                    "</div>"+
                "  </td>"+

               
        
            +"</tr>  " ;
            // "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#modelCopy' type='button' onclick='copy("+item.id+");'    > <i class='fa fa-copy'> </i></button>" +
            //             "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#modelCut' type='button' onclick='cut("+item.id+");'     > <i class='fa fa-cut'> </i></button>" +
                        
            $("#list-files").append(row);
    });

}
function showCurrentPath(listPath){
    $("#current-path").empty();
    path = ' <li class="breadcrumb-item"></li>';
    input = '';
    if(listPath.count > 0){
        listPath[0].forEach(folder => {
            if(folder.end == 1){
                $("#courent-folder").val(folder.id);
                $(document).html(input);
                path += '<li class="breadcrumb-item active" aria-current="page" > <button  type="button" data-target="'+folder.id+'" onclick="getFilesInDir('+userid+','+folder.id+');"> '+folder.name+' </button></li>';
            }else{
                path += '<li class="breadcrumb-item"><button type="button" onclick="getFilesInDir('+userid+','+folder.id+');"> '+folder.name+' </button></li>';

            }
        });

    }
    
    $("#current-path").append(path);
   
}
function getFilesInDir(userid , foldeid){
    $.ajax({
        url: api_path + "getFilesInDir.php" ,
        data:{'userid' : userid , 'foldeid' : foldeid},
        type:"POST" ,
        success: function(data){
            result = JSON.parse(data);
            
            if(result.status === true){
               showFiles(result.list)
               showCurrentPath(result.path );
            }else{
                alert(result.error);  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
        
    });
}
function showListView(viewList , fileid){
    $row = "" ;
    viewList.forEach(view => {
        $row += "<tr>";
        $row += "<td>  " + view.name +"     </td> ";
        $row += "<td> <button class='btn btn-danger' type='button' onclick='delView("+view.id+" , "+fileid+");'> <i class='fa fa-trash' ></i> </button> </td>";
        $row += "</tr>" ;
    
    
    });

    $("#view-list").empty().append($row);
}
function delView(viewID , fileid){
    conf  = confirm("هل انت متاكد انك تريد حذف هذا المستخدم");
    if(conf===true){
        $.ajax({
            url: api_path + "deleteviewToFile.php" ,
            type:"POST",
            data:{'fileid' : fileid , 'viewId' : viewID , 'userid' : userid} ,
            success: function(data){
                result = JSON.parse(data);
                if(result.status === true){
                  getListView(fileid);
                }else{
                    alert(result.error);  
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }

        });
    }

}

function showtypeFile(typeList){
    optionsType  = '' ;
    typeList.forEach(type => {
        optionsType +='  <option value="'+type.id+'"  >  '+type.name+'  </option>    ' ;
    });
    $("#type-edit").append(optionsType);
    $("#type").append(optionsType);


}

function getListTypeFile(){
    $.ajax({
        url: api_path + "getListTypeFile.php" ,
        type:"GET" ,
        success: function(data){
            result = JSON.parse(data);
            console.log(data);
            if(result.status === true){
               showtypeFile(result.list);
            }else{
                alert(result.error);  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
        
    });
}
function uploadFolder(courentfolder , userid){
    files = document.getElementById("upload-folder").files ;
    folderArray = files[0].webkitRelativePath.split('/',1)
    folderName = folderArray[0];
    // console.log(folderName);
    formData = new FormData();
    
    // console.log(files);
    var zip = new JSZip();
    var totalsize = 0 ;
    for (let i = 0; i < files.length; i++) {
        let file = files[i];
        totalsize += parseFloat(file.size); 
        zip.file(file.webkitRelativePath, file);
    }
    var free_memory = parseFloat($("#free-memory").val());
    console.log(free_memory);
    if(totalsize > free_memory ){
        $("#result-upload-folder").append( " لا تملك مساحة كافية  "); 
        return ; 

    }else{
        $("#result-upload-folder").empty();

        $("#result-upload-folder").append( " يتم رفع الملفات يرجى الانتظار قليلا   "); 
        zip.generateAsync({type:"blob"})
        .then(function(content) {
           console.log(content);
            formData.append("folderzip",content);
            formData.append('pathFile' , courentfolder);
            formData.append('userid' , userid);
            formData.append('foldername' , folderName);
            console.log(formData);
            fetch( api_path + "uploadFolder.php",{
            method: 'POST',
            
            body: formData
            }).then(response  => response.json() 
             ).then(data =>{
                // console.log(data);
                // alert(data.status);
                $("#result-upload-folder").append( data.status); 

            }).then(()=>{
                getFilesInDir(userid , $("#courent-folder").val());
            });
        });
    }
    
}







$(document).ready(()=>{
  
    //end profile method
    getFilesInDir(userid , null);
    getListTypeFile();
    
    $("#btn-go-to-my-file").on('click' , ()=>{
        getFilesInDir(userid , null);
    });
    $("#btn-newFolder").on('click' , ()=>{
        parentID = $("#courent-folder").val() ;
        folderName = $("#folderName").val();
        type        =$("#type").val();
        $.ajax({
            url: api_path + "newFolder.php" ,
            type:"POST",
            data:{'parent' : parentID , 'folderName' : folderName ,'type':type , 'userid' : userid} ,
            success: function(data){
                result = JSON.parse(data);
                console.log(data);
                if(result.status === true){
                  alert("تم إضافة المجلد بنجاح "); 
                  getFilesInDir(userid , parentID);
                }else{
                    alert(result.error);  
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }

        });
    });
    $("#btn-editName").on('click' , ()=>{
        courentfolder = $("#courent-folder").val() ;
        $("#result-editName").empty();
        newName = $("#newName").val();
        if(newName == ""){
            $("#result-editName").append("<em style='color:red'> لايمكن ان يكون حقل الادخال فارغ </em>");
        }else{
            $.ajax({
                url:api_path + "editFileName.php" ,
                data:{'fileeid': fileid , 'newName' : newName , 'userid' : userid},
                type:"POST" ,
                success: function(data){
                    result = JSON.parse(data);
                    console.log(data);
                    if(result.status === true){
                        getFilesInDir(userid , courentfolder);
                    }else{
                        $("#result-editName").append("<em style='color:red'>"+result.error+"</em>");  
                    }
                },
                error: (jqxhr,textStatus , errorMessage)=>{
                    alert('error' + errorMessage);
                }
            });
        }

        
    });
    $("#btn-type-edit").on('click' , ()=>{
        newtype = $("#type-edit").val();
        $.ajax({
            url:api_path + "editTypeFile.php" ,
            data:{'fileeid': fileid , 'newtype' : newtype , 'userid' : userid},
            type:"POST" ,
            success: function(data){
                result = JSON.parse(data);
                console.log(data);
                if(result.status === true){
                    $("#result-edit-type").empty().append("<em style='color:green;'> تم التعديل </em>");
                }else{
                    $("#result-edit-type").empty().append("<em style='color:red;'>"+result.error+"</em>");  
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    });
    $("#btn-add-view").on('click' , ()=>{
        viewName = $("#view-name").val();
        $.ajax({
            url:api_path + "addView.php" ,
            data:{'fileeid': fileid , 'viewName' : viewName , 'userid' : userid},
            type:"POST" ,
            success: function(data){
                result = JSON.parse(data);
                console.log(data);
                if(result.status === true){
                    $("#result-add-view").empty().append("<em style='color:green;'> تم التعديل </em>");
                    getListView(fileid);
                }else{
                    $("#result-add-view").empty().append("<em style='color:red;'>"+result.error+"</em>");  
                }
            },
            error: (jqxhr,textStatus , errorMessage)=>{
                alert('error' + errorMessage);
            }
        });
    });
    $("#btn-upload-folder").on('click' , ()=>{
        currentfolder = $("#courent-folder").val();
        uploadFolder(currentfolder , userid);
    });
    $("#btn-upload-file").on('click' , ()=>{
        currentfolder = $("#courent-folder").val();
        var listFile = $('#upload-file').prop('files');  
        $("#result-upload-file").empty();
        for(i= 0 ; i<listFile.length ; i++){

            var file_data = listFile[i];  
            var file_size = parseFloat(file_data.size) ;
            var free_memory = parseFloat($("#free-memory").val());
            console.log(free_memory);
            if(file_size > free_memory ){
                $("#result-upload-file").append( " لا تملك مساحة كافية  "); 
                return ; 

            }else{

                var file_name = file_data.name ; 
                var form_data = new FormData();   
                form_data.append('file', file_data);
                form_data.append('fileName' , file_name);
                form_data.append('filepath' , currentfolder);
                console.log(form_data);
                $("#result-upload-file").append( " يتم رفع الملفات  <br> "); 
                
                $.ajax({
                    url: api_path + "uploadFiles.php", // <-- point to server-side PHP script 
                    dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data, 
                    async: false ,                        
                    type: 'POST',
                    success: function(result){
                        $("#result-upload-file").append(result + "<br>");  
                    }
                });
                getFilesInDir(userid , currentfolder);
            } 
            

        }
       

       
     
    });
    $('#chackAll').on('click' ,  ()=> {    
        $(':checkbox.form-check').prop('checked', true);         
    });
    $('#unchackAll').on('click' ,  ()=> {    
        $(':checkbox.form-check').prop('checked', false);           
    });
    $('#btn-copy-all-file').on('click' ,  ()=> {    
        var listFileId = [] ;
        var size = 0 ; 
        $('input:checkbox.form-check').each(function () {
            if(this.checked){
                var fileid = $(this).val();
                listFileId.push(fileid);
                var c = "#size_file_" + fileid ; 
                size += formatToByte($(c).text()) ;  
            }
        });  
    
        if(listFileId.length < 1 ){
                $("#result-copy-all-file").empty().append("<em style='color:red;'>  يجب اختيار الملفات اولا  </em>");
        }else{ 
            if(parseFloat($("#free-memory").val() ) > size){
                var dest = $(".dest-folder").val();
                courentfolder = $("#courent-folder").val() ;
                $.ajax({
                    url:api_path + "copyAllFile.php" ,
                    data:{'listFile': listFileId , 'destFile' : dest , 'userid' : userid},
                    type:"POST" ,
                    success: function(data){
                        result = JSON.parse(data);
                        console.log(data);
                        if(result.status === true){
                            getFilesInDir(userid , courentfolder);
                            $("#result-copy-all-file").empty().append("<em> تم الانتهاء من النسخ  </em>");  
                            
                        }else{
                            $("#result-copy-all-file").empty().append("<em style='color:red'>"+result.error+"</em>");  
                        }
                    },
                    error: (jqxhr,textStatus , errorMessage)=>{
                        alert('error' + errorMessage);
                    }
                });
            }else{
                $("#result-copy-all-file").empty().append("<em style='color:red;'>  لا تملك مساحة تخزين كافية   </em>");

            }
            
        }
    });
    $('#btn-cut-all-file').on('click' ,  ()=> {    
        getFolders(userid , null);
        var listFileId = [] ;
        var size = 0 ; 
        $('input:checkbox.form-check').each(function () {
            if(this.checked){
                var fileid = $(this).val();
                listFileId.push(fileid);
                var c = "#size_file_" + fileid ; 
                size += formatToByte($(c).text()) ;  
            }

        });  
    
        if(listFileId.length < 1 ){
                $("#result-cut-all-file").empty().append("<em style='color:red;'>  يجب اختيار الملفات اولا  </em>");
        }else{ 
            var dest = $(".dest-folder").val();
            courentfolder = $("#courent-folder").val() ;

            $.ajax({
                url:api_path + "cutAllfile.php" ,
                data:{'listFile': listFileId , 'destFile' : dest , 'userid' : userid},

                type:"POST" ,
                success: function(data){
                    console.log(data);
                    result = JSON.parse(data);
                    console.log(result);
                    if(result.status === true){
                        
                        getFilesInDir(userid , courentfolder)
                        $("#result-cut-all-file").empty().append("<em> تم الانتهاء من نقل الملفات </em>");
                    }else{
                        $("#result-cut-all-file").append("<em style='color:red'>"+result.error+"</em>");  

                    }
                },
                error: (jqxhr,textStatus , errorMessage)=>{
                    alert('error' + errorMessage);
                }
            });
           

        }
    });

    $("#btn-delete-all").on('click' ,()=>{

        getFolders(userid , null);
        var listFileId = [] ;
        var size = 0 ; 
        $('input:checkbox.form-check').each(function () {
            if(this.checked){
                var fileid = $(this).val();
                listFileId.push(fileid);
                
            }
        });  
    
        if(listFileId.length < 1 ){
                alert(" يجب اختيار الملفات اولا  ");
        }else{ 
            courentfolder = $("#courent-folder").val();
            conf = confirm("هل انت متاكد من انك تريد حذف هذا الملف او المجلد");
            if(conf === true){
                listFileId.forEach(id => {
                    $.ajax({
                        url:api_path + "deleteFile.php" ,
                        data:{'fileid': id , 'userid' : userid },
                        type:"POST" ,
                        
                        success: function(data){
                            getFilesInDir(userid , courentfolder );
                        },
                        error: (jqxhr,textStatus , errorMessage)=>{
                            alert('error' + errorMessage);
                        }
                    });
                });
               
            }
           

        }
    });

    $("#btn-zip").on('click' , ()=>{
        var listFileId = [] ;
        var size = 0 ; 
        $('input:checkbox.form-check').each(function () {
            if(this.checked){
                var fileid = $(this).val();
                listFileId.push(fileid);
                var c = "#size_file_" + fileid ; 
                size += formatToByte($(c).text()) ;  
            }
        });  
    
        if(listFileId.length < 1 ){
                alert(" يجب اختيار الملفات اولا  ");
        }else{ 
            if(parseFloat($("#free-memory").val() ) > size){
             
                courentfolder = $("#courent-folder").val() ;
                $.ajax({
                    url:api_path + "addZIP.php" ,
                    data:{'l': listFileId , 'f' : courentfolder , 'userid' : userid},
                    type:"GET" ,
                    success: function(data){
                        result = JSON.parse(data);
                        console.log(data);
                        if(result.status === true){
                            getFilesInDir(userid , courentfolder);
                            alert(" تم الانتهاء من النسخ  ");  
                            
                        }else{
                            alert(result.error);  
                        }
                    },
                    error: (jqxhr,textStatus , errorMessage)=>{
                        alert('error' + errorMessage);
                    }
                });
            }else{
                alert("  لا تملك مساحة تخزين كافية  ");

            }
            
        }
    });
    $("#btn-unzip").on('click' , ()=>{
        var listFileId = [] ;
        var size = 0 ; 
        $('input:checkbox.form-check').each(function () {
            if(this.checked){
                var fileid = $(this).val();
                listFileId.push(fileid);
                var c = "#size_file_" + fileid ; 
                size += formatToByte($(c).text()) ;  
            }
        });  
    
        if(listFileId.length < 1 ){
                alert(" يجب اختيار الملفات اولا  ");
        }else{ 
            if(parseFloat($("#free-memory").val() ) > (size + 100 * 1024 * 1024 )){
             
                courentfolder = $("#courent-folder").val() ;
                $.ajax({
                    url:api_path + "unZIP.php" ,
                    data:{'l': listFileId , 'f' : courentfolder , 'userid' : userid},
                    type:"GET" ,
                    success: function(data){
                        result = JSON.parse(data);
                        
                        if(result.status === true){
                            getFilesInDir(userid , courentfolder);
                            alert(" تم الانتهاء من فك ضغط الملفات  ");  
                            
                        }else{
                            alert(result.error);  
                        }
                    },
                    error: (jqxhr,textStatus , errorMessage)=>{
                        alert('error' + errorMessage);
                    }
                });
            }else{
                alert("  لا تملك مساحة تخزين كافية  ");

            }
            
        }
    });

         
       
    

   
    
});