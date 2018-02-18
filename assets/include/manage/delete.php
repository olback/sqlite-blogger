<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if($_SESSION['username'] != $username) {
        header('Location: /');
        die();
    }

?>


<h1>Delete article</h1>
