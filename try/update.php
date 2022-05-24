
<?php
// Include config file
require_once "config.php";

//Define variables and initialize with empty values
$location= $number_of_room = $feature = "";
$location_err = $number_of_room_err = $feature_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
// Get hidden input value
    $id = $_POST["id"];
    $temp_name = $_FILES['image']['tmp_name'];
    $filename = $_FILES['image']['name'];
    $folder = "upload/" . $filename;


//Validate location
    $input_location = trim($_POST["location"]);
    if (empty($input_location )) {
        $location_err = "Please enter your location";
        echo "Please enter your location .";
    } elseif (!filter_var($input_location , FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $location_err = "Please enter a valid location ";
        echo "Please enter a valid location ";
    } else {
        $location  = $input_location ;
    }

//Validate Number of room
    $input_numberofroom = trim($_POST["numberofroom"]);
    if (empty($input_numberofroom)) {
        $last_name_err = "Please enter a last name";
        echo "Please enter a last name.";
    } elseif (!filter_var($input_numberofroom, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $numberofroom_err = "Please enter a valid number of room";
        echo "Please enter a valid number of room";

    } else {
        $numberofroom = $input_numberofroom;
    }
//Validation of features
    $input_feature = trim($_POST["feature"]);
    if (empty($input_feature)) {
        $feature_err = "Please enter the features";
        echo "Please enter the features";
    } else {
        $feature = $input_feature;
    }

// Check input errors before inserting in database
    if (empty($first_name_err) && empty($numberofroom_err) && empty($feature_err)) {
        // Prepare an update statement
        if ($filename == "") {

            $sql = "UPDATE house  SET  location=?, numberofroom=?, feature=? WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssi", $param_location, $param_numberofroom, $param_feature, $param_id);

                // Set parameters
                $param_location = $location;
                $param_numberofroom = $numberofroom;
                $param_feature = $feature;
                $param_id = $id;
            }
        } else {
            $sql = "UPDATE persons SET location=?, numberofroom=?, feature=?, image=? WHERE id=?";
            if ($stmt = mysqli_prepare($conn, $sql)) {

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssi", $param_location, $param_numberofroom, $param_feature, $filename, $param_id);
                // Set parameters
                $param_location = $location;
                $param_numberofroom = $numberofroom;
                $param_feature = $feature;
                $filename = $_FILES['image']['name'];
                $param_id = $id;
            }
        }
        if (move_uploaded_file($temp_name, $folder)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Failed to upload image";
        }
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {

            // Records updated successfully. Redirect to landing page
            header("location: retrieve_to.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }


// Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);



        // Prepare a select statement
        $sql = "SELECT * FROM house WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            echo "";

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                echo "";

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result);

                    // Retrieve individual field value
                    $location = $row["location"];
                    $numberofroom = $row["numberofroom"];
                    $feature = $row["feature"];
                    $image = $row["image"];

                } else {
                    echo "11";

                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>UPDATE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>

<!--navigation bar-->
<nav class="navbar navbar-expand-sm bg-dark navbar>
    <div class="container-fluid">
        <a href="mainpage_owner.php" class="navbar-brand nav-link">HOUSE RENTAL</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="mainpage_owner.php" class="nav-link" >Home page</a>
                </li>
                <li class="nav-item">
                    <a href="create.php" class="nav-link" >Upload </a>
                </li>
                <li class="nav-item">
                    <a href="search.php" class="nav-link">search</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<form action="create.php" method="post" enctype="multipart/form-data">
   Location: <input type="text" placeholder="Enter location here" name="location" > <br><br>
    Number of room: <input type="text" placeholder="Enter number of room here" name="numberofroom"> <br><br>
    Features: <input type="text" placeholder="Enter features here" name="feature"> <br><br>
    Upload Image: <input type="file" placeholder="Upload Image" name="image" required>
    <input type="submit" value="Submit">
</form>


</body>
</html>