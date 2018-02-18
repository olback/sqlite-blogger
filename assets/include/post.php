<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if(!empty($path[2])) {

        $db = new SQLite3('./blogger.db');

        $stmt = $db->prepare('SELECT * FROM Posts WHERE id=?');
        $stmt->bindValue(1, intval($path[2]), SQLITE3_INTEGER);
        $result = $stmt->execute();

        $row = $result->fetchArray();

        if($row) {

            $tags = explode(',', $row['tags']);
            $tagsHTML = '';

            foreach($tags as &$tag) {
                $tagsHTML .= '<a href="/search/'.trim($tag).'">'.trim($tag).'</a>, ';
            }

            unset($tag);
            
            if($row['created'] == $row['modified']) {
                $dateText = 'Posted ' . date('Y-m-d H:i', substr($row['created'], 0, 10)).' by '.$row['author'];
            } else {
                $dateText = 'Posted: '.date('Y-m-d H:i', substr($row['created'], 0, 10)).' by '.$row['author'].'<br>Last edited: '.date('Y-m-d H:i', substr($row['modified'], 0, 10));
            }

            echo '
                <article class="independent">
                    <h1>'.$row['title'].'</h1>
                    <h2>'.$row['teaser'].'</h2>
                    <p>'.$row['body'].'</p>
                    <span class="tags">'.$tagsHTML.'</span>
                    <pre>'.$dateText.'</pre>
                </article>
            
            ';

        } else {

            echo '
                <article class="independent">
                    <h1>Ouch :(</h1>
                    <h2>Looks like that post doesn\'t exist.</h2>
                </article>
            ';

        }

        $stmt->close();
        $db->close();

    } else {

        echo '
            <article class="independent">
                <h1>Ouch :(</h1>
                <h2>Looks like that post doesn\'t exist.</h2>
            </article>
        ';

    }
?>

<div style="height:2em">
    <a href="javascript:window.history.back();" class="back-button">Go back</a>
</div>
