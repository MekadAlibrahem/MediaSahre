<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" id="form-files" method="post">
        <input type="file" id="files" webkitdirectory directory multiple onchange="" />
        <button id="btn" type="button"  > send </button>
        <div id="output"></div>
    </form>

    <script src="../resources/js/jquery3.6.js"></script>
    <script src="./JSZip.js"></script>
    <script>
        function show(){
            files = document.getElementById("files").files ;
            // folderName = files[0].split('/' , 1);
            folderArray = files[0].webkitRelativePath.split('/',1)
            folderName = folderArray[0];
            console.log(folderName);

            formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                let fileParamName = `file${i}`;
                console.log(fileParamName);
                let filePathParamName = `filepath${i}`;
                console.log(filePathParamName);
                formData.append(fileParamName, file);
                formData.append(filePathParamName,file.webkitRelativePath);
            }
            console.log(files);
            var zip = new JSZip();
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
               
                zip.file(file.webkitRelativePath, file);
                console.log(file.webkitRelativePath);
            }
            zip.generateAsync({type:"blob"})
                .then(function(content) {
                   console.log(content);
                    formData.append("folderzip",content);
                    formData.append('userid' , 5) ;
                    formData.append('pathFile' , 5);
                    formData.append('foldername' , folderName);
                    console.log(formData);
                    fetch("http://localhost/mediashare/test2/apizipupload.php",{
                    method: 'POST',
                    
                    body: formData
                    }).then(response => {
                    console.log(response);
                    }); 
                });
        }
        $(document).ready(()=>{
            $("#btn").on('click' , ()=>{
                show();
            });
        });
        
            // formData.append("folderzip",content);
            // console.log(zip);
            
//         var output = document.querySelector("#output");
// document.querySelector("input").onchange = function() {
//   var files = this.files;
//   for (file of files) {
//     output.insertAdjacentHTML('beforeend', `<div>${file.webkitRelativePath}</div>`);
//   }
// }
        
    </script>
</body>
</html>