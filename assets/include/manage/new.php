<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    require('./config.php');

    if($_SESSION['username'] != $GLOBALS['username']) {
        header('Location: /');
        die();
    }

    if(!empty($_POST)) {

        $now = time();

        $db = new SQLite3($GLOBALS['dbFile']);
        $stmt = $db->prepare('INSERT INTO Posts (title, teaser, body, tags, author ,modified, created) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bindValue(1, htmlspecialchars(trim($_POST['title'])), SQLITE3_TEXT);
        $stmt->bindValue(2, htmlspecialchars(trim($_POST['teaser'])), SQLITE3_TEXT);
        $stmt->bindValue(3, trim($_POST['body']), SQLITE3_TEXT);
        $stmt->bindValue(4, htmlspecialchars(urlencode(trim($_POST['tags']))), SQLITE3_TEXT);
        $stmt->bindValue(5, $GLOBALS['author'], SQLITE3_TEXT);
        $stmt->bindValue(6, $now, SQLITE3_INTEGER);
        $stmt->bindValue(7, $now, SQLITE3_INTEGER);

        $result = $stmt->execute();

        $stmt->close();
        $db->close();

        if($result) {
            header('Location: /manage/new/?modal=Article posted');
            die();
        } else {
            header('Location: /manage/new/?modal=Failed to post article');
            die();
        }

    }

?>

<article class="independent">
    <h2 style="width: 87%">New blog post</h2>
    <form method="post" id="new-post">
        <input type="text" name="title" placeholder="Title" required="required" />
        <input type="text" name="teaser" placeholder="Teaser (optional)" />
        <textarea name="body" placeholder="Body" required="required"></textarea>
        <input type="text" name="tags" placeholder="Tags, comma separated, (optional)" />
        <p id="form-validation"></p>
        <input type="submit" value="Post" />
    </form>
</article>

<script src="/assets/js/form.js"></script>
