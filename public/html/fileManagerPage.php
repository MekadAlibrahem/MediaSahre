<?php  
session_start() ;
        if(isset($_SESSION['userid'])){
            
        }else{
            header("location: http://localhost/mediashare/public/html/login.php");
        }

    

?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>

    <?php 
      require_once "./layout/_linkcss.php" ;
    ?>
    <style>
        button, input[type="submit"], input[type="reset"] {
            background: none;
            color: inherit;
            border: none;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }
        .page-content{
            min-height: calc(100vh - 50px);
            background: #181c25 !important;
            flex-wrap: nowrap;

        }
        .sidbar-setting {
            min-height: calc(100vh - 50px);
            background-color: #282f3d;
            color: white;
        }
        .files-content{
            min-height: calc(100vh - 50px);
            background: #181c25;
        }
        .table-files{
            background: #181c25 !important;
        }
        .link-setting{
            font-size: 20px;
            cursor:pointer ;
        }
        .link-setting:hover{
            color: blue;
        }
        .file-item:hover{
            color: blue;
        }
        .table-files tbody{
            min-height: 90vh;
        }
        

    
    
    </style>
</head>
    <?php 
        require_once "./layout/navbar.php" ;
    ?>


    <div class="container-fluid m-0 p-0" >
        <div class="row page-content m-0   p-0  overflow-auto" > 
               <div class="sidbar-setting  overflow-auto w-auto col-sm-3 col-md-3   h-100 m-0   d-md-block collapse  " id="sidebar-setting">
                    <div class="d-flex flex-column justify-content-around  align-content-center p-4 pb-0" >
                        <p> <?php echo $_SESSION['username'] ; ?> </p>
                        <p> <?php echo$_SESSION['email'] ;     ?> </p>
                    </div>
                    <hr>
                    <div class="list-setting d-flex flex-column justify-content-around align-content-center" >
                        <div  > 
                            <button id="btn-go-to-my-file" >
                            <p class="link-setting"> <i class="fa fa-folder fa-9"> ملفاتي  </i>   </p>  
                            </button>
                        </div>
                        <div  > 
                                <button  data-bs-toggle="modal" data-bs-target="#modelUpload">
                                    <p class="link-setting" > <i class="fa fa-upload fa-9">  تحميل   </i>   </p>  

                                </button>
                        </div>
                        <div  > 
                                <button  data-bs-toggle="modal" data-bs-target="#modelNewFile">
                                    <p class="link-setting" > <i class="fa fa-folder-plus fa-9"> مجلد جديد  </i>   </p>  

                                </button>
                        </div>
                        
                        <hr>
                        <div  > 
                            <button  >
                                <a href="./user_homePage.php" style="color:#fff"  >
                                    <p class="link-setting"> <i class="fa fa-gear fa-9">  الاعدادات   </i>   </p>  
                                </a>
                            </button>

                        </div>
                        <div  > 

                            <button data-bs-toggle="modal" data-bs-target="#addspacemodel">
                            <p class="link-setting"> <i class="fa fa-plus-square fa-9">  شراء مساحة   </i>   </p>  

                            </button><br>
                            <em id="memory-write" ></em>
                            <div class="progress w-100"  id="bar-storag" style="height:0.5rem" >
                                <div class="progress-bar " id="storag" role="progressbar" style="width: 0%"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        0%
                                </div>       
                                
                            </div>
                        </div>
                        <div  > 
                            <button  id="btn-loguot" >
                            <p class="link-setting"> <i class="fa fa-sign-out fa-9">  تسجيل الخروج   </i>   </p>  

                            </button>
                        </div>
                    </div>
               </div>
               <div class="col-sm-12    col-md-9 col-lg-9 files-content  w-lg-100 m-0 p-0  me-sm-3 me-lg-5 mt-3  ">
                   <div class="text-primary pe-4" >
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  " id="current-path" >
                               
                            </ol>
                        </nav>
                   </div>
                    <div class="table-responsive h-100 w-100 " >
                        <table class="table table-files table-border table-responsive table-hover table-dark overflow-auto text-white w-100"> 
                            <thead>
                                <tr class="">
                                    <th > 
                                    <div class="dropstart">
                                    <button class="btn btn-secondary " type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                       <i class="fa fa-ellipsis-vertical" ></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" id="chackAll" href="#">تحديد الكل </a></li>
                                        <li><a class="dropdown-item" id="unchackAll" href="#"> الغاء تحديد الكل  </a></li>
                                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modelCopyall" onclick="copyAll();" href="#" >نسخ</a></li>
                                        <li><a class="dropdown-item"  data-bs-toggle="modal" data-bs-target="#modelCutall"  href="#" onclick="cutAll();" >نقل</a></li>
                                        <li><a class="dropdown-item" id="btn-delete-all" href="#">حذف</a></li>
                                        <li><a class="dropdown-item" id="btn-zip" href="#">ضغط</a></li>
                                        <li><a class="dropdown-item" id="btn-unzip" href="#">فك ضغط</a></li>

                                    </ul>
                                    </div>
                                    </th>
                                    <th class="w-50">الاسم </th>
                                    <th> النوع </th>
                                    <th> الحجم </th>
                                    <th> العمليات   </th>
                                </tr>
                            </thead>
                            <form id="form-list-file" name="form-list-file">
                                <tbody id="list-files" >
                                    
                                </tbody>
                            </form>
                        </table>
                       
                    </div>
               </div>
        </div>
    </div>
    



    <!-- model new folder --> 
    <div class="modal fade" id="modelNewFile" tabindex="-1" aria-labelledby="modelNewFile" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelNewFile">إضافة مجلد جديد </h5>
            </div>
            <div class="modal-body">
                <form id="from-newFolder"   id="nameform" accept-charset="utf8" >
                <div class="mb-3">
                    <label for="folderName" class="col-form-label"> اسم المجلد </label>
                    <input type="text" name="folderName" class="form-control" id="folderName" require>
                </div>
                <div class="mb-3">
                    <label for="type" class="col-form-label"> نوع المجلد </label>
                <select name="type" id="type">
                    
                </select>
                </div>
                </form>
                <div class="error" id="result-newFolder" > 
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" id="btn-newFolder" class="btn btn-primary">إرسال </button>
                
                            
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- end model new folder -->
     <!-- model edit type file --> 
     <div class="modal fade" id="modelEditType" tabindex="-1" aria-labelledby="modelEditType" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelEditType">تعديل نوع مجلد  </h5>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 70vh;">
                    <form id="from-edit-type"  accept-charset="utf8" >
                        
                        <div class="mb-3">
                            <label for="type-edit" class="col-form-label"> نوع المجلد </label>
                            <select name="type-edit" id="type-edit">
                            
                            </select>
                        <button type="button" id="btn-type-edit" class="btn btn-primary">إرسال </button>     

                        </div>

                    </form>
                    <div class="" id="result-edit-type" ></div>
                    <hr>
                    <h6>  من يستطيع الوصول الى الملف إذا كان محمي </h6>
                    <form id="from-add-view"    accept-charset="utf8" >
                        <label for="view-name" class="col-form-lable"  > اسم المستخدم  </label>
                        <input type="text" name="view-name" id="view-name" required>
                        <button type="button" id="btn-add-view" class="btn btn-primary">إرسال </button>     

                    </form>
                    <div class="" id="result-add-view"  ></div>
                        <table class="table  table-sm  h-25" style="max-height: 30px;" >
                            <thead> 
                                <th>  اسم المستخدم  </th>
                                <th>  حذف     </th>
                            </thead>
                            <tbody id="view-list" >
                                  
                            </tbody>
                        </table>
                    
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end model edit type file -->
    <!-- model upload file or folder -->
    <div class="modal fade" id="modelUpload" tabindex="-1" aria-labelledby="modelUpload" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelUpload"> رفع مجلد  </h5>
                </div>
                <div class="modal-body overflow-auto" style="max-height: 70vh;">
                    <form id="from-upload-folder"  enctype='multipart/form-data'  accept-charset="UTF-8" >
                        
                        <div class="mb-3">
                            <label for="upload-folder" class="col-form-label">اختر مجلد </label>
                            <input type="file" id="upload-folder" webkitdirectory directory multiple >
                            <button type="button" id="btn-upload-folder" class="btn btn-primary">إرسال </button>     

                        </div>

                    </form>
                    <div class="" id="result-upload-folder" ></div>
                    <hr>
                    <h5>  رفع ملف </h5>
                    <form id="from-upload-file"  enctype='multipart/form-data'  accept-charset="UTF-8" >
                        
                        <div class="mb-3">
                            <label for="upload-file" class="col-form-label"> اختر ملف </label>
                            <input type="file" id="upload-file"   multiple >
                        <button type="button" id="btn-upload-file" class="btn btn-primary">إرسال </button>     

                        </div>

                    </form>
                    <div class="" id="result-upload-file"  ></div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end model upload file or folder -->
    <!-- model edit name --> 
    <div class="modal fade" id="modelEditFileName" tabindex="-1" aria-labelledby="modelEditFileName" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelEditFileName">إضافة مجلد جديد </h5>
                </div>
                <div class="modal-body">
                    <form id="from-editFileName"   id="nameform" accept-charset="utf8" >
                        <div class="mb-3">
                            <label for="newName" class="col-form-label"> اسم المجلد </label>
                            <input type="text" name="newName" class="form-control" id="newName" require>
                        
                        </div>
                    </form>
                    <div class="error" id="result-editName" > </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" id="btn-editName" class="btn btn-primary">إرسال </button>             
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end model edit name -->
        <!--  مودل إضافة مساحة ذاكرة جديدة  -->
        
            <div class="modal fade" id="addspacemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">شراء مساحة تخزين إضافية</h5>
                    </div>
                    <div class="modal-body">
                        <form id="add-space-form" accept-charset="utf8" >
                        <div class="mb-3">
                            <label for="add-account"  class="col-form-label"> الحساب المصرفي </label>
                            <input type="text" class="form-control" name="add-account" id="add-account">
                        </div>
                        <div class="mb-3">
                            <label for="add-password"  class="col-form-label">كلمة مرور الحساب </label>
                            <input type="password" class="form-control" name="add-password" id="add-password">
                        </div>
                        <div class="mb-3">
                            <label for="count"  class="col-form-label">  المساحة المطلوبة ب GB </label>
                            <input type="number" min="1"  value="0" step="1" class="form-control"  name="add-count" id="add-count">
                            <div id="totalprice"  class="pt-3" style="color:green" ></div>
                        </div>
                        </form>
                        <div class="error" id="result-add-space" ></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" id="btn-add-space" class="btn btn-primary">إرسال </button>
                    </div>
                    </div>
                </div>
            </div>
        <!-- نهاية مودل إضافة مساحة ذاكرة جديدة  -->
  
     <!-- model copy all --> 
     <div class="modal fade" id="modelCopyall" tabindex="-1" aria-labelledby="modelCopyall" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelCopyall">نسخ مجلد  </h5>
            </div>
            <div class="modal-body">
                <div id="" >
                    <nav aria-label="breadcrumb">
                            <ol class="breadcrumb path-folder" >
                               
                            </ol>
                    </nav>
                </div>
                <div class="mb-3">
                    <!-- <label for="folderName" class="col-form-label"> اختر مجلد </label> -->
                    <div class="list-folder"> 
                        
                    </div>
                </div>
                <div class="mb-3">
                 <input type="hidden" name="" class="dest-folder" value="null">
                </div>
                
                <div class="error" id="result-copy-all-file" > 
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" id="btn-copy-all-file" class="btn btn-primary">إرسال </button>
                
                            
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- end model copy all -->
   
    
    <!-- model cut  all--> 
    <div class="modal fade" id="modelCutall" tabindex="-1" aria-labelledby="modelCutall" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelCutall">نقل مجلد  </h5>
            </div>
            <div class="modal-body">
                <div id="" >
                    <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  path-folder " id="path-folder" >
                               
                            </ol>
                    </nav>
                </div>
                <div class="mb-3">
                    <!-- <label for="folderName" class="col-form-label"> اختر مجلد </label> -->
                    <div class="list-folder"> 
                        
                    </div>
                </div>
                <div class="mb-3">
                 <input type="hidden" name="" class="dest-folder" value="null">
                </div>
                
                <div class="error" id="result-cut-all-file" > 
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" id="btn-cut-all-file" class="btn btn-primary">إرسال </button>
                
                            
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- end model cut all -->
        <?php 
            
            require_once "./layout/_linksjs.php" ;

        ?>
       <input type="hidden" id="courent-folder" value="null" />
       <input type="hidden" id="free-memory" value="0" />
        
        <script>
            const id =  <?php echo $_SESSION["userid"] ;?> ;
        </script>
        <script src="../../resources/js/managerFile.js">  </script>
        
        </body>
</html>
