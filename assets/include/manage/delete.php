<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if($_SESSION['username'] != $GLOBALS['username']) {
        header('Location: /');
        die();
    }

    $article = intval($GLOBALS['path'][3]);
    $confirmed = 'confirm' == $GLOBALS['path'][4];

    if($confirmed) {

        $db = new SQLite3($GLOBALS['dbFile']);

        $stmt = $db->prepare('DELETE FROM Posts WHERE id=?');
        $stmt->bindValue(1, $article, SQLITE3_INTEGER);

        $result = $stmt->execute();

        if($db->lastErrorCode() == 0) {
            header('Location: /?modal=Article deleted');
        } else {
            header('Location: /manage/delete/'.$article.'?modal=Failed to delete article');
        }

        $stmt->close();
        $db->close();

        die();
    }


?>

<article class="independent">
    <h1>Delete article</h1>
    <?php

        if($article == 0) {

            echo 'No article-id matching \''. $GLOBALS['path'][3] .'\'';

        } else {

            echo '<h3>Are you sure you want to delete the article with ID '.$article.'?</h3>';
            echo '<div class="middle"><a id="no" class="delete button" href="/post/'.$article.'">No</a><a id="yes" class="delete tomato button" href="/manage/delete/'.$article.'/confirm">Yes, delete</a></div>';

        }
    
    ?>
</article>
