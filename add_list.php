<?php
    include('config/constants.php');
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

    <h3>Add List Page</h3>


    <p>
        <?php
            // Check whether the session is create or not
            if(isset($_SESSION['add_fail']))
            {
                // display session message
                echo $_SESSION['add_fail'];

                // remove the message after displaying once
                unset($_SESSION['add_fail']);
            }


        ?>

    </p>

    <!-- form to add list starts here -->
    <form action="" method="POST">

        <table class="tbl-half">
            <tr>
                <td>List Name:</td>
                <td><input type="text" name="list_name" placeholder="Type list name here" required="required" ></td>
            </tr>

            <tr>
                <td>List Description:</td>
                <td> <textarea name="list_description" id="" cols="" rows="" placeholder="Type list description here"></textarea></td>
            </tr>

            <tr>
                <td> <input class="btn-primary btn-lg" type="submit" name="submit" value="SAVE"> </td>
            </tr>
        </table>

    </form>
    <!-- form to add list ends here -->
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
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME);

        // SQL Query to Insert data into database
        $sql = "INSERT INTO tbl_lists SET
        list_name = '$list_name',
        list_description = '$list_description' ";

        // Execute Query and Insert into Database
        $res = mysqli_query($conn,$sql);
        
        if($res == true)
        {
            // Create to Session variable to display message
            $_SESSION['add'] = "<div class='success'>List Added Successfully !</div>";
           
            // Redirect to Manage List Page
            header('location:' .SITEURL.'manage_list.php');

        }
        else
        {
            // Create to Session variable to display message
            $_SESSION['add_fail'] = "<div class='fail'>Failed to  Add List</div>";
            
            // Redirect to Manage List Page
            header('location:' .SITEURL.'add_list.php');
        }

    }
?>