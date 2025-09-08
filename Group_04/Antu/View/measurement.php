<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */

    if(!isset($_SESSION['measurements'])){
        $_SESSION['measurements'] = array();
    }

    $error = "";
    $success = "";
    $height = "";
    $weight = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $height = trim($_POST['height']);
        $weight = trim($_POST['weight']);

        // ✅ PHP Validation
        if(empty($height) || !is_numeric($height) || $height <= 0){
            $error = "Height must be a positive number.";
        } elseif(empty($weight) || !is_numeric($weight) || $weight <= 0){
            $error = "Weight must be a positive number.";
        } else {
            $_SESSION['measurements'][] = [
                'height' => floatval($height),
                'weight' => floatval($weight),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            $success = "Measurement recorded successfully!";
            $height = "";
            $weight = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Measurement Input</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateMeasurementForm(){
            let height = document.getElementById('height').value.trim();
            let weight = document.getElementById('weight').value.trim();
            let errorBox = document.getElementById('jsError');

            if(height === "" || isNaN(height) || parseFloat(height) <= 0){
                errorBox.innerHTML = "Height must be a positive number.";
                errorBox.style.color = "red";
                return false;
            }

            if(weight === "" || isNaN(weight) || parseFloat(weight) <= 0){
                errorBox.innerHTML = "Weight must be a positive number.";
                errorBox.style.color = "red";
                return false;
            }

            errorBox.innerHTML = "";
            return true;
        }
    </script>
</head>
<body id="antu">
    <h1 id="Header">Measurement Input</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align:center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="" onsubmit="return validateMeasurementForm();">
        <fieldset>
            Height (cm):
            <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($height); ?>" placeholder="Enter height in cm">

            Weight (kg):
            <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($weight); ?>" placeholder="Enter weight in kg">

            <div id="jsError"></div>
            <?php if(!empty($error)): ?>
                <div style="color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <input type="submit" name="submit" value="Save Measurement">
        </fieldset>
    </form>

    <h3>Previous Measurements</h3>
    <ul id="measurementList">
        <?php if(count($_SESSION['measurements']) > 0): ?>
            <?php foreach($_SESSION['measurements'] as $m): ?>
                <li>[<?php echo $m['timestamp']; ?>] 
                    Height: <?php echo htmlspecialchars($m['height']); ?> cm, 
                    Weight: <?php echo htmlspecialchars($m['weight']); ?> kg
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <div style="text-align:center; margin-top: 40px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>
</body>
</html>
