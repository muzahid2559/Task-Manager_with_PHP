<?php

    // include constants.php
    include('config/constants.php');


    if (isset($_GET['update_list_id']))
    {
        
        // Get the list_id value from URL or Get method
        $list_id = $_GET['update_list_id'];
        
        // connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());

        // Write the Query to Delete List from Daatabase
        $sql = "SELECT * FROM tbl_lists WHERE list_id = $list_id";

        // Execute Query and Insert into Database
        $res = mysqli_query($conn,$sql);

        if($res == true)
        {
            // value is in array 
            $row = mysqli_fetch_assoc($res);
            
            // getting the data from database
            $list_name = $row['list_name'];
            $list_description = $row['list_description'];

        }
        else
        {
            // Redirect to Manage List Page
            header('location:' .SITEURL.'manage_list.php');
        }
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager with PHP and MySQL</title>

    <!-- CSS LINK START -->
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    <!-- CSS LINK END -->

</head>
<body>
<div class="wrapper">

    <h1>Task Manager</h1>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
    <a class="btn-secondary" href="<?php echo SITEURL; ?>manage_list.php">Manage Lists</a>

    <h3>Update List Page</h3>

    <p>
        <?php
            // Check whether the session is create or not
            if(isset($_SESSION['update_fail']))
            {
                // display session message
                echo $_SESSION['update_fail'];

                // remove the message after displaying once
                unset($_SESSION['update_fail']);
            }


        ?>
    </p>


    <!-- form to update list starts here -->
    <form action="" method="POST">

    <table class="tbl-half">
    <tr>
        <td>List Name:</td>
        <td><input type="text" name="list_name" value=" <?php echo $list_name; ?>" required="required" ></td>
    </tr>

    <tr>
        <td>List Description:</td>
        <td> <textarea name="list_description"> <?php echo $list_description; ?> </textarea></td>
    </tr>

    <tr>
        <td> <input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE"> </td>
    </tr>
    </table>

    </form>
    <!-- form to update list ends here -->


</div>
</body>
</html>


<?php

    // Check whether the form is submitted  or not
    if(isset($_POST['submit']))
    {
        // get the values from form and save it in variables
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];


        // connect database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select2 = mysqli_select_db($conn2, DB_NAME);

        // SQL Query to Insert data into database
        $sql2 = "UPDATE tbl_lists SET
        list_name = '$list_name',
        list_description = '$list_description' 
        WHERE list_id = $list_id
        ";

        // Execute Query and Insert into Database
        $res2 = mysqli_query($conn2,$sql2);
        
        if($res2 == true)
        {
            // Create to Session variable to display message
            $_SESSION['update'] = "<div class='success'>List Updated Successfully !</div>";
           
            // Redirect to Manage List Page
            header('location:' .SITEURL.'manage_list.php');

        }
        else
        {
            // Create to Session variable to display message
            $_SESSION['update_fail'] = "<div class='fail'>Failed to  Updated List </div>";
            
            // Redirect to update List Page
            header('location:' .SITEURL.'update_list.php?list_id='.$list_id);
        }

    }
?>