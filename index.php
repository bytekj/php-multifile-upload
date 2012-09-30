<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <title>My Upload Progress</title>
    <head>
        <link rel="stylesheet" href="upload.css" type="text/css" />
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

        <script type="text/javascript">
            function deleteFromServer(filename){
                delXHR = new XMLHttpRequest();
                delXHR.open("GET", "delete.php?filename="+filename, true);
                delXHR.send(null);
                var id = filename.replace(".","\\.");
                $("#"+id).remove();
            }
            function uploadToServer()
            {
                fileField = document.getElementById("uploadedFile");
                var fileToUpload = fileField.files[0]; 
                var fileTypeAllowed = new Array("video/3gpp","video/mp4","video/quicktime", "video/avi", "video/mpeg");
                
                if(fileTypeAllowed.indexOf(fileToUpload.type) == -1)
                {
                    alert("Filetype invalid");
                    return;
                }
                
                
                var xhr = new XMLHttpRequest();
                var uploadStatus = xhr.upload;
                var serverResponse = null;
                uploadStatus.addEventListener("loadstart",function(){$("#progressbar").progressbar({enable:true});} , false);
                uploadStatus.addEventListener("progress", function (ev) {
                    if (ev.lengthComputable) {
                        var progressVal = Math.round((ev.loaded / ev.total) * 100);
                        //$("#uploadPercentage").html(fileToUpload.name+" upload:"+ progressVal + "%");
           
                        $( "#progressbar" ).progressbar({value: progressVal});
                    }
                }, false);
        
                uploadStatus.addEventListener("error", function (ev) {$("#error").html(ev);}, false);
                uploadStatus.addEventListener("loadend", function (ev)
                {
                    //$("#error").html("APPOSTO!"); 
                    //$("#uploadPercentage").html(fileToUpload.name+" upload complete");
                    $("#progressbar").progressbar({value:100});
                    
                }, false);

                xhr.open("POST", "upload.php", true);
                
                xhr.setRequestHeader("Cache-Control", "no-cache");
                xhr.setRequestHeader("Content-Type", "multipart/form-data");
                xhr.setRequestHeader("X-File-Name", fileToUpload.name);
                xhr.setRequestHeader("X-File-Size", fileToUpload.size);
                xhr.setRequestHeader("X-File-Type", fileToUpload.type);
                //xhr.setRequestHeader("Content-Type", "application/octet-stream");
                xhr.onreadystatechange = function(){
                    if(xhr.readyState !=4){
                        return;
                    }
                    serverResponse = xhr.responseText;
                    $("#uploadList").append("<li id=\""+serverResponse+"\">"+
                        "<input id=\"deleteButton\" type=\"button\" onClick=\"deleteFromServer('"+serverResponse+"')\"/>"+
                        fileToUpload.name+"</li>");
                };
                
                xhr.send(fileToUpload);
            }
            
            $(function(){
                $("#uploadButton").click(uploadToServer);
            });
        </script>
    </head>
    <body>
        <div class="uploader">
            <form action="" name="uploadForm" method="post"
                  enctype="multipart/form-data">

                <input id="uploadedFile" name="fileField" type="file" multiple /> <input
                    id="uploadButton" type="button" value="Upload!">
            </form>
            <div id="progressbar"></div>
            <div id="error"></div>

            <ul id="uploadList"></ul>

        </div>
    </body>
</html>