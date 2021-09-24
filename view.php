<?php
//step 1: get database connection
require_once "db.php";

//step 2: read data from database
$sql = "SELECT * FROM pins";
$result = mysqli_query($conn, $sql);

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
        <table border="1">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>PIN</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Used</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    //data found
                    $index = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pin = $row['pin'];
                        $amount = $row['amount'];
                        $status = $row['status'] == 0 ? "New" : "Used";

                        // if ($row['status'] == 0) {
                        //     $status = "New";
                        // } else {
                        //     $status = "Used";
                        // }

                        $created = $row['created_at'];
                        $updated = $row['updated_at'];
                        echo "<tr>";
                        echo "<td>$index.</td>";
                        echo "<td>$pin</td>";
                        echo "<td>$amount</td>";
                        echo "<td>$status</td>";
                        echo "<td>$created</td>";
                        echo "<td>$updated</td>";
                        echo "</tr>";

                        $index++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>