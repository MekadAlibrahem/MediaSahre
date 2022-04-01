<?php  
session_start() ;
        if(isset($_SESSION['userid']) ){
            
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
    <section class=" container setting mt-5 ">
        <div class="row">
            <div class="col-12 col-xm-12 ">
                <div class="row mb-3 account shadow-lg p-3 mb-5 bg-body rounded-3 "  id="account"  >
                    <h5>إدارة المستخدمين   </h5>
                    <hr>
                    <div class="table-responsive" >
                        <table class="table table-borderless  align-middle table-responsive-md" >
                            <tbody>
                                <tr>
                                    <td class="w-25" > عدد المستخدمين   </td>
                                    <td class="w-25" id="count-user"> </td>
                                    <td class="w-25">حجم الذاكرة المستخدم</td>
                                    <td  class="w-25" id="memory-paid" ></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive" >
                        <table class="table  table-hover ">
                            <thead>                    
                                <tr>
                                    <th>اسم المستخدم</th>
                                    <th>البريد الالكتروني </th>
                                    <th>اخر تسجيل دخول </th>
                                    <th>الذاكرة المحجوزة </th>
                                    <th>حذف الحساب </th>
                                </tr>
                            </thead>
                            <tbody id="all-user">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- إدارة الموقع  -->
    <section class=" container setting mt-5 ">
        <div class="row">
            <div class="col-12 col-xm-12 ">
                <div class="row mb-3 account shadow-lg p-3 mb-5 bg-body rounded-3 "  id="account"  >
                    <h5> إدارة الموقع   </h5>
                    <hr>
                    <div class="table-responsive" >
                        <table class="table table-borderless  align-middle table-responsive-md" >
                            <tbody>
                                <tr>
                                    <td class="w-25" > حجم الذاكرة الافتراضي  </td>
                                    <td class="w-25" >  
                                        <input type="number" name="size-memory" id="size-memory" min='1' class="form-control">
                                    </td>
                                    <td class="w-25">
                                        <button class="btn btn-primary"  id="btn-edit-size-memory" >
                                            تعديل 
                                        </button>
                                    </td>
                                    <td  class="w-25" id="result-edit-size-memory" ></td>
                                </tr>
                                <tr>
                                    <td class="w-25" > سعر 1GB من الذاكرة </td>
                                    <td class="w-25" >  
                                        <input type="number" name="price-memory" id="price-memory" min='1' class="form-control">
                                    </td>
                                    <td class="w-25">
                                        <button class="btn btn-primary"  id="btn-edit-price-memory" >
                                            تعديل 
                                        </button>
                                    </td>
                                    <td  class="w-25" id="result-edit-price-memory" ></td>
                                </tr>
                                <tr>
                                    <td class="w-25" > حجم الذاكرة الكلي  </td>
                                    <td class="w-25" >  
                                        <input type="number" name="all-memory" id="all-memory" min='1' class="form-control">
                                    </td>
                                    <td class="w-25">
                                        <button class="btn btn-primary"  id="btn-edit-all-memory" >
                                            تعديل 
                                        </button>
                                    </td>
                                    <td  class="w-25" id="result-edit-all-memory" ></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                   
                </div>
                
            </div>
        </div>
    </section>

        
    <?php 
        
          require_once "./layout/_linksjs.php" ;

      ?>
      
      <script>
             const id =  <?php echo $_SESSION["userid"] ;?> ;
             
      </script>
           <script>
        
           
      </script>
   
      <script src="../../resources/js/admin.js" >
          
      </script>
  
</body>
</html>