<?php
include('config/constants.php');
//cheak weather task id is assigned or not
if (isset($_GET['task_id'])) {
    //delete the task from database
    //get the list id fron url
    $task_id = $_GET['task_id'];
    //connet the database 
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select = mysqli_select_db($conn, DB_NAME) or die();
    //query to delete task from database
    $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";
    //exicute the query
    $res = mysqli_query($conn, $sql);
    //cheak weather the query exicuted sucessfully or not
    if ($res == true) {
        //query exicute
        $_SESSION['delete'] = "Task delete sucessfully";
        //redirect to home list page
        header('location:' . SITEURL);
    } else {
        //fail to delete task
        $_SESSION['delete_fail'] = "Fail to delete Task";
        //redirect to home page
        header('location:' . SITEURL);
    }
} else {
    //Redirect to home 
    header('location:' . SITEURL);
}

?>