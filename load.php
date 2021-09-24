<?php
//step 1: get database connection
require_once "db.php";

$errors = array();
$message = "";
$success = false;

//step 2: get data from form
if (isset($_POST['load'])) {
    $pin = $_POST['pin'];

    //verify that pin exist from database
    $sql = "SELECT * FROM pins WHERE pin = '$pin' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        //pin found
        $pin_row = mysqli_fetch_assoc($result);

        //check if pin has already been used
        if ($pin_row['status'] > 0) {
            //pin has been used
            $errors[] = "PIN $pin has been used.";
        } else {
            //pin has not been used
            //update the pin row to used
            $sql = "UPDATE pins SET status = 1 WHERE pin = '$pin'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                //return success and amount to user
                $message = "Recharge of {$pin_row['amount']} was successful. Do 3 more recharges today to qualify for 800% bonus.";
                $success = true;
            }
        }
    } else {
        //pin not found
        $errors[] = "PIN $pin not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN Generation</title>
</head>

<body>
    <div>
        <a href="index.php">Generate PIN</a> | <a href="view.php">View PINs</a> | <a href="load.php">Load PIN</a>
    </div>

    <div style="margin-top: 10px;">
        <div>
            <?php
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            }

            if ($success) {
                echo "<p style='color: green;'>$message</p>";
            }

            ?>
        </div>
        <form action="load.php" method="post">
            <label for="pin">PIN: </label>
            <input type="number" name="pin" id="pin" required />

            <input type="submit" name="load" value="Load">
        </form>
    </div>
</body>

</html>