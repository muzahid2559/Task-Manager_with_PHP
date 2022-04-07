<?php

    // include constants.php
    include('config/constants.php');


    if (isset($_GET['update_task_id']))
    {
        
        // Get the list_id value from URL or Get method
        $task_id = $_GET['update_task_id'];
        
        // connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die (mysqli_error());

        // Write the Query to Delete List from Daatabase
        $sql = "SELECT * FROM tbl_tasks WHERE task_id = $task_id";

        // Execute Query and Insert into Database
        $res = mysqli_query($conn,$sql);

        if($res == true)
        {
            // value is in array 
            $row = mysqli_fetch_assoc($res);
            
            // getting the data from database
            $task_name = $row['task_name'];
            $task_description = $row['task_description'];
            $list_id = $row['list_id'];
            $priority = $row['priority'];
            $deadline = $row['deadline'];

        }
        else
        {
            // Redirect to Manage List Page
            header('location:' .SITEURL);
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

    <h3>Update Task Page</h3>

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
<br>

     <!-- form to update task starts here -->
     <form action="" method="POST">

    <table class="tbl-half">
    <tr>
        <td>Task Name:</td>
        <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required" ></td>
    </tr>

    <tr>
        <td>Task Description:</td>
        <td> <textarea name="task_description"> <?php echo $task_description; ?> </textarea></td>
    </tr>

    <tr>
            <td>Select List:</td>
            <td>
                <select name="list_id" id="">

                    <?php
                        // connect database
                        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

                         // select database
                         $db_select2 = mysqli_select_db($conn2, DB_NAME) or die (mysqli_error());

                        // SQL Query to get the list from table
                        $sql2 = "SELECT * FROM tbl_lists";

                        // Execute Query
                        $res2 = mysqli_query($conn2, $sql2);

                        if($res2 == true)
                        {
                            // count row
                            $count_rows2 = mysqli_num_rows($res2);


                            if($count_rows2>0)
                            {
                                //  value is in array 
                                while($row2 = mysqli_fetch_assoc($res2))
                                {
                                    // getting the data from database
                                    $list_id_db = $row2['list_id'];
                                    $list_name = $row2['list_name'];
            
                                    ?>
                                        <option <?php if($list_id_db==$list_id){echo "selected='selected'";} ?> value="<?php echo $list_id_db; ?>"><?php echo $list_name; ?></option>
                                   <?php

                                }
 
                            }
                            
                            else
                            {
                                ?>
                                <option <?php if($list_id = 0){echo "selected='selected'" ;} ?> value="0">None</option>
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
                <select  name="priority" id="">
                <option <?php if($priority == "high") {echo "selected='selected'"; }?> value="high">High</option>
                <option <?php if($priority == "medium") {echo "selected='selected'"; }?> value="medium">Medium</option>
                <option <?php if($priority == "low") {echo "selected='selected'" ;}?> value="low">Low</option>
                </select>
            </td>
        </tr>

    <tr>
        <td>Deadline:</td>
        <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"></td>
    </tr>

    <tr>
        <td> <input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE"> </td>
    </tr>
    </table>

    </form>
    <!-- form to update task ends here -->
    
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
        $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die (mysqli_error());

        // select database
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die (mysqli_error());

        // SQL Query to Insert data into database
        $sql3 = "UPDATE tbl_tasks SET
        task_name = '$task_name',
        task_description = '$task_description' ,
        list_id = '$list_id',
        priority = '$priority',
        deadline = '$deadline'
        WHERE task_id = $task_id
        ";

        // Execute Query and Insert into Database
        $res3 = mysqli_query($conn3, $sql3);
        
        if($res3 == true)
        {
            // Create to Session variable to display message
            $_SESSION['update'] = "<div class='success'>Task Updated Successfully !</div>";
           
            // Redirect to Home Page
            header('location:' .SITEURL);

        }
        else
        {
            // Create to Session variable to display message
            $_SESSION['update_fail'] = "<div class='fail'>Failed to  Updated Task</div>";
            
            // Redirect to this Page
            header('location:' .SITEURL.'update_task.php?task_id='.$task_id);
        }

    }
?>
