<?php
include ('config/constants.php');
?>
<html>

<head>
    <title>Task manager</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
    <div class="wrapper">
        <h1>TASK MANAGER</h1>
        <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
        <h3>Add Task Page</h3>
        <p>
            <?php
            //cheak weather the session is created or not
            if (isset ($_SESSION['add_fail'])) {
                echo $_SESSION['add_fail'];
                unset($_SESSION['add_fail']);
            }
            ?>
        </p>


        <form action="" method="POST">
            <table class="tbl-half">
                <tr>
                    <td>Task Name:</td>
                    <td><input type="text" name="task_name" placeholder="Type your task name" required="required"></td>
                </tr>
                <tr>
                    <td>Task Description:</td>
                    <td><textarea name="task_description" placeholder="Type task description"></textarea></td>
                </tr>
                <tr>
                    <td>Select List</td>
                    <td>
                        <select name="list_id">
                            <?php
                            //connect database
                            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                            //select database
                            $db_select = mysqli_select_db($conn, DB_NAME);
                            //sql query to get the list from table
                            $sql = "SELECT * FROM tbl_lists";
                            //exicute query
                            $res = mysqli_query($conn, $sql);

                            //cheak weather query exicuted sucessfuly or not
                            if ($res == true) {
                                //count the row
                                $count_rows = mysqli_num_rows($res);
                                //if there is data in database then display else display none as option
                                if ($count_rows > 0) {
                                    //display all list on dropdown from database
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $list_id = $row['list_id'];
                                        $list_name = $row['list_name'];
                                        ?>
                                        <option value="<?php echo $list_id; ?>">
                                            <?php echo $list_name; ?>
                                        </option>

                                        <?php
                                    }
                                } else {
                                    //display none
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
                    <td>Priority</td>
                    <td>
                        <select name="priority">
                            <option value="High">High</option>
                            <option value="Mediam">Mediam</option>
                            <option value="Low">Low</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Deadline:</td>
                    <td><input type="date" name="deadline"></td>
                </tr>
                <tr>
                    <td><input class="btn-primary btn-lg" type="submit" name="submit" value="SAVE"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>




<?php
// cheak weather the form is submited or not
if (isset ($_POST['submit'])) {
    //echo "form submit";
    //get the value from form and save in variable
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    //connect database
    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select2 = mysqli_select_db($conn2, DB_NAME);
    // query to insert data in database
    $sql2 = "INSERT INTO tbl_tasks SET
    task_name='$task_name',
    task_description='$task_description',
    list_id=$list_id,
    priority='$priority',
    deadline='$deadline'
    
    ";

    //exicute query
    $res2 = mysqli_query($conn2, $sql2);
    //cheak weather the query exicuteted suessfully or not
    if ($res2 == true) {
        //query exicuted and task added sucess
        $_SESSION['add'] = "Task added sucessfully";
        //redirect to home list 
        header('location:' . SITEURL);
    } else {
        //fail to add task
        $_SESSION['add_fail'] = "Fail to add task";
        //redirect to add task page 
        header('location:' . SITEURL . 'add-task.php');
    }
}
?>