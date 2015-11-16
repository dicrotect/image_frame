<?php
    
    //リンクを貼り付けるための関数を作成
    function link_to($path,$str){
        $a_tag = sprintf('<a href="%s">%s</a>',
            //移動させたいurlのpath
            $path,
            //リンクの文字
            $str
        );

        return $a_tag;
    }
 ?>    
