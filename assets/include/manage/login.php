<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    $_SESSION['username'] = NULL;
    
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        if($_POST['username'] == $GLOBALS['username'] && $_POST['password'] == $GLOBALS['password']) {
            $_SESSION['username'] = $GLOBALS['username'];
            header('Location: /manage/new');
            die();
        } else {
            $error = '<p class="login-error">Username or password incorrect!</p>';
            $_SESSION = array();
            session_destroy();
        }
    }

?>

<form method="post">
    <h1>Log in</h1>
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="submit" value="Log in" />
</form>

<?php

    if(!empty($error)) echo $error;

?>
