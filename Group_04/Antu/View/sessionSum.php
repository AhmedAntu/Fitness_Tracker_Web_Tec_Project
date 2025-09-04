<?php
    session_start();

    /* 
    if(!isset($_COOKIE['status']) || $_COOKIE['status'] != true){
        header('location: login.php?error=badrequest');
        exit();
    }
    */

    if(!isset($_SESSION['sessionNotes'])){
        $_SESSION['sessionNotes'] = array();
    }

    $error = "";
    $success = "";
    $editIndex = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $notes = trim($_POST['notes']);
        $editIndex = isset($_POST['editIndex']) ? intval($_POST['editIndex']) : null;

        if(empty($notes)){
            $error = "Notes cannot be empty!";
        } else {
            $noteData = array(
                'note' => $notes,
                'timestamp' => date('Y-m-d H:i:s')
            );

            if($editIndex !== null && isset($_SESSION['sessionNotes'][$editIndex])){
                $_SESSION['sessionNotes'][$editIndex] = $noteData;
                $success = "Session note updated successfully!";
            } else {
                $_SESSION['sessionNotes'][] = $noteData;
                $success = "Session notes saved successfully!";
            }

            $notes = "";
            $editIndex = null;
        }
    }

    if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
        $index = intval($_GET['delete']);
        if(isset($_SESSION['sessionNotes'][$index])){
            array_splice($_SESSION['sessionNotes'], $index, 1);
            header('location: sessionSum.php');
            exit();
        }
    }

    if(isset($_GET['edit']) && is_numeric($_GET['edit'])){
        $editIndex = intval($_GET['edit']);
        if(isset($_SESSION['sessionNotes'][$editIndex])){
            $session = $_SESSION['sessionNotes'][$editIndex];
            $notes = $session['note'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Summary</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function filterSessions() {
            let filter = document.getElementById('sessionSearch').value.toLowerCase();
            let list = document.getElementById('sessionList');
            let items = list.getElementsByTagName('li');

            for(let i=0; i<items.length; i++){
                let txt = items[i].textContent || items[i].innerText;
                items[i].style.display = txt.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    </script>
</head>
<body id="antu">
    <h1 id="Header">Session Summary</h1>

    <?php if(!empty($success)): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form id="Form" method="post" action="">
        <fieldset>
            Notes:
            <textarea id="notes" name="notes" 
                      placeholder="Enter session notes here..." 
                      rows="4" cols="50" required><?php echo isset($notes) ? htmlspecialchars($notes) : ''; ?></textarea>
            <?php if(!empty($error)): ?>
                <div style="color: red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if($editIndex !== null): ?>
                <input type="hidden" name="editIndex" value="<?php echo $editIndex; ?>">
                <input type="submit" name="submit" value="Update Note">
                <input type="button" value="Cancel" onclick="location.href='sessionSum.php'">
            <?php else: ?>
                <input type="submit" name="submit" value="Save Session Notes">
            <?php endif; ?>
        </fieldset>
    </form>

    <h3>Previous Sessions</h3>
    <input type="text" id="sessionSearch" class="search-field" placeholder="Search sessions" oninput="filterSessions()">

    <ul id="sessionList">
        <?php if(isset($_SESSION['sessionNotes']) && count($_SESSION['sessionNotes']) > 0): ?>
            <?php foreach($_SESSION['sessionNotes'] as $index => $session): ?>
                <li>
                    [<?php echo $session['timestamp']; ?>] 
                    <?php echo htmlspecialchars($session['note']); ?>
                    <a href="?edit=<?php echo $index; ?>"><button type="button">Edit</button></a>
                    <a href="?delete=<?php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this session?')">
                        <button type="button">Delete</button>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <div style="text-align:center; margin-top: 40px;">
        <a id="back" href="dashBoard.php"><button type="button">Back</button></a>
    </div>
</body>
</html>
