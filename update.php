<?php
    require('config.php');
    $output = shell_exec('git pull '.$GLOBALS['git-url'].' master');
    http_response_code(200);
    print($output);
?>
