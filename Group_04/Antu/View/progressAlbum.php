<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */

    if(!isset($_SESSION['photos'])){
        $_SESSION['photos'] = array();
    }

    $error = "";
    $success = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK){
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = basename($_FILES['photo']['name']);
            $fileSize = $_FILES['photo']['size'];
            $fileType = mime_content_type($fileTmpPath);

            if($fileSize > 2 * 1024 * 1024){
                $error = "File size must be less than 2MB.";
            } elseif(!in_array($fileType, ['image/jpeg','image/png','image/gif'])){
                $error = "Only JPG, PNG, or GIF images are allowed.";
            } else {
                $uploadDir = "uploads/";
                if(!is_dir($uploadDir)){
                    mkdir($uploadDir, 0777, true);
                }
                $destPath = $uploadDir . time() . "_" . $fileName;
                if(move_uploaded_file($fileTmpPath, $destPath)){
                    $_SESSION['photos'][] = [
                        'path' => $destPath,
                        'timestamp' => date('Y-m-d H:i:s')
                    ];
                    $success = "Photo uploaded successfully!";
                } else {
                    $error = "Failed to save uploaded photo.";
                }
            }
        } else {
            $error = "Please select a photo to upload.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Album</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validatePhotoForm(){
            let file = document.getElementById('photo').files[0];
            let errorBox = document.getElementById('jsError');

            if(!file){
                errorBox.innerHTML = "Please select a photo.";
                errorBox.style.color = "red";
                return false;
            }

            let validTypes = ["image/jpeg","image/png","image/gif"];
            if(!validTypes.includes(file.type)){
                errorBox.innerHTML = "Only JPG, PNG, or GIF allowed.";
                errorBox.style.color = "red";
                return false;
            }

            if(file.size > 2 * 1024 * 1024){
                errorBox.innerHTML = "File size must be less than 2MB.";
                errorBox.style.color = "red";
                return false;
            }

            errorBox.innerHTML = "";
            return true;
        }
    </script>
</head>
<body id="antu">
    <h1 id="Header">Progress Album</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align:center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" enctype="multipart/form-data" action="" onsubmit="return validatePhotoForm();">
        <fieldset>
            <input type="file" id="photo" name="photo" accept="image/*">
            <div id="jsError"></div>
            <?php if(!empty($error)): ?>
                <div style="color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <input type="submit" name="submit" value="Upload Photo">
        </fieldset>
    </form>

    <h3>Uploaded Photos</h3>
    <div id="photoGallery">
        <?php if(count($_SESSION['photos']) > 0): ?>
            <?php foreach($_SESSION['photos'] as $p): ?>
                <div style="margin:10px; display:inline-block;">
                    <img src="<?php echo htmlspecialchars($p['path']); ?>" width="150" alt="progress photo">
                    <p><?php echo $p['timestamp']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align:center; margin-top: 40px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>
</body>
</html>
