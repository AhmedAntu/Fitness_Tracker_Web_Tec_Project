<?php
    session_start();

    /*
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }*/

    if(!isset($_SESSION['measurements'])){
        $_SESSION['measurements'] = array();
    }

    $errors = array();
    $success = "";
    $editIndex = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $weight = trim($_POST['weight']);
        $waist = trim($_POST['waist']);
        $chest = trim($_POST['chest']);
        $editIndex = isset($_POST['editIndex']) ? intval($_POST['editIndex']) : null;

        if(empty($weight) || !is_numeric($weight) || $weight < 20 || $weight > 100){
            $errors['weight'] = "Please enter weight between 20 to 100 kg!";
        }
        if(empty($waist) || !is_numeric($waist) || $waist < 20 || $waist > 100){
            $errors['waist'] = "Please enter waist between 20 to 100 cm!";
        }
        if(empty($chest) || !is_numeric($chest) || $chest < 20 || $chest > 100){
            $errors['chest'] = "Please enter chest between 20 to 100 cm!";
        }

        if(empty($errors)){
            $measurementData = array(
                'weight' => $weight,
                'waist' => $waist,
                'chest' => $chest,
                'date' => date('Y-m-d H:i:s')
            );

            if($editIndex !== null && isset($_SESSION['measurements'][$editIndex])){
                $_SESSION['measurements'][$editIndex] = $measurementData;
                $success = "Measurement updated successfully!";
            } else {
                $_SESSION['measurements'][] = $measurementData;
                $success = "Measurement saved successfully!";
            }

            $weight = $waist = $chest = "";
            $editIndex = null;
        }
    }

    if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
        $index = intval($_GET['delete']);
        if(isset($_SESSION['measurements'][$index])){
            array_splice($_SESSION['measurements'], $index, 1);
            header('location: measurement.php');
            exit();
        }
    }

    if(isset($_GET['edit']) && is_numeric($_GET['edit'])){
        $editIndex = intval($_GET['edit']);
        if(isset($_SESSION['measurements'][$editIndex])){
            $m = $_SESSION['measurements'][$editIndex];
            $weight = $m['weight'];
            $waist = $m['waist'];
            $chest = $m['chest'];
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
</head>
<body id="antu">
    <h1 id="Header">Measurement Input</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="">
        <fieldset>
            Weight (kg): 
            <input type="number" id="weight" name="weight" 
                   value="<?php echo isset($weight) ? htmlspecialchars($weight) : ''; ?>" 
                   step="0.1" required>
            <?php if(isset($errors['weight'])): ?>
                <div style="color: red;"><?php echo $errors['weight']; ?></div>
            <?php endif; ?>
            
            Waist (cm): 
            <input type="number" id="waist" name="waist" 
                   value="<?php echo isset($waist) ? htmlspecialchars($waist) : ''; ?>" 
                   step="0.1" required>
            <?php if(isset($errors['waist'])): ?>
                <div style="color: red;"><?php echo $errors['waist']; ?></div>
            <?php endif; ?>
            
            Chest (cm): 
            <input type="number" id="chest" name="chest" 
                   value="<?php echo isset($chest) ? htmlspecialchars($chest) : ''; ?>" 
                   step="0.1" required>
            <?php if(isset($errors['chest'])): ?>
                <div style="color: red;"><?php echo $errors['chest']; ?></div>
            <?php endif; ?>

            <?php if($editIndex !== null): ?>
                <input type="hidden" name="editIndex" value="<?php echo $editIndex; ?>">
                <input type="submit" name="submit" value="Update Measurement">
                <input type="button" value="Cancel" onclick="location.href='measurement.php'">
            <?php else: ?>
                <input type="submit" name="submit" value="Save Measurement">
            <?php endif; ?>
        </fieldset>
    </form>

    <div style="text-align:center; margin-top:50px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>

    <h3>Measurement History</h3>
    <ul id="measurementList">
        <?php if(isset($_SESSION['measurements']) && count($_SESSION['measurements']) > 0): ?>
            <?php foreach($_SESSION['measurements'] as $index => $m): ?>
                <li>
                    Weight: <?php echo htmlspecialchars($m['weight']); ?> kg, 
                    Waist: <?php echo htmlspecialchars($m['waist']); ?> cm, 
                    Chest: <?php echo htmlspecialchars($m['chest']); ?> cm
                    [<?php echo $m['date']; ?>]
                    &nbsp;
                    <a href="?edit=<?php echo $index; ?>"><button type="button">Edit</button></a>
                    <a href="?delete=<?php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this measurement?')"><button type="button">Delete</button></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</body>
</html>
