<?php
    include 'config.php';
    $sid = $_POST['sid'];
    $pid = $_POST['pid'];
    $sql = "select * from `likes` where `sid`='$sid' and `pid`='$pid'";
    $res = mysqli_query($con,$sql);
    $count = mysqli_num_rows($res);
    if($count == 0)
    {
        $sql = "INSERT INTO `likes`(`sid`, `pid`, `result`) VALUES ('$sid','$pid','1')";
        $res = mysqli_query($con,$sql);
        //echo "INSERTED";
        //NEW BY K
        $sql1 = "select * from `likes` where `pid`='$pid'";
        $res1 = mysqli_query($con,$sql1);
        
        $data[0]="INSERTED";
        $data[1]=mysqli_num_rows($res1);
        $data[2]=$pid;
        echo json_encode($data);
    }
    else
    {
        $sql = "DELETE FROM  `likes` WHERE `sid`='$sid' and `pid`='$pid'";
        $res = mysqli_query($con,$sql);
        //echo "DELETED";
        //NEW BY K
        $sql1 = "select * from `likes` where `pid`='$pid'";
        $res1 = mysqli_query($con,$sql1);
        $data[0]="DELETED";
        $data[1]=mysqli_num_rows($res1);
        $data[2]=$pid;
        echo json_encode($data);
    }
?>