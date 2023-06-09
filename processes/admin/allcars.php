<?php

// connecting to our database
$link = mysqli_connect("localhost", "root", "", "rentacar");
// Check connection
if($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Attempt select query execution
$sql = "SELECT * FROM vehicles";
if($result = mysqli_query($link, $sql)) {
    // if the number of rows is bigger than 0 it means there is data se we continue with what we want to do with that data
    if(mysqli_num_rows($result) > 0) {
        $resultArray = array(); //an additional array where we store all rows so we can pass it to the javascript
        echo "<table>";
        echo "<tr><th>Type</th><th>Brand</th><th>Model</th><th>Year</th><th>Price per day</th><th style='text-align: center;'>#</th></tr>";
        while($row = mysqli_fetch_array($result)) {
            $resultArray[] = $row; //store every row in the additional array
            echo "<tr>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['price_per_day'] . "</td>";

            // edit and delete buttons so we can edit or delete cars that we have,
            // we created some javascript functions to fill the dialogs that show when we click edit or delete
            // we pass the ids as parameters, to have more adaptability in javascript
            echo "<td><button style='color: darkgreen;' onclick='showDialogForEdit(\"" . $row['vehicle_id'] . "\")'>Edit</button><button style='color: red;' onclick='showDialogForDelete(\"" . $row['vehicle_id'] . "\")'>Delete</button></td>";
            echo "</tr>";
        }
        $jsonResult = json_encode($resultArray); //converting the array to json format
        echo "<script>var phpResult = " . $jsonResult . ";</script>"; //storing that array in json format in a javascript variable so we can use it in our JS functions
        echo "</table>";
    } else {
        echo "No records matching your query were found.";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
// Close connection
mysqli_close($link);
?>