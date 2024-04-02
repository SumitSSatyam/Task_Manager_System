<?php
include('config/constants.php');
//get the list id from url
$list_id_url = $_GET['list_id'];
?>
<html>

<head>
    <title>task manager</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
    <div class="wrapper">
        <h1>TASK MANAGER</h1>
        <!-- Menu start here -->
        <div class="menu">
            <a href="<?php echo SITEURL; ?>">Home</a>
            <?php
            //displaying list from database in our menu
            //connect database
            $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
            //select database
            $db_select2 = mysqli_select_db($conn2, DB_NAME);
            //sql query to get the list from database
            $sql2 = "SELECT * FROM tbl_lists";
            //exicute the query
            $res2 = mysqli_query($conn2, $sql2);
            //cheak query exicyte or not
            if ($res2 == true) {
                //display the lists in menu
                while ($row2 = mysqli_fetch_assoc($res2)) {
                    $list_id = $row2['list_id'];
                    $list_name = $row2['list_name'];
                    ?>
                    <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>">
                        <?php echo $list_name; ?>
                    </a>

                    <?php
                }
            }
            ?>

            <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
        </div>
        <!-- Menu end here -->

        <div class="all-task">
            <a class="btn-primary" href="<?php echo SITEURL; ?>add-task.php">Add Task</a>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Task name</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
                <?php
                //connect database
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                //select database
                $db_select = mysqli_select_db($conn, DB_NAME);
                //sql query to display task by list selected
                $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";
                //exicute the query
                $res = mysqli_query($conn, $sql);
                //cheak query exicyte or not
                if ($res == true) {
                    //display he task based on list
                    //count the row
                    $count_rows = mysqli_num_rows($res);
                    if ($count_rows > 0) {
                        //we have task on this list
                        while ($row = mysqli_fetch_assoc($res)) {
                            $task_id = $row['task_id'];
                            $task_name = $row['task_name'];
                            $priority = $row['priority'];
                            $deadline = $row['deadline'];
                            ?>
                            <tr>
                                <td>1.</td>
                                <td>
                                    <?php echo $task_name; ?>
                                </td>
                                <td>
                                    <?php echo $priority; ?>
                                </td>
                                <td>
                                    <?php echo $deadline; ?>
                                </td>
                                <td>
                                    <a class="actionn"
                                        href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>
                                    <a class="action"
                                        href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        //no task on this list
                        ?>
                        <tr>
                            <td colspan="5">No Task Added on this list</td>
                        </tr>

                        <?php
                    }
                }
                ?>

            </table>
        </div>
    </div>
</body>

</html>