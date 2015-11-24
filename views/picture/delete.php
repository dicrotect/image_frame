<?php
    
    $id = $_REQUEST['id'];
    $picturesController = new picturesController($db, $plural_resource);
    $delete = $picturesController->delete($id);
    header('Location:new');
?>
