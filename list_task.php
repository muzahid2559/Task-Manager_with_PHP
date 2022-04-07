<?php
    include('config/constants.php');

    // Get the Listed from URL
    $list_id_url = $_GET['list_id'];

    
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

    <!-- menu starts here -->
    <div class="menu">
        <a href="<?php echo SITEURL; ?>">Home</a>

        <?php

                // connect database
                $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

                // select database
                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die (mysqli_error());


                // SQL QUery to display all data from database
                $sql2 = "SELECT * FROM tbl_lists";

                // Execute Query 
                $res2 = mysqli_query($conn2, $sql2);
                
                if($res2 == true)
                {
                    // value is in array 
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $list_id = $row2['list_id'];
                        $list_name = $row2['list_name'];

                        ?>
                            <a href="<?php echo SITEURL; ?>list_task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?> </a>

                        <?php
                    }

                }
        ?>

        <a href="<?php echo SITEURL;?>manage_list.php">Manage Lists</a>
    </div>
    <!-- menu end here -->


    <!-- Tasks Starts Here -->
    <div class="all-task">

        <a class="btn-primary" href="<?php SITEURL; ?>add_task.php">Add Task</a>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Task Name</th>
                <th>Priority</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>

            <?php

                // connect database
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

                // select database
                $db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());


                // SQL QUery to display all data from database
                $sql = "SELECT * FROM tbl_tasks WHERE list_id= $list_id_url";


                $res = mysqli_query($conn, $sql);
            
                if($res == true)
                {
                    
                    // count rows
                    $count_rows = mysqli_num_rows($res);

                    // create a serial number variable
                    $sn = 1;

                    if($count_rows>0)
                    {
                        //  value is in array 
                        while($row = mysqli_fetch_assoc($res))
                        {
                            $task_id = $row['task_id'];
                            $task_name = $row['task_name'];
                            $priority = $row['priority'];
                            $deadline = $row['deadline'];
                        

                            ?>
                                <tr>
                                    <td><?php echo $sn++; ?> </td>
                                    <td><?php echo $task_name; ?> </td>
                                    <td><?php echo $priority; ?> </td>
                                    <td><?php echo $deadline; ?> </td>

                                    <td>
                                        <a class="btn-update" href="<?php echo SITEURL; ?>update_task.php?update_task_id=<?php echo $task_id; ?>">Update</a> 
                                        <a class="btn-delete" href="<?php echo SITEURL; ?>delete_task.php?task_id=<?php echo $task_id; ?>">Delete</a> 
                                    </td>
                                </tr>

                            <?php
                        }

                    }

                    else
                    {
                        ?>
                            <tr>
                                <td colspan="5">No Tasks Added on this list.</td>
                            </tr>
                        <?php
                    }
    
                        
        
                }

            ?>

</div>
    </body>
    </html>