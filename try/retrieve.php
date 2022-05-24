<?php

require_once "config.php";
?>
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<!--navigation bar-->
<nav class="navbar navbar-expand-sm bg-dark navbar>
    <div class="container-fluid">
<a href="mainpage.php" class="navbar-brand nav-link">HOUSE RENTAL</a>
<div class="collapse navbar-collapse">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a href="mainpage_tenant.php" class="nav-link" >Home page</a>
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

</div>
</html>
    <!DOCTYPE html>
    <html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>phpzag.com : Demo Create Bootstrap Cards with PHP and MySQL</title>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <div class="container">
    <h2>Available houses</h2>
    <div class="row">
    <div class="col-lg-3 col-sm-6">
<?php
$sql = "SELECT  location, numberofroom, feature,image,contact FROM house";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
while( $record = mysqli_fetch_assoc($resultset) ) {
    ?>
    <link rel="stylesheet" href="style%202.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <div class="card hovercard">
        <div class="cardheader">
            <div class="Avatar">
                <img alt="" src="<?php echo $record['image']; ?>">
            </div>
        </div>
        <div class="card-body info">
            <div class="title">
                <a href="#"><?php echo $record['location']; ?></a>
            </div>
            <div class="desc"> <a target="_blank"
                                  href="<?php echo $record['feature']; ?>"><?php echo $record['feature']; ?></a></div>
            <div
                    class="desc"><?php echo $record['numberofroom']; ?> rooms</div>
            <div
                    class="desc"><?php echo $record['contact']; ?></div>
        </div>


    </div>
<?php } ?>
        <?php include('footer.php');?>
