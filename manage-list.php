<?php
include('config/constants.php');
?>
<html>

<head>
    <title>Task-Manager with php and my sql</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
    <div class="wrapper">
        <h1>TASK MANAGER</h1>

        <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>

        <h3>Manage list page</h3>

        <p>
            <?php
            //cheak weather the session is created or not
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if (isset($_SESSION['delete_fail'])) {
                echo $_SESSION['delete_fail'];
                unset($_SESSION['delete_fail']);
            }

            ?>
        </p>
        <!-- Table to display list start here -->
        <div class="all-lists">
            <a class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Add List</a>
            <table class="tbl-half">
                <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                <?php
                //connect the data base 
                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
                $db_select = mysqli_select_db($conn, DB_NAME) or die();
                //query to display data from dataase
                $sql = "SELECT * FROM tbl_lists";
                //exicute the query
                $res = mysqli_query($conn, $sql);
                //cheak weather query exicuted sucessfuly or not
                if ($res == true) {
                    //count the row
                    $count_rows = mysqli_num_rows($res);
                    $sn = 1;
                    //cheak data in database or not
                    if ($count_rows > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $list_id = $row['list_id'];
                            $list_name = $row['list_name'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $sn++; ?>
                                </td>
                                <td>
                                    <?php echo $list_name; ?>
                                </td>
                                <td>
                                    <a class="actionn"
                                        href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
                                    <a class="action"
                                        href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                                </td>
                            </tr>
                            <?php

                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="3">No List added yet</td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </table>
        </div>


        <!-- Table to display list end here -->


    </div>
</body>

</html>