<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    /*
     *  RENAME ME TO 'config.php'!
     */

    $GLOBALS['author'] = ''; // Will be shown before the © sign.
    $GLOBALS['site-name'] = ''; // Title and nav

    // Don't have a Twitter account, GitHub account or a website you want to link to? Just leave them blank.
    $GLOBALS['website'] = '';
    $GLOBALS['twitter'] = '';
    $GLOBALS['github'] = '';

    $GLOBALS['username'] = 'admin'; // Default username is 'admin'. Please change!
    $GLOBALS['password'] = 'x279e'; // Default password is 'x279e. Please change!

    // Path to db file - Don't change unless you know what you're doing!
    $GLOBALS['dbFile'] = './blogger.db';

    // Git Url to pull updates from.
    $GLOBALS['git-url'] = 'https://github.com/olback/sqlite-blogger.git';

?>
