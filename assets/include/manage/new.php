<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    require('./config.php');

    if($_SESSION['username'] != $username) {
        header('Location: /');
        die();
    }

    if(!empty($_POST)) {

        $now = time();

        $db = new SQLite3('./blogger.db');
        $stmt = $db->prepare('INSERT INTO Posts (title, teaser, body, tags, author ,modified, created) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bindValue(1, $_POST['title'], SQLITE3_TEXT);
        $stmt->bindValue(2, $_POST['teaser'], SQLITE3_TEXT);
        $stmt->bindValue(3, $_POST['body'], SQLITE3_TEXT);
        $stmt->bindValue(4, $_POST['tags'], SQLITE3_TEXT);
        $stmt->bindValue(5, $author, SQLITE3_TEXT);
        $stmt->bindValue(6, $now, SQLITE3_INTEGER);
        $stmt->bindValue(7, $now, SQLITE3_INTEGER);

        $result = $stmt->execute();

        $stmt->close();
        $db->close();

        if($result) {
            header('Location: /manage/new?modal=Article posted');
            die();
        } else {
            header('Location: /manage/new?modal=Failed to post article');
            die();
        }

    }

    

?>

<article class="independent">
    <form method="post" id="new-post">
        <h1>New blog post</h1>
        <input type="text" name="title" placeholder="Title" required="required" />
        <input type="text" name="teaser" placeholder="Teaser" required="required" />
        <textarea name="body" placeholder="Body" required="required"></textarea>
        <input type="text" name="tags" placeholder="Tags, comma separated"/>
        <p id="form-validation"></p>
        <input type="submit" value="Post" />
    </form>
</article>

<script>

    const title = document.getElementsByName('title')[0];
    const teaser = document.getElementsByName('teaser')[0];
    const body = document.getElementsByName('body')[0];
    const message = document.getElementById('form-validation');

    document.forms['new-post'].addEventListener('submit', (e) => {
        e.preventDefault();

        if(title.value.trim() == '') {
            message.innerHTML = 'Title may not be empty';
        } else if(teaser.value.trim() == '') {
            message.innerHTML = 'Teaser may not be empty';
        } else if(body.value.trim() == '') {
            message.innerHTML = 'Body may not be empty';
        } else {
            e.path[0].submit();
        }



    })



</script>
