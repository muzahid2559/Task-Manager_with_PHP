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

    <h3>Add Task Page</h3>

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
            <td>Task Name:</td>
            <td><input type="text" name="task_name" placeholder="Type task name here" required="required" ></td>
        </tr>

        <tr>
            <td>Task Description:</td>
            <td> <textarea name="task_description" id="" cols="" rows="" placeholder="Type task description here"></textarea></td>
        </tr>

        <tr>
            <td>Select List:</td>
            <td>
                <select name="list_id" id="">
                    <?php
                        // connect database
                        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

                         // select database
                         $db_select = mysqli_select_db($conn, DB_NAME);

                        // SQL Query to get the list from table
                        $sql = "SELECT * FROM tbl_lists";

                        // Execute Query
                        $res = mysqli_query($conn,$sql);

                        if($res == true)
                        {
                            // count row
                            $count_rows = mysqli_num_rows($res);


                            if($count_rows>0)
                            {
                                //  value is in array 
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    // getting the data from database
                                    $list_id = $row['list_id'];
                                    $list_name = $row['list_name'];
            
                                    ?>
                                        <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                                   <?php

                                }

                            }
                            
                            else
                            {
                                ?>
                                <option value="0">None</option>
                                <?php
                            }  

                        }
   
                    ?>
                </select>

            </td>
        </tr>

        <tr>
            <td>Priority:</td>
            <td>
                <select name="priority" id="">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>

            </td>
        </tr>

        <tr>
            <td>Deadline:</td>
            <td><input type="date" name="deadline"></td>
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
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        // connect database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die (mysqli_error());

        // SQL Query to Insert data into database
        $sql2 = "INSERT INTO tbl_tasks SET
        task_name = '$task_name',
        task_description = '$task_description' ,
        list_id = $list_id,
        priority = '$priority',
        deadline = '$deadline'

        ";

        // Execute Query and Insert into Database
        $res2 = mysqli_query($conn2,$sql2);
        
        if($res2 == true)
        {
            // Create to Session variable to display message
            $_SESSION['add'] = "<div class='success'>Task Added Successfully !</div>";
           
            // Redirect to Home Page
            header('location:' .SITEURL);

        }
        else
        {
            // Create to Session variable to display message
            $_SESSION['add_fail'] = "<div class='fail'>Failed to  Add Task</div>";
            
            // Redirect to this page
            header('location:' .SITEURL.'add_task.php');
        }

    }
?>