<?php

require_once "config.php";
if (isset($_POST["search_keyword"]) && isset($_POST["search_keyword"])){
    $search_keyword=$_POST["search_keyword"];

    $search_field=$_POST["search_field"];


    if($search_field=="location"){
        $sql="SELECT * FROM house WHERE location LIKE '%".$search_keyword."%'";
        $result = mysqli_query($conn, $sql);
    }
    elseif($search_field=="numberofroom"){
        $sql="SELECT * FROM house WHERE numberofroom LIKE '%".$search_keyword."%'";
        $result = mysqli_query($conn, $sql);
    }
    elseif($search_field=="feature"){
        $sql="SELECT * FROM house WHERE feature LIKE '%".$search_keyword."%'";
        $result = mysqli_query($conn, $sql);
    }
}
?>
<html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<body>
<!--navigation bar-->
<nav class="navbar navbar-expand-sm bg-dark navbar>
    <div class="container-fluid">
<a href="mainpage_tenant.php" class="navbar-brand nav-link">HOUSE RENTAL</a>
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
<div class="container-fluid">

    <form action="search.php" method="post">
        <input type="text" name="search_keyword" placeholder="search here" required>
        <select name="search_field" required>
            <option value="location">Location</option>
            <option value="numberofroom">Number of room</option>
            <option value="feature">Feature</option>
        </select>
        <input type="submit" value="search">
    </form>

    <?php
    if(isset($result)) {
        if (mysqli_num_rows($result) == 0) {
            if (mysqli_num_rows($result) == 0) {
                echo "<tr>";
                echo "<td colspan='7'> Oops  not available</td>";
                echo "</tr>";
            }
        }else{
            echo" <table border=1 class='table table-light'>";
            echo"<tr>";
            echo"<th>Id</th>";
            echo"<th>Image</th>";
            echo" <th>Location</th>";
            echo"<th>Number of room</th>";
            echo"<th>Features</th>";
            echo"<th>Contact</th>";



           echo"</tr>";
        }
        ?>



        <?php foreach($result as $row){?>
            <tr>
                <td><?php echo$row['id']?></td>
                <td><img src="upload/<?php echo $row['image']?>" height="10%" width="20%"></td>
                <td><?php echo$row['location']?></td>
                <td><?php echo$row['numberofroom']?></td>
                <td><?php echo $row['feature']?></td>
                <td><?php echo $row['contact']?></td>
            </tr>
            <?php
        }
        ?>
    <?php }?>
</div>

</body>
</html>