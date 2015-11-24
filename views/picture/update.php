<?php
    session_start();
    if (!empty($_POST)) {
          $id = $_SESSION['picture_id'];
          $comment = $_POST['edit_name'];
          $picturesController = new picturesController($db,$plural_resource);
          $coment_update = $picturesController->update($comment,$id);

          header(sprintf('Location:show?id=%d',$_SESSION['picture_id']));
      }

?>
