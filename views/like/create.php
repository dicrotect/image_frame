<?php
    session_start();
    $picture_id = $_REQUEST['id'];
    $member_id = $_SESSION['id'];
    $likesController= new likesController($db,$plural_resource);
    $likes = $likesController->create($picture_id,$member_id);

    header('Location:../picture/new');

    $sql = mysqli_query($db,$sql) or die (mysqli_error($db));
    $cnt = mysqli_fetch_assoc($sql);
?>
