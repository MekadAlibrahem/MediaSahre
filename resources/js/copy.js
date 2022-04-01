function getFolders(userid , rootFolder){
    $.ajax({
        url: api_path + "getFilesInDir.php" ,
        data:{'userid' : userid , 'foldeid' : rootFolder},
        type:"POST" ,
        success: function(data){
            result = JSON.parse(data);
            
            if(result.status === true){
                showfolder(result.list);
                showCurrentFolder(result.path);
            }else{
                alert(result.error);  
            }
        },
        error: (jqxhr,textStatus , errorMessage)=>{
            alert('error' + errorMessage);
        }
        
    });
}
function showfolder(list){
    $(".list-folder").empty();
    icon ="fa fa-folder" ;
    row = '<div><ul class="list-group list-group-flush">' ;
    list.forEach(item => {
        if(item.isFile !== 1 ){
            row += '<li class="list-group-item"> '; 
            row += '<button ondblclick="getFolders('+userid+' , '+item.id+');" > <i class="fa fa-folder"></i>  '+item.name+ ' </button> </li>' ;
        }

    });
    row += "</ul> </div>";
       
    $(".list-folder").append(row);

}
function showCurrentFolder(listPath){
    $(".path-folder").empty();
    path = ' <li class="breadcrumb-item"></li>';
    input = '';
    if(listPath.count > 0){
        listPath[0].forEach(folder => {
            if(folder.end == 1){
                $(".dest-folder").val(folder.id);
                $(document).html(input);
                path += '<li class="breadcrumb-item active" aria-current="page" > <button  type="button" data-target="'+folder.id+'" onclick="getFolders('+userid+','+folder.id+');"> '+folder.name+' </button></li>';
            }else{
                path += '<li class="breadcrumb-item"><button type="button" onclick="getFolders('+userid+','+folder.id+');"> '+folder.name+' </button></li>';

            }
        });

    }
    
    $(".path-folder").append(path);
   
}

function copy(id){
    fileid = id ; 
    getFolders(userid , null); 
}
function cut(id){
    fileid = id ; 
    getFolders(userid , null);
}

function copyAll(){
     
    getFolders(userid , null); 
    $("#result-cut-all-file").empty();

}
function cutAll(){
    getFolders(userid , null); 
    $("#result-cut-all-file").empty();

}

function getUnit(size) {
   var matches = size.match(/[a-zA-Z]+/g);
  
  var letter = matches[0].toUpperCase();
  return letter;
}



function formatToByte(expre){
    var unit = getUnit(expre) ;
    
    var size = parseFloat(expre);
   
    switch (unit) {
        case"B":
            break;
        case "KB":
            size = size * 1024 ;
            break;
        case "MB":
            size = size * 1024 * 1024 ;
            break;
        case "GB":
            size = size * 1024 * 1024 * 1024 ;
            break;
        case "TB":
            size = size * 1024 * 1024 * 1024 * 1024 ;
        default:
            break;
    }
    
    return size ;

}