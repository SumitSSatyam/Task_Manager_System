<?php
include ('config/constants.php');
?>
<html>

<head>
    <title>Task manager with php and mysql</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
</head>

<body>
    <div class="wrapper">
        <h1>TASK MANAGER</h1>
        <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
        <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage list</a>

        <h3>Add list Page</h3>
        <p>
            <?php

            if (isset ($_SESSION['add_fail'])) {
                echo $_SESSION['add_fail'];
                unset($_SESSION['add_fail']);
            }
            ?>
        </p>

        <form action="" method="POST">
            <table class="tbl-half">
                <tr>
                    <td>List Name:</td>
                    <td><input type="text" name="list_name" placeholder="Type list name here" required="required"></td>
                </tr>
                <tr>
                    <td>List Description:</td>
                    <td><textarea name="list_description" cols="20" rows="2"
                            placeholder="Type list descriptio here"></textarea></td>
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

if (isset ($_POST['submit'])) {

    $list_name = $_POST['list_name'];
    $list_description = $_POST['list_description'];


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();

    $db_select = mysqli_select_db($conn, DB_NAME);

    $sql = "INSERT INTO tbl_lists SET
    list_name='$list_name',
    list_description='$list_description'
    ";

    $res = mysqli_query($conn, $sql);

    if ($res == true) {


        $_SESSION['add'] = "List added sucessfully";

        header('location:' . SITEURL . 'manage-list.php');

    } else {

        $_SESSION['add_fail'] = "Fail to add list";
        header('location:' . SITEURL . 'add-list.php');
    }
}

?>