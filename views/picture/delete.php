<?php
    $id = $_REQUEST['id'];
    echo $id;
    $picturesController = new picturesController($db, $plural_resource);
    $delete = $picturesController->delete($id);
    header('Location:new');
    exit();
?>
