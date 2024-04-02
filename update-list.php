<?php
include('config/constants.php');

//get the current value for selected list
if (isset($_GET['list_id'])) {
    //get the list id value
    $list_id = $_GET['list_id'];
    //connect database
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select = mysqli_select_db($conn, DB_NAME);
    //query to get value from database
    $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";
    //exicute query
    $res = mysqli_query($conn, $sql);
    //cheak query exicute or not
    if ($res == true) {
        //get the value fron database
        $row = mysqli_fetch_assoc($res);
        // print_r($row);
        $list_name = $row['list_name'];
        $list_description = $row['list_description'];
    } else {
        //go back to manage list page 
        header('location:' . SITEURL . 'manage-list.php');

    }
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

        <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
        <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage List</a>

        <h3>Update List Page</h3>
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
                    <td>List Name:</td>
                    <td><input type="text" Name="list_name" value="<?php echo $list_name; ?>" required="required"></td>
                <tr>
                    <td>List Description:</td>
                    <td>
                        <textarea name="list_description"><?php echo $list_description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><input class="btn-primary btn-lg" type="submit" name="submit" value="UPDATE"></td>
                </tr>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>




<?php
//cheak weathr submit button is clicked or not
if (isset($_POST['submit'])) {
    // echo "button cli";
    //get the value from form 
    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];
    //connect database
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    $db_select = mysqli_select_db($conn, DB_NAME);
    //query to update list
    $sql = "UPDATE tbl_lists SET
    list_name='$list_name',
    list_description='$list_description'
    WHERE list_id=$list_id
   ";
    //exicute the query
    $res = mysqli_query($conn, $sql);
    //check query exicute or not
    if ($res == true) {
        //update sucess
        $_SESSION['update'] = "List updated sucessfully";
        //redirect to manage list 
        header('location:' . SITEURL . 'manage-list.php');
    } else {
        //fail to update
        $_SESSION['update_fail'] = "Fail to update list";
        //redirect to update list 
        header('location:' . SITEURL . 'update-list.php?list_id=' . $list_id);
    }

}


?>