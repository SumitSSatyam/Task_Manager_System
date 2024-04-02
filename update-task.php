<?php
include('config/constants.php');
// cheak the task id in url
if (isset($_GET['task_id'])) {
    //get the value from database 
    $task_id = $_GET['task_id'];
    //connect database
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select = mysqli_select_db($conn, DB_NAME);
    //query to get value from database
    $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";
    //exicute query
    $res = mysqli_query($conn, $sql);
    //cheak query exicute or not
    if ($res == true) {
        //get the value fron database
        $row = mysqli_fetch_assoc($res);
        //get the indivisual value
        $task_name = $row['task_name'];
        $task_description = $row['task_description'];
        $list_id = $row['list_id'];
        $priority = $row['priority'];
        $deadline = $row['deadline'];
    }
} else {
    //redirect to home page 
    header('location:' . SITEURL);
}
?>
<html>

<head>
    <title>Task manager</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
<div class="wrapper">
    <h1>TASK MANAGER</h1>
    <p>
        <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
    </p>
    <h3>Update Task Page</h3>
    <p>
        <?php
        //cheak weather the session is set or not
        if (isset($_SESSION['update_fail'])) {
            echo $_SESSION['update_fail'];
            unset($_SESSION['update_fail']);
        }
        ?>
    </p>

    <form action="" method="POST">
        <table class="tbl-half">
            <tr>
                <td>Task Name:</td>
                <td><input type="text" Name="task_name" value="<?php echo $task_name; ?>"></td>

            </tr>
            <tr>
                <td>Task Description</td>
                <td>
                    <textarea name="task_description">
                        <?php echo $task_description; ?>
                     </textarea>
                </td>
            </tr>
            <tr>
                <td>Select List:</td>
                <td>
                    <select name="list_id">
                        <?php
                        //connect database
                        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                        //select database
                        $db_select2 = mysqli_select_db($conn2, DB_NAME);
                        //query to get value from database
                        $sql2 = "SELECT * FROM tbl_lists ";
                        //exicute query
                        $res2 = mysqli_query($conn2, $sql2);
                        //cheak query exicute or not
                        if ($res2 == true) {
                            //display the list
                            //count the row
                            $count_rows2 = mysqli_num_rows($res2);
                            //cheak weather list is added or not
                            if ($count_rows2 > 0) {
                                //list are added
                                //get the value fron database
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                    //get indivisual value
                                    $list_id_db = $row2['list_id'];
                                    $list_name = $row2['list_name'];
                                    ?>
                                    <option <?php if ($list_id_db == $list_id) {
                                        echo "selected='selected'";
                                    } ?>
                                        value="<?php $list_id_db; ?>"><?php echo $list_name; ?></option>
                                    <?php
                                }

                            } else {
                                //No list added
                                //display none
                                ?>
                                <option <?php if ($list_id = 0) {
                                    echo "selected='selected'";
                                } ?>value="0">None</option>
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
                    <select name="priority">
                        <option <?php if ($priority == "High") {
                            echo "selected='selected'";
                        } ?>value="High">High</option>
                        <option <?php if ($priority == "Mediam") {
                            echo "selected='selected'";
                        } ?>value="Mediam">Mediam
                        </option>
                        <option <?php if ($priority == "Low") {
                            echo "selected='selected'";
                        } ?>value="Low">Low</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Deadline:</td>
                <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"></td>
            </tr>
            <tr>
                <td><input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE"></td>
            </tr>
        </table>
    </form>
</div>
</body>

</html>

<?php
//cheak weathr submit button is clicked or not
if (isset($_POST['submit'])) {
    //echo "button clicked";
    //get the value from form 
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $list_id = $_POST['list_id'];
    $priority = $_POST['priority'];
    $deadline = $_POST['deadline'];

    //connect database
    $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select3 = mysqli_select_db($conn3, DB_NAME);
    //create sql query to update task
    $sql3 = "UPDATE tbl_tasks SET
     task_name='$task_name',
    task_description='$task_description',
    list_id='$list_id',
    priority='$priority',
    deadline='$deadline'
    WHERE task_id=$task_id
    ";
    //exicute the query
    $res3 = mysqli_query($conn3, $sql3);
    //check query exicute or not
    if ($res3 == true) {
        //query exicute and task update
        //update sucess
        $_SESSION['update'] = "Task updated sucessfully";
        //redirect to home 
        header('location:' . SITEURL);
    } else {
        //Fail to update task
        $_SESSION['update_fail'] = "Fail to update Task";
        //redirect to same page 
        header('location:' . SITEURL . 'update-task.php?task_id=' . $list_id);
    }
}

?>