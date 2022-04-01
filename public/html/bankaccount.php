<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Account </title>
    <?php 
      require_once "./layout/_linkcss.php" ;
    ?>
    <style>
        .error{
            color: red;
        }
       
    </style>
</head>
<body dir ="rtl">
    
    <section class=" container mt-5 ">
        <!-- إضافة حساب مصرفي جديد -->
        <div class="row mb-3 shadow-lg p-3 mb-5 bg-body rounded-3">
            <h4> إضافة حساب مصرفي جديد</h4>
            <form id="add-account-form" accept-charset="utf8" >
                <div class="mb-3">
                    <label for="add-account"  class="col-form-label"> الحساب المصرفي </label>
                    <input type="text" class="form-control" name="add-account" id="add-account">
                </div>
                <div class="mb-3">
                    <label for="add-password"  class="col-form-label"> كلمة مرور الحساب </label>
                    <input type="password" class="form-control" name="add-password" id="add-password">
                </div>
                <div class="mb-3">
                    <label for="add-count"  class="col-form-label">  الرصيد </label>
                    <input type="number" min=1" step="1" class="form-control"  name="add-count" id="add-count">
                </div>
                <div class="modal-footer flex-row-reverse">
                    <button type="button"  class=" w-25  btn btn-secondary" >إغلاق</button>
                    <button type="button" id="add-new-account" class=" w-25 btn btn-primary">إرسال </button>
                </div>
            
            </form>
            <div class="error" id="result-add-new-account" ></div>
        </div>
        <!--حذف حساب مصرفي  -->
        <div class="row mb-3 shadow-lg p-3 mb-5 bg-body rounded-3">
            <h4> حذف حساب مصرفي </h4>
            <form id="del-account-form" accept-charset="utf8" >
                <div class="mb-3">
                    <label for="del-account"  class="col-form-label"> الحساب المصرفي </label>
                    <input type="text" class="form-control" name="del-account" id="del-account">
                </div>
                <div class="mb-3">
                    <label for="del-password"  class="col-form-label"> كلمة مرور الحساب </label>
                    <input type="password" class="form-control" name="del-password" id="del-password">
                </div>

                <div class="modal-footer flex-row-reverse">
                    <button type="button"  class=" w-25  btn btn-secondary" >إغلاق</button>
                    <button type="button" id="btn-del-account" class=" w-25 btn btn-primary">إرسال </button>
                </div>
            </form>
            <div class="error" id="result-del-account" ></div>
        </div>
        <!-- تعديل رصيد حساب مصرفي   -->
        <div class="row mb-3 shadow-lg p-3 mb-5 bg-body rounded-3">
            <h4> تعديل رصيد حساب مصرفي </h4>
            <form id="edit-account-form" accept-charset="utf8" >
                <div class="mb-3">
                    <label for="edit-account"  class="col-form-label"> الحساب المصرفي </label>
                    <input type="text" class="form-control" name="edit-account" id="edit-account">
                </div>
                <div class="mb-3">
                    <label for="edit-password"  class="col-form-label"> كلمة مرور الحساب </label>
                    <input type="password" class="form-control" name="edit-password" id="edit-password">
                </div>
                <div class="mb-3">
                    <label for="edit-count"  class="col-form-label">  الرصيد </label>
                    <input type="number" min=1" step="1" class="form-control"  name="edit-count" id="edit-count">
                </div>
                <div class="modal-footer flex-row-reverse">
                    <button type="button"  class=" w-25  btn btn-secondary" >إغلاق</button>
                    <button type="button" id="edit-count-account" class=" w-25 btn btn-primary">إرسال </button>
                </div>
            
            </form>
            <div class="error" id="result-edit-count" ></div>
        </div>
        <!-- show all Bank Account   -->
        <div class="row mb-3 shadow-lg p-3 mb-5 bg-body rounded-3">
            <h4> عرض جميع السحابات المصرفية</h4>
            <table class="table table-borderless">
                <thead> 
                    <tr> 
                        <th> اسم الحساب </th>
                        <th> كلمة المرور  </th>
                        <th> الرصيد </th>
                    </tr>
                    <tbody id="Accounts" >

                    </tbody>
                </thead>
            </table>
            <div class="error" id="account-error" ></div>
        </div>
    </section>
    
    <?php 
        
        require_once "./layout/_linksjs.php" ;

    ?>
    <script src="../../resources/js/bankaccount.js"></script>
</body>
</html>