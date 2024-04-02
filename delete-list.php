<?php
include('config/constants.php');
//cheak weather list id is assigned or not
if (isset($_GET['list_id'])) {
    //delete the list from daabase
    //get the list id fron url
    $list_id = $_GET['list_id'];
    //connet the database 
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
    //select database
    $db_select = mysqli_select_db($conn, DB_NAME) or die();
    //query to delete data from database
    $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";
    //exicute the query
    $res = mysqli_query($conn, $sql);
    //cheak weather the query exicuted sucessfully or not
    if ($res == true) {
        //query exicute
        $_SESSION['delete'] = "List delete sucessfully";
        //redirect to manage list page
        header('location:' . SITEURL . 'manage-list.php');

    } else {
        //fail to delete list
        $_SESSION['delete_fail'] = "Fail to delete List";
        //redirect to manage list page
        header('location:' . SITEURL . 'manage-list.php');

    }
} else {
    //redirect to manage list page 
    header('location:' . SITEURL . 'manage-list.php');
}


?>