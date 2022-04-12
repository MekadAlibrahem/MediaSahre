<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <?php 
        
          require_once "./layout/_linkcss.php" ;

      ?>
      
     

</head>
<body>
    <nav class=" main-nav  navbar navbar-expand-lg navbar-light  m-0 p-0 sticky-top">
      <div class="container">
        <a class="navbar-brand " href="#"> 
          <img src="../../resources/images/logo3.png" width="50" height="40" alt="">
          dataCloude
        </a>
          <ul class="navbar-nav float-start">
            <li class="nav-item">
            <a class="btn btn-primary"  role="button"   href="./login.php" >
              تسجيل الدخول 
            </a>
            </li>
            
          </ul>
      </div>
    </nav>

      <header class=" p-sm-0  ">
        <div class="container " >
          <div class="row  align-items-center  ">
            <div class="col-12" >
              <h4> يمكنك تخزين و مشاركة الملفات بسهولة  </h4>
            </div>
               
              <div class="col-12 d-flex flex-column">
              <a class="btn btn-primary link-login mb-2"  role="button"   href="./login.php" >
                تسجيل الدخول 
              </a>
              <a class="btn btn-primary"  role="button"   href="./signup.php" >
                إنشاء حساب 
              </a>  
              </div>
            </div>
          
        </div>
      </header>
      <section>
        <div class="special-heading" > 
          <p> الخدمات </p>   
        </div>
         <div class="container">
          
          <div class="row text-primary text-center fs-5">
            <p> أصبح تخزين الملفات أمرًا سهلاً - بما في ذلك الميزات القوية التي لن تجدها في أي مكان آخر.  سواء كنت تشارك الصور أو مقاطع الفيديو أو الصوت أو المستندات ، يمكن لـ dataCloude تبسيط سير عملك </p>
          </div>
          <div class="row mt-2">
            <div class="col-12 col-sm-12 col-md-4 ">
              <div class="card text-center servise-card"   id="servise-card-collaborate">
                <div class="card-img" >
                  <img src="../../resources/images/collaborate.svg"  class="img-fluid rounded-circle" id="img-collaborate" alt="">

                </div>
                <div class="card-body" >
                  <h5 class="card-title" >
                    مشاركة
                  </h5>
                  <p class="card-text" >
                    تخزين ومشاركة أي نوع من الملفات.  مشاركة مجلدات ملفات المشروع.  إرسال الملفات الكبيرة بسهولة

                  </p>

                </div>
              
              </div>
              
            </div>
            <div class="col-12 col-sm-12 col-md-4">
              <div class="card text-center servise-card"  id="servise-card-store">
                <div class="card-img" >
                  <img src="../../resources/images/store.svg"  class="img-fluid rounded-circle"  id="img-store" alt="">
                </div>
                <div class="card-body" >
                  <h5 class="card-title" >
                    تخزين
                  </h5>
                  <p class="card-text" >
                    10 جيجا مجانا.   قم بتخزين جميع الصور والصوت ومقاطع الفيديو الخاصة بك.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4">
              <div class="card text-center servise-card"  id="servise-card-access" >
                <div class="card-img" >
                  <img src="../../resources/images/access.svg"  class="img-fluid rounded-circle" id="img-access" alt="">
                </div>
                <div class="card-body" >
                  <h5 class="card-title" >
                   الوصول
                  </h5>
                  <p class="card-text" >
                    احتفظ دائمًا بملفاتك المهمة معك.  لا تنسى ابدا عملك في المنزل.  العرض والإدارة والمشاركة من أي مكان.
                  </p>
                </div>
              </div>
            </div>

          </div>

         </div>
      </section>

      <footer class="container-fluid text-white" >
        <div class="container text-center" >
          <div class="row" >
            <p>
              ©2022 dataCloude 
            </p>
          </div>
          <div class="row">
            <h6> الفريق </h6>
            <div>
              <ul class="nav justify-content-center">
                <li class="nav-item">
                  <a class="nav-link  " aria-current="page" href="https://mekadalibrahem.github.io/Portfolio/"> Mekad Alibrahem </a>
                </li>
               
              </ul>
            </div>
          </div>
        </div>
      </footer>

      <?php 
        
        require_once "./layout/_linksjs.php" ;

    ?>
    
      <script>
        $(document).ready(function(){
   
        
          RESOURCES_Path = "http://localhost/mediashare/resources/";
          // change images in  servise  section 
              $("#servise-card-collaborate").hover(
                  () =>{
                      $("#img-collaborate").attr("src"  , RESOURCES_Path + "images/collaborate_color.svg" );
                  } ,
                  () =>{
                      $("#img-collaborate").attr("src" ,RESOURCES_Path + "images/collaborate.svg") ;

                  }
              );
              $("#servise-card-store").hover(
                  ()=>{
                      $("#img-store").attr("src"  , RESOURCES_Path + "images/store_color.svg" );
                  } ,
                  () => {
                      $("#img-store").attr("src", RESOURCES_Path + "images/store.svg");

                  }
              );
              $("#servise-card-access").hover(
                  function(){
                      $("#img-access").attr("src"  ,RESOURCES_Path +  "images/access_color.svg" );
                  } ,
                  function(){
                      $("#img-access").attr("src" ,RESOURCES_Path + "images/access.svg") ;

                  }
              );
            });    
          //
    
      </script>
   
</body>
</html>