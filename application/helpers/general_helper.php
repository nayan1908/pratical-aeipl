<?php 

function pr($data, $exit = 0){
    echo "<pre>";
    print_r($data);

    if($exit == 1){
        die();
    }
}

?>