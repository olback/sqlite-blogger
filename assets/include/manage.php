<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if(!empty($_GET['logout'])) {
        $_SESSION = array();
        session_destroy();
        header('Location: /?modal=Logged out');
        die();
    }

    if($_SESSION['username'] == $username) {

        switch($path[2]) {
            case 'edit':
                require('manage/edit.php');
                break;
    
            case 'new':
                require('manage/new.php');
                break;

            case 'delete':
                require('manage/delete.php');
                break;

            default:
                header('Location: /manage/new');
                break;

        }

    } else {

        require('manage/login.php');

    }

    

?>
