# Task-Manager_with_PHP

# Output:
![Screenshot (6)](https://user-images.githubusercontent.com/72061868/162188148-253f3278-9f8f-4328-8a40-d1b3d2bdaa30.png)


# Code

index.php

````
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

<p>
        <?php
            // Check whether the session is create or not
            if(isset($_SESSION['add']))
            {
                // display session message
                echo $_SESSION['add'];
                // remove the message after displaying once
                unset($_SESSION['add']);
            }

            // Check the session for delete
            if(isset($_SESSION['delete']))
            {
                // display session message
                echo $_SESSION['delete'];
                // remove the message after displaying once
                unset($_SESSION['delete']);
            }

            
            // Check the session for delete fail
            if(isset($_SESSION['delete_fail']))
            {
                // display session message
                echo $_SESSION['delete_fail'];
                // remove the message after displaying once
                unset($_SESSION['delete_fail']);
            }

            // Check the session for update
            if(isset($_SESSION['update']))
            {
                // display session message
                echo $_SESSION['update'];
                // remove the message after displaying once
                unset($_SESSION['update']);
            }
        ?>
</p>
 <br>

<!-- Tasks Starts Here -->
<div class="all-tasks">

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
            $sql = "SELECT * FROM tbl_tasks";

            // Execute Query 
            $res = mysqli_query($conn, $sql);
            
            if($res == true)
            {
                // count row of data in database
                $count_rows = mysqli_num_rows($res);


                // create a serial number variable
                $sn = 1;

                if($count_rows>0)
                {
                    // there's data in database display table 
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // getting the data from database
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
                            <td colspan="5">No Task Added Yet.</td>
                        </tr>
                    <?php
                }

            }

        ?>

    </table>
</div>
<!-- Tasks Ends Here -->

</div>
</body>
</html>
````
