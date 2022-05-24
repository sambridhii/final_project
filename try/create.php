<?php

require_once "config.php";

// Define variables and initialize with empty values
$location= $number_of_room = $feature = "";
$location_err = $number_of_room_err = $feature_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate location
    $input_location = trim($_POST["location"]);
    if (empty($input_location)) {
        $location_err = "Please enter your location.";
        echo "Please enter your location.";

    } elseif (!filter_var($input_location, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $location_err = "Please enter your location.";
        echo "Please enter a valid location.";

    } else {
        $location = $input_location;
    }

// Validate
    $input_location = trim($_POST["numberofroom"]);
    if (empty($input_numberofroom)) {
        $location_err = "Please enter your number of room.";
        echo "Please enter your location.";

    } elseif (!filter_var($input_numberofroom, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $numberofroom_err = "Please enter your location.";
        echo "Please enter a valid location.";

    } else {
        $numberofroom = $input_numberofroom;
    }

// Validate feature
    $input_feature = trim($_POST["feature"]);
    if (empty($input_feature)) {
        $feature_err = "Please enter the features.";
        echo "Please enter a last name.";
    } elseif (!filter_var($input_feature, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $feature_err = "Please enter the features.";
        echo "Please enter the features.";
    } else {
        $feature = $input_feature;
    }



    if (empty($location_err_err) && empty($numberofroom_err) && empty($feature_err)) {
// Prepare an insert statement

        $temp_name=$_FILES['image']['tmp_name'];
        $filename=$_FILES['image']['name'];
        $folder = "upload/".$filename;
        if (move_uploaded_file($temp_name, $folder))  {
            $msg = "Image uploaded successfully";
        }else{
            $msg = "Failed to upload image";
        }

        $sql = "INSERT INTO house ( location, numberofroom, feature,image, contact) VALUES (?, ?, ?, ?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $location, $numberofroom, $feature, $filename, $contact);

            // Set parameters
            $location = trim($_POST['location']);
            $numberofroom = trim($_POST['numberofroom']);
            $feature = trim($_POST['feature']);
            $filename=$_FILES['image']['name'];
            $contact = trim($_POST['contact']);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                header("location: retrieve_to.php");
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }

// Close statement
        mysqli_stmt_close($stmt);

// Close connection
        mysqli_close($conn);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Main Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


</head>
<body>

<!--navigation bar-->
<nav class="navbar navbar-expand-sm bg-dark navbar>
    <div class="container-fluid">
<a href="mainpage.php" class="navbar-brand nav-link">HOUSE RENTAL</a>
<div class="collapse navbar-collapse">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="mainpage_owner.php" class="nav-link" >Home page</a>
        </li>
        <li class="nav-item">
            <a href="retrieve.php" class="nav-link" >Available houses</a>
        </li>
        <li class="nav-item">
            <a href="search.php" class="nav-link">Search</a>
        </li>
        <li class="nav-item">
            <a href="logout.php" class="nav-link">Log out</a>
        </li>
    </ul>
</div>
</div>
</nav>

<div>
<form action="create.php" method="post" enctype="multipart/form-data">
   Location: <input type="text" placeholder="Enter location here" name="location" > <br><br>
    Number of room: <input type="text" placeholder="Enter number of room here" name="numberofroom"> <br><br>
    Features: <input type="text" placeholder="Enter features here" name="feature"> <br><br>
    Upload Image: <input type="file" placeholder="Upload Image" name="image" required><br> <br>
    Contact <input type="text" placeholder="Enter your contact number" name="contact"> <br><br>
    <input type="submit" value="Submit">
</form>


</body>
</html>