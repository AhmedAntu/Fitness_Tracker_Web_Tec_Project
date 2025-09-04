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

    $editIndex = null;
    $errors = array();
    $success = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $exercise = trim($_POST['exercise']);
        $sets = trim($_POST['sets']);
        $reps = trim($_POST['reps']);
        $weight = trim($_POST['weight']);
        $editIndex = isset($_POST['editIndex']) ? intval($_POST['editIndex']) : null;

        if(empty($exercise)){
            $errors['exercise'] = "Please select an exercise!";
        }
        if(empty($sets) || !is_numeric($sets) || $sets <= 0){
            $errors['sets'] = "Sets must be a positive number!";
        }
        if(empty($reps) || !is_numeric($reps) || $reps <= 0){
            $errors['reps'] = "Reps must be a positive number!";
        }
        if(!empty($weight) && (!is_numeric($weight) || $weight < 50)){
            $errors['weight'] = "Weight must be 50 or more.";
        }

        if(empty($errors)){
            $exerciseData = array(
                'exercise' => $exercise,
                'sets' => $sets,
                'reps' => $reps,
                'weight' => $weight,
                'timestamp' => date('Y-m-d H:i:s')
            );

            if($editIndex !== null && isset($_SESSION['exercises'][$editIndex])){
                $_SESSION['exercises'][$editIndex] = $exerciseData;
                $success = "Exercise updated successfully!";
            } else {
                $_SESSION['exercises'][] = $exerciseData;
                $success = "Exercise logged successfully!";
            }

            $exercise = $sets = $reps = $weight = "";
            $editIndex = null;
        }
    }

    if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
        $index = intval($_GET['delete']);
        if(isset($_SESSION['exercises'][$index])){
            array_splice($_SESSION['exercises'], $index, 1);
            header('location: exerciseLogger.php');
            exit();
        }
    }

    if(isset($_GET['edit']) && is_numeric($_GET['edit'])){
        $editIndex = intval($_GET['edit']);
        if(isset($_SESSION['exercises'][$editIndex])){
            $ex = $_SESSION['exercises'][$editIndex];
            $exercise = $ex['exercise'];
            $sets = $ex['sets'];
            $reps = $ex['reps'];
            $weight = $ex['weight'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Logger</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="antu">
    <h1 id="Header">Exercise Logger</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="">
        <fieldset>
            Exercise Name:
            <select id="exercise" name="exercise" required>
                <option value="" disabled selected>Select an exercise</option>
                <option value="Push-ups" <?php if(isset($exercise) && $exercise=="Push-ups") echo "selected"; ?>>Push-ups</option>
                <option value="Squats" <?php if(isset($exercise) && $exercise=="Squats") echo "selected"; ?>>Squats</option>
                <option value="Plank" <?php if(isset($exercise) && $exercise=="Plank") echo "selected"; ?>>Plank</option>
                <option value="Burpees" <?php if(isset($exercise) && $exercise=="Burpees") echo "selected"; ?>>Burpees</option>
                <option value="Jumping Jacks" <?php if(isset($exercise) && $exercise=="Jumping Jacks") echo "selected"; ?>>Jumping Jacks</option>
                <option value="Crunches" <?php if(isset($exercise) && $exercise=="Crunches") echo "selected"; ?>>Crunches</option>
                <option value="Lunges" <?php if(isset($exercise) && $exercise=="Lunges") echo "selected"; ?>>Lunges</option>
                <option value="Mountain Climbers" <?php if(isset($exercise) && $exercise=="Mountain Climbers") echo "selected"; ?>>Mountain Climbers</option>
                <option value="Other" <?php if(isset($exercise) && $exercise=="Other") echo "selected"; ?>>Other</option>
            </select>
            <?php if(isset($errors['exercise'])): ?>
                <div style="color: red;"><?php echo $errors['exercise']; ?></div>
            <?php endif; ?>
            <br><br>

            Sets: <input type="number" id="sets" name="sets" value="<?php echo isset($sets) ? htmlspecialchars($sets) : ''; ?>" required>
            <?php if(isset($errors['sets'])): ?>
                <div style="color: red;"><?php echo $errors['sets']; ?></div>
            <?php endif; ?>
            
            Reps: <input type="number" id="reps" name="reps" value="<?php echo isset($reps) ? htmlspecialchars($reps) : ''; ?>" required>
            <?php if(isset($errors['reps'])): ?>
                <div style="color: red;"><?php echo $errors['reps']; ?></div>
            <?php endif; ?>
            
            Weight (kg): <input type="number" id="weight" name="weight" value="<?php echo isset($weight) ? htmlspecialchars($weight) : ''; ?>">
            <?php if(isset($errors['weight'])): ?>
                <div style="color: red;"><?php echo $errors['weight']; ?></div>
            <?php endif; ?>

            <?php if($editIndex !== null): ?>
                <input type="hidden" name="editIndex" value="<?php echo $editIndex; ?>">
                <input type="submit" name="submit" value="Update Exercise">
                <input type="button" value="Cancel" onclick="location.href='exerciseLogger.php'">
            <?php else: ?>
                <input type="submit" name="submit" value="Log Exercise">
            <?php endif; ?>
        </fieldset>
    </form>

    <div style="text-align:center; margin-top:50px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>

    <h3>Logged Exercises</h3>
    <ul id="exerciseList">
        <?php if(isset($_SESSION['exercises']) && count($_SESSION['exercises']) > 0): ?>
            <?php foreach($_SESSION['exercises'] as $index => $ex): ?>
                <li>
                    <?php 
                        echo htmlspecialchars($ex['exercise']) . " - " . 
                             htmlspecialchars($ex['sets']) . " sets x " . 
                             htmlspecialchars($ex['reps']) . " reps";
                        if(!empty($ex['weight'])){
                            echo " (" . htmlspecialchars($ex['weight']) . " kg)";
                        }
                        echo " [" . $ex['timestamp'] . "]";
                    ?>
                    &nbsp;
                    <a href="?edit=<?php echo $index; ?>"><button type="button">Edit</button></a>
                    <a href="?delete=<?php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this exercise?')"><button type="button">Delete</button></a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</body>
</html>
