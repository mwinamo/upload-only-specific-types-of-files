<?php
if(isset($_POST['submitUpload']) && isset($_FILES['targetFile'])){

    $error_int = $_FILES['targetFile']['error'];

    $fileSize = $_FILES['targetFile']['size'];

    $upload_dir = './uploads/';

    $targetFile = $upload_dir.$_FILES['targetFile']['name'];

    //GET THE PATH INFORMATION
    $path_info = pathinfo($_FILES["targetFile"]["name"]);

    $tmpName = $_FILES["targetFile"]["tmp_name"];

    // THE ARRAY OF FILE TYPES WHICH YOU WANT OT ALLOW TO UPLOAD
    $fileType = ['png','jpg','jpeg','gif'];

    if($error_int === 1){
        echo "File is too large | The uploaded file exceeds the upload_max_filesize.";
    }
    // IF EMPTY FILE
    elseif($error_int === 4){
        header('Location: index.php');
        exit;
    }
    elseif($fileSize > 1048576){
        echo "The file size is over 1MB, that's why this file is not allowed to upload.";
    }
    // IF THE FILE EXTENSION IS NOT IN ARRAY
    elseif(!in_array($path_info['extension'],$fileType)){
        echo "Please choose an Image file.";
    }
    else{

        $number = 1;
        while(file_exists($targetFile)){
            $targetFile = $upload_dir.$path_info['filename'].'-'.$number.'.'.$path_info['extension'];
            $number++;
        }

        $is_uploaded = move_uploaded_file($tmpName, $targetFile);

        if($is_uploaded){
            echo "The file uploaded successfully";
        }
        else{
            echo "The file not uploaded.";
        }

    }

    exit;
}
?>
<!DOCTYPE html>
<html>
<body>

<form action="./index.php" method="POST" enctype="multipart/form-data">
    <label for="myFile"><b>Select file to upload:</b></label><br>
    <input type="file" name="targetFile" id="myFile">
    <input type="submit" name="submitUpload" value="Upload">
</form>

</body>
</html>