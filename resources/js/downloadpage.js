const userid= id; 
const api_path = "http://localhost/mediashare/php/api/"  ;
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
                // "<td> <input type='checkbox' class='form-check'  name='"+ item.name +"'  value='"+ item.id +"' > </td>" +
                "<td class=''><button   ondblclick='getFilesInDir("+null+" ,"+item.id+");'> <i class= '"+icon+"'>  </i> "+item.name+"</button> </td>" +
                "<td> "+item.type+" </td>"+
                "<td id='size_file_"+item.id+"' > "+item.size+"  </td>"+
                "<td> "+
                    "<div class='btn-group text-end' role='group' aria-label='Basic mixed styles example'>"+
                    "<button class='btn btn-primary' type='button' onclick='copylink(\""+item.link+"\");'> <i class='fa fa-link'> </i></button>" +
                    "<button class='btn btn-primary'data-bs-toggle='modal' data-bs-target='#' type='button' onclick='download("+item.id+");'> <i class='fa fa-download'> </i></button>" +

                    "</div>"+
                "  </td>"+

               
        
            +"</tr>  " ;
                        
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
function showFileInfo(listinfo){
    listinfo.forEach(list => {
        card_content = '<h5 class="card-title" > <i class="fa fa-file"> </i>'+ list.name + '</h5> ' ;
        card_content +=  '<p class="card-text " > ' +list.size+ '  </p> ';
        card_content += '  <button  class="btn btn-primary" onclick="download('+list.id+');" > ' ;
        card_content +=  " تنزيل  "  ;
        card_content += ' </button>  '  ;
    
    });
   
    $("#file-card").empty().append(card_content);
}
function getFileinfo(fileid){
    $.ajax({
        url: api_path + "getFileInfor.php" ,
        data:{'fileid' : fileid},
        type:"POST" ,
        success: function(data){
            result = JSON.parse(data);
            
            if(result.status === true){
               showFileInfo(result.list)
              
            }else{
                alert(result.error);  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
        
    });
}


function showlogIn(){
    $("#show-log-in").removeClass("d-none");
}
$(document).ready(()=>{
    if(userid == null){
        showlogIn();
    }
  
});