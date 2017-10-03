<?php 
    $timeflag = True; 
    while($timeflag) {
        sleep(3);
        if (file_exists("tmp.txt")) {
            $timeflag = False;
            $response = "Success!!!";
            break;
        }
    }
    echo $response;
?>