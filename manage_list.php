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

    <h3>Manage Lists Page</h3>

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

    <!-- Table to display list starts here -->
    <div class="all-lists">

    <a class="btn-primary" href="<?php echo SITEURL; ?>add_list.php">Add List</a>
    
    <table class="tbl-half">
        

        <tr>
            <th>S.N</th>
            <th>List Name</th>
            <th>Actions</th>
        </tr>

        <?php

            // connect database
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

            // select database
            $db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());


            // SQL QUery to display all data from database
            $sql = "SELECT * FROM tbl_lists";

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
                        $list_id = $row['list_id'];
                        $list_name = $row['list_name'];

                        ?>
                            <tr>
                                <td><?php echo $sn++; ?> </td>
                                <td><?php echo $list_name; ?> </td>
                                <td><a class="btn-update" href="<?php echo SITEURL; ?>update_list.php?update_list_id=<?php echo $list_id;?>">Update</a> 
                                    <a class="btn-delete" href="<?php echo SITEURL; ?>delete_list.php?list_id=<?php echo $list_id;?>">Delete</a> 
                                 </td>
                            </tr>

                        <?php
                    }
                }
                else
                {
                    ?>
                        <tr>
                            <td colspan="3">No List Added Yet</td>
                        </tr>
    
    
                    <?php
                }

            }

        ?>
    </table>
    </div>
    <!-- Table to display list ends here -->
    
</div>
</body>

</html>