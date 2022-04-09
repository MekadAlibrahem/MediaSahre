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
    <title>Home pages</title>
    <?php 
      require_once "./layout/_linkcss.php" ;
    ?>
    <style>
        .error{
            color: red;
        }
        td.w-25{
            width: 10%  !important;
        }
    </style>
</head>
<body>
    <?php 
        require_once "./layout/navbar.php" ;
    ?>
    <!--  -->
    <section class=" container setting mt-5 ">
        <div class="row">
        <!-- <aside class=" col-3 col-xm-3">
            <nav  class=" bg-light flex-column  pt-3 "> 
                <h4> الاعدادات  </h4>
                <hr>
                <ul class=" aside-nav navbar-nav p-0" >
                    <li class="nav-item p-1">
                        <a class="" href="#account">  الحساب  </a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="" href="#"> الملف الشخصي  </a>
                    </li>
                </ul>
            </nav>
        </aside> -->
        <div class="col-12 col-xm-12 ">
            <div class="row mb-3 account shadow-lg p-3 mb-5 bg-body rounded-3 "  id="account"  >
                    <h5> الحساب الشخصي </h5>
                    <hr>
                    <table class="table table-borderless">
                        <tr >
                            <td> اسم المستخدم  </td>
                            <td id="td-username">
                                 <?php
                                    echo $_SESSION['username'];
                                ?>

                            </td>
                            <td class=" table-btn  align-items-start"> 
                            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#editusername" >
                                    <i class=" fa fa-edit" ></i>
                                </button>
                            </td>
                            <td class="w-25"></td>
                        </tr>
                        <tr  >
                            <td> البريد الاكتروني   </td>
                            <td id="td-email" > 
                                <?php echo $_SESSION['email'] ?>
                                 
                                 
                            </td>
                            <td class=" table-btn  align-items-start">
                            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#editemailmodle" >
                                    <i class=" fa fa-edit" ></i>
                                </button>
                            </td>
                            <td class="w-25"></td>
                           
                        </tr>
                        <tr  >
                            <td> كلمة المرور   </td>
                            <td> 
                               *************
                            </td>
                            <td class=" table-btn  align-items-start">
                            <button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#editpasswordmodle" >
                                    <i class=" fa fa-edit" ></i>
                                </button>
                            </td>
                            <td class="w-25"></td>
                           
                        </tr>
                        <tr  >
                            <td> المساحة المستخدمة   </td>
                            <td> 
                                <div class="progress w-75"  id="bar-storag" style="height:1.5rem" >
                                    <div class="progress-bar " id="storag" role="progressbar" style="width: 0%"  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            0%
                                    </div>       
                                </div>
                            </td>
                            <td colspan="2" class="  table-btn  align-items-start">
                                <button  type="button" class=" w-100 btn btn-primary"  data-bs-toggle="modal" data-bs-target="#addspacemodel" >
                                     شراء مساحة إضافة 
                                </button>
                            </td>
                            
                           
                        </tr>
                        <tr>
                          <td>
                            <a  class="btn btn-primary form-control" href="./fileManagerPage.php"> إدارة الملفات  </a>
                          </td>
                            <td>
                                <button class="btn btn-warning form-control w-75 " id="btn-loguot" > 
                                       تسجيل الخروج
                                </button>
                            </td>
                            <td colspan="2" > 

                                <?php 
                                        if($_SESSION['type'] == 2){
                                            echo ' <button class=" w-75btn btn-danger form-control " id="btn-delete-user-account" > 
                                            حذف الحساب 
                                        </button> ' ;
                                        }else if($_SESSION['type'] ==1 ){
                                            echo ' <a  href="./adminpage.php" class="btn btn-primary form-control " > 
                                                إعدادات الموقع 
                                            </a> ' ;
                                        }
                                    
                                ?>
                            </td>
                           
                        </tr>
                       
                    </table>
                </div>
                <div class="row mb-3" >
                        
                </div>
            </div>

        </div>
    
    
    </section>



    <!--  -->
    <!-- model edit user anme  -->

<div class="modal fade" id="editusername" tabindex="-1" aria-labelledby="editusername" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editusername">تعديل اسم المستخدم </h5>
      </div>
      <div class="modal-body">
        <form id="editnameform"   id="nameform" accept-charset="utf8" >
          <div class="mb-3">
            <label for="newname" class="col-form-label"> اسم المستخدم الجديد </label>
            <input type="text" name="name" class="form-control" id="newname">
          </div>
        </form>
        <div class="error" id="result_edit_name" > 
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        <button type="button" id="btn-edit-name" class="btn btn-primary">إرسال </button>
        
                    
        </div>
      </div>
    </div>
  </div>
</div>
<!-- تعديل الايميل  -->
<div class="modal fade" id="editemailmodle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> 
                                     تعديل البريد الالكتروني  
        </h5>
      </div>
      <div class="modal-body">
        <form id="emailform" accept-charset="utf8" >
          <div class="mb-3">
            <label for="newemail" class="col-form-label"> 
                ادخل الحساب الجديد
            </label>
            <input type="text" name="email" class="form-control" id="newemail">
          </div>
        </form>
        <div class="error" id="result-edit-email" >  </div>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        <button type="button" id="btn-edit-email" class="btn btn-primary">إرسال </button>
      </div>
    </div>
  </div>
</div>
<!-- edit password  -->
<div class="modal fade" id="editpasswordmodle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> تعديل كلمة المرور   </h5>
      </div>
      <div class="modal-body">
        <form id="passowrdfrom" accept-charset="utf8" >
        <div class="mb-3">
            <label for="oldpassword"  class="col-form-label"> كلمة المرور القديمة</label>
            <input type="password" class="form-control" name="oldpassword" id="oldpassword">
          </div>
          <div class="mb-3">
            <label for="newpassword"  class="col-form-label"> كلمة المرور الجديدة </label>
            <input type="password" class="form-control" name="newpassword" id="newpassword">
          </div>
          <div class="mb-3">
            <label for="confirmpassowrd"  class="col-form-label"> تأكيد كلمة المرور  </label>
            <input type="password" class="form-control"  name="confirmpassowrd" id="confirmpassowrd">
          </div>
        </form>
        <div class="error" id="result-edit-password" ></div>
      </div>
      <div class="modal-footer">
        <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        <button type="button" id="btn-edit-password" class="btn btn-primary">إرسال </button>
      </div>
    </div>
  </div>
</div> 
<!-- model add new storage for user -->
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
    <?php 
        
          require_once "./layout/_linksjs.php" ;

      ?>
      
      <script>
             const id =  <?php echo $_SESSION["userid"] ;?> ;
      </script>
      <script src="../../resources/js/profileuser.js" > </script>
    
</body>
</html>