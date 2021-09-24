<?php
//step 1: get database connection
require_once "db.php";

$errors = array();
$success = false;
$totalpin = "";
$amount = "";
$length = 15;

//step 2: get data from form
if (isset($_POST['generate'])) {
    $totalpin = $_POST['totalpin'];
    $amount = $_POST['amount'];

    //validation
    if ($totalpin == 0) {
        $errors[] = "Total PIN must be greater than 0";
    }
    if ($amount < 50) {
        $errors[] = "Mininum PIN Value/Amount is 50";
    }
    if ($amount % 50 != 0) {
        $errors[] = "PIN Value/Amount must be a multiple of 50";
    }

    //error check
    if (count($errors) == 0) { //no error
        //step 3: process data
        //step 3a: Generate PINs based on the totalpin supplied by user
        $i = 1;
        while ($i <= $totalpin) {
            //generate pin
            $pin = substr(str_pad(mt_rand(1, 999999999999999), $length, '0', STR_PAD_LEFT), 0, $length);
            // echo "PIN: $pin | Amount: $amount";

            //insert into database
            $sql = "INSERT INTO pins(pin, amount) VALUES ('$pin', '$amount')";
            $result = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));
            $i++;
        }

        //reset inputs
        $totalpin = $amount = "";
        $success = true;
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN Generator</title>
</head>

<body>
    <div>
        <a href="index.php">Generate PIN</a> | <a href="view.php">View PINs</a> | <a href="load.php">Load PIN</a>
    </div>

    <!-- Show Form -->
    <div style="margin-top: 10px;">
        <div>
            <?php
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<p style='color: red;'>$error</p>";
                }
            }

            if ($success) {
                echo "<p style='color: green;'>PINs successfully generated.</p>";
            }

            ?>
        </div>
        <form action="index.php" method="post">
            <label for="totalpin">Total PIN: </label>
            <input type="number" name="totalpin" value="<?php echo $totalpin; ?>" id="totalpin" required />

            <label for="amount">PIN Value/Amount: </label>
            <input type="number" name="amount" value="<?php echo $amount; ?>" id="amount" required />

            <input type="submit" name="generate" value="Generate">
        </form>
    </div>
</body>

</html>