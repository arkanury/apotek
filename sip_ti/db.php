<?php
    // put your code here
    $link = @mysqli_connect("localhost", "root", "mysql", "sip");
    if (mysqli_connect_errno()) {
        die(mysqli_connect_error());
    }
?>