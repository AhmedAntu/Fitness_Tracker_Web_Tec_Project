<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */
    
    $uploadDir = __DIR__ . '/Uploads/Progress_Album/';
    if(!file_exists($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    if(!isset($_SESSION['photos'])){
        $_SESSION['photos'] = array();
    }

    $error = "";
    $success = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
            $uploadedFile = $_FILES['photo'];
            $fileName = $uploadedFile['name'];
            $fileTmpName = $uploadedFile['tmp_name'];
            $fileSize = $uploadedFile['size'];
            $fileType = $uploadedFile['type'];

            $allowedTypes = array('image/jpeg', 'image/png', 'image/gif', 'image/jpg');
            $maxSize = 5 * 1024 * 1024;
            
            if(!in_array($fileType, $allowedTypes)){
                $error = "Selected file is not an image. Please select a valid image file (JPEG, PNG, GIF, JPG).";
            } elseif($fileSize > $maxSize) {
                $error = "File size too large. Please select a file smaller than 5MB.";
            } else {
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $newFileName;
                $relativePath = 'Uploads/Progress_Album/' . $newFileName;

                if(move_uploaded_file($fileTmpName, $uploadPath)){
                    $_SESSION['photos'][] = array(
                        'filename' => $newFileName,
                        'path' => $relativePath,
                        'original_name' => $fileName,
                        'date' => date('Y-m-d H:i:s')
                    );
                    $success = "Photo uploaded successfully!";
                } else {
                    $error = "Failed to upload photo. Please check directory permissions.";
                }
            }
        } else {
            if(isset($_FILES['photo']['error']) && $_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE) {
                switch($_FILES['photo']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        $error = "File is too large.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error = "File upload was interrupted.";
                        break;
                    default:
                        $error = "File upload failed.";
                }
            } else {
                $error = "Please select a photo before adding.";
            }
        }
    }

    if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
        $index = intval($_GET['delete']);
        if(isset($_SESSION['photos'][$index])){
            $fullPath = $uploadDir . $_SESSION['photos'][$index]['filename'];
            if(file_exists($fullPath)){
                unlink($fullPath);
            }
            array_splice($_SESSION['photos'], $index, 1);
            header('location: progressAlbum.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Photo Album</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #photoGallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .photo-item {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 10px;
            text-align: center;
            max-width: 200px;
        }
        
        .photo-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .photo-date {
            font-size: 12px;
            color: #666;
            margin: 8px 0;
        }
        
        .no-photos {
            text-align: center;
            color: #666;
            font-style: italic;
            margin: 40px 0;
        }
    </style>
</head>
<body id="antu">
    <h1 id="Header">Progress Photo Album</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align: center; font-weight: bold;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="" enctype="multipart/form-data">
        <fieldset>
            <label for="photo">Select Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br>
            <small style="color: red;">Accepted formats: JPEG, PNG, GIF (Max size: 5MB)</small>
            
            <?php if(!empty($error)): ?>
                <div style="color: red; margin-top: 8px; font-weight: bold;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <input type="submit" name="submit" value="Add Photo">
        </fieldset>
    </form>

    <div style="text-align:center; margin-top:30px;">
        <a id="back" href="dashBoard.php"><button type="button">Back to Dashboard</button></a>
    </div>

    <h3>Photo Timeline</h3>
    <div id="photoGallery">
        <?php if(isset($_SESSION['photos']) && count($_SESSION['photos']) > 0): ?>
            <?php foreach(array_reverse($_SESSION['photos'], true) as $index => $photo): ?>
                <div class="photo-item">
                    <img src="<?php echo htmlspecialchars($photo['path']); ?>" 
                         alt="Progress Photo"
                         title="Uploaded: <?php echo $photo['date']; ?>">
                    <div class="photo-date"><?php echo date('M j, Y g:i A', strtotime($photo['date'])); ?></div>
                    <a href="?delete=<?php echo $index; ?>" 
                       onclick="return confirm('Are you sure you want to delete this photo?')"
                       style="text-decoration: none;">
                        <button type="button" style="background: #d9534f; color: white; font-size: 12px; padding: 5px 10px;">Delete</button>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-photos">
                <p>No photos uploaded yet. Start tracking your progress by adding your first photo!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>