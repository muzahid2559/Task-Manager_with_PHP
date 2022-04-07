<?php

    // include constants.php
    include('config/constants.php');



    if (isset($_GET['task_id']))
    {
        
        // Get the list_id value from URL or Get method
        $task_id = $_GET['task_id'];
        
        // connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());

        // Write the Query to Delete List from Daatabase
        $sql = "DELETE  FROM tbl_tasks WHERE task_id = $task_id";

        // Execute Query and Insert into Database
        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
            // Create to Session variable to display message
            $_SESSION['delete'] = "<div class='success'>Task Deleted Successfully !</div>";
           
            // Redirect to Manage List Page
            header('location:' .SITEURL);

        }
        else
        {
            // Create to Session variable to display message
            $_SESSION['delete_fail'] = "<div class='fail'>Failed to  Delete Task </div>";
            
            // Redirect to Manage List Page
            header('location:' .SITEURL);
        }

    }

    else
    {
         // Redirect to Manage List Page
         header('location:' .SITEURL);
    }


?>