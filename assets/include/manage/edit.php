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

    if(!empty($_POST) && $article != 0) {

        $now = time();

        if(!empty(trim($_POST['teaser']))) {
            $teaser = $_POST['teaser'];
        } else {
            $teaser = substr($_POST['body'], 0, 100).'...';
        }
        
        $db = new SQLite3($GLOBALS['dbFile']);
        $stmt = $db->prepare('UPDATE Posts SET title=?, teaser=?, body=?, tags=?, modified=? WHERE id=?');
        $stmt->bindValue(1, htmlspecialchars(trim($_POST['title'])), SQLITE3_TEXT);
        $stmt->bindValue(2, htmlspecialchars(trim($_POST['teaser'])), SQLITE3_TEXT);
        $stmt->bindValue(3, trim($_POST['body']), SQLITE3_TEXT);
        $stmt->bindValue(4, htmlspecialchars(trim($_POST['tags'])), SQLITE3_TEXT);
        $stmt->bindValue(5, $now, SQLITE3_INTEGER);
        $stmt->bindValue(6, $article, SQLITE3_INTEGER);

        $stmt->execute();

        if($db->lastErrorCode() != 0) {
            header('Location: /manage/edit/'.$article.'?modal=Error removing article from db');
        } else {
            header('Location: /post/'.$article.'?modal=Article updated');
        }

        $stmt->close();
        $db->close();

    }

    if($article == 0) {

        echo '<h1>No article found with id '.$GLOBALS['path'][3].'</h1>';

    } else {

        $db = new SQLite3($GLOBALS['dbFile']);
        $stmt = $db->prepare('SELECT * FROM Posts WHERE id=?');
        $stmt->bindValue(1, $article, SQLITE3_INTEGER);
        $result = $stmt->execute();

        $row = $result->fetchArray();

        $stmt->close();
        $db->close();

        if(!empty($row)) {

            echo '
                <article class="independent">
                    <h1 style="width: 87%">Edit article</h1>
                    <form method="post" id="new-post">
                        <input type="text" name="title" placeholder="Title" required="required" value="'.$row['title'].'" />
                        <input type="text" name="teaser" placeholder="Teaser (optional)" value="'.$row['teaser'].'" />
                        <textarea name="body" placeholder="Body" required="required">'.$row['body'].'</textarea>
                        <input type="text" name="tags" placeholder="Tags, comma separated, (optional)" value="'.$row['tags'].'" />
                        <p id="form-validation"></p>
                        <div class="edit-buttons">
                            <a class="button tomato" href="/manage/delete/'.$article.'">Delete article</a>
                            <button type="submit">Update article</button>
                        </div>
                    </form>
                </article>
                <script src="/assets/js/form.js"></script>
            ';

        } else {
            echo '<h1>No article found with id '.$GLOBALS['path'][3].'</h1>';
        }

    }

?>
