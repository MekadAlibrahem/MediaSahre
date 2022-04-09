<?php  
session_start() ;
    if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'] ;   
    }else{
        $userid = null ;
    }
?>
<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>download</title>
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
            
        </style>

        <?php 
            require_once "./layout/_linkcss.php" ;
        ?>
               <script>
            <?php 
            if(isset($_SESSION['userid'])){
                ?>
                const id =  <?php echo $userid ;  ?> ;
                <?php 
            }else{
              ?>
              
              const id = null ;
              <?php 
            }
           
            ?>
             
        </script>
          <?php 
            
            require_once "./layout/_linksjs.php" ;

        ?>
        <script src="../../resources/js/downloadpage.js">  </script>

    
    </head>
    <body>
        <?php 
            require_once "./layout/navbar.php" ;
        ?>

   
            <?php 
               if(isset($_GET['id'] )){
                if(isset($_GET['file'])  && $_GET['file'] == 1 ){
                        ?> 
                        <section class=" container  mt-5 ">
                            <div class="row" >
                            <div class=" col-0 col-lg-2" ></div>
                          
                            <div class="col-12  col-lg-8  file" >
                                
                                <div class="card text-center w-100 " >
                                
                                <div class="card-body" id="file-card">
                                    
                                </div>
                                
                            </div>
                            <div class=" col-0 col-lg-2" ></div>
                            <script >  
                                $(document).ready(()=>{
                                    getFileinfo( <?php echo $_GET['id']    ?>);

                                });
                            </script>
                             
                            </div>
                            
                           

                            </div>
                        </section>
                        <?php
                }else{

                    ?> 
                     <section class=" container  mt-5 ">
                        <div class="row" >
                        
                            <div class=" shadow-lg  mt-4 rounded-3"  >
                        <!-- <div class="text-primary pe-4" >
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  " id="current-path" >
                               
                            </ol>
                        </nav>
                   </div> -->
                    <div class="table-responsive h-100 w-100 " >
                        <table class="table table-files table-border table-responsive table-hover  table-light overflow-auto  w-100"> 
                            <thead>
                                <tr class="">
                                  
                                    <th class="w-50">الاسم </th>
                                    <th> النوع </th>
                                    <th> الحجم </th>
                                    <th> العمليات   </th>
                                </tr>
                            </thead>
                            <form id="form-list-file" name="form-list-file">
                                <tbody id="list-files" >
                                    <script >  
                                        $(document).ready(()=>{
                                            getFilesInDir(null , <?php echo $_GET['id']    ?>);

                                        });
                                    </script>
                                </tbody>
                            </form>
                        </table>
                       
                    </div>
                         
        </div>
    </section>



                    <?php
                }
                }else{

                }

            ?>

            
                   
           
   
       

 
        
    </body>
</html>
