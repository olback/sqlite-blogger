<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    $author = 'olback';
    $name = 'SQLite Blogger';

    // Don't have a Twitter account or a website you want to link to? Just leave them blank
    $twitter = '';
    $mainPage = '';

    $username = 'admin';
    $password = 'x279e'; // Default password is 'x279e. Please change!

?>