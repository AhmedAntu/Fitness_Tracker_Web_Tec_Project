<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */

    if(!isset($_SESSION['exercises'])){
        $_SESSION['exercises'] = array();
    }

    $error = "";
    $success = "";
    $exercise = "";
    $duration = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $exercise = trim($_POST['exercise']);
        $duration = trim($_POST['duration']);

        if(empty($exercise)){
            $error = "Exercise name cannot be empty!";
        } elseif(empty($duration)){
            $error = "Duration cannot be empty!";
        } elseif(!ctype_digit($duration) || intval($duration) <= 0){
            $error = "Duration must be a positive number (minutes).";
        } else {
            $_SESSION['exercises'][] = [
                'exercise' => $exercise,
                'duration' => intval($duration),
                'timestamp' => date('Y-m-d H:i:s')
            ];
            $success = "Exercise logged successfully!";
            $exercise = "";
            $duration = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Logger</title>
    <link rel="stylesheet" href="/Fitness_Tracker_Web_Tec_Project/Group_04/Antu/asset/style.css">

    <script>
        function validateExerciseForm(){
            let exercise = document.getElementById('exercise').value.trim();
            let duration = document.getElementById('duration').value.trim();
            let errorBox = document.getElementById('jsError');

            if(exercise === ""){
                errorBox.innerHTML = "Please select an exercise!";
                errorBox.style.color = "red";
                return false;
            }

            if(duration === ""){
                errorBox.innerHTML = "Duration cannot be empty!";
                errorBox.style.color = "red";
                return false;
            } else if(isNaN(duration) || parseInt(duration) <= 0){
                errorBox.innerHTML = "Duration must be a positive number.";
                errorBox.style.color = "red";
                return false;
            }

            errorBox.innerHTML = "";
            return true;
        }
    </script>
</head>
<body id="antu">
    <h1 id="Header">Exercise Logger</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align:center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="" onsubmit="return validateExerciseForm();">
        <fieldset>
            Exercise Name:
            <select id="exercise" name="exercise" required>
                <option value="">-- Select Exercise --</option>
                <option value="Running" <?php if($exercise==="Running") echo "selected"; ?>>Running</option>
                <option value="Cycling" <?php if($exercise==="Cycling") echo "selected"; ?>>Cycling</option>
                <option value="Swimming" <?php if($exercise==="Swimming") echo "selected"; ?>>Swimming</option>
                <option value="Push-ups" <?php if($exercise==="Push-ups") echo "selected"; ?>>Push-ups</option>
                <option value="Squats" <?php if($exercise==="Squats") echo "selected"; ?>>Squats</option>
                <option value="Plank" <?php if($exercise==="Plank") echo "selected"; ?>>Plank</option>
                <option value="Other" <?php if($exercise==="Other") echo "selected"; ?>>Other</option>
            </select><br><br>
            
            Duration (minutes):
            <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($duration); ?>" placeholder="Enter duration in minutes">
            
            <div id="jsError"></div>
            <?php if(!empty($error)): ?>
                <div style="color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <input type="submit" name="submit" value="Log Exercise">
        </fieldset>
    </form>

    <h3>Logged Exercises</h3>
    <ul id="exerciseList">
        <?php if(count($_SESSION['exercises']) > 0): ?>
            <?php foreach($_SESSION['exercises'] as $ex): ?>
                <li>[<?php echo $ex['timestamp']; ?>] 
                    <?php echo htmlspecialchars($ex['exercise']); ?> - 
                    <?php echo htmlspecialchars($ex['duration']); ?> minutes
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <div style="text-align:center; margin-top: 40px;">
        <a id="back" href="../controller/dashBoard.php"><button type="button">Back</button></a>
    </div>
</body>
</html>
