<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>シンプルフレームワーク</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/js/bootstrap.js">
  <link rel="stylesheet" href="../assets/css/form.css">
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="../assets/css/timeline.css">
  <link rel="stylesheet" href="../assets/css/tab.css">
  <link rel="stylesheet" href="../assets/css/icon.css">
  <link rel="stylesheet" href="../assets/css/show.css">
  <link rel="stylesheet" href="../assets/css/check.css">
  <link rel="stylesheet" href="../assets/css/comment_timeline.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/js/form.js">
  <link rel="stylesheet" href="../assets/js/login.js">
  <link rel="stylesheet" href="../assets/js/timeline.js">
  <script type="text/javascript">
  function disp(){
    // 「OK」時の処理開始 ＋ 確認ダイアログの表示
    if(window.confirm('削除してよろしいですか？')){
      location.href = "<?php echo sprintf('../picture/delete?id=%d',$_REQUEST["id"]);?>"; 
    }
  
    // 「キャンセル」時の処理開始
    else{

      window.alert('キャンセルされました'); // 警告ダイアログを表示

    }
    // 「キャンセル」時の処理終了
  }
  // -->
  </script>

</head>
<body>
  <?php
    include('./views/'.$resource.'/'.$action.'.php');
  ?>
  
  
</body>
</html>
