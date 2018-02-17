<article class="independent">
    <?php

        if(!empty($path[2])) {

            $sql3 = new SQLite3('./blogger.db');

            $stmt = $sql3->prepare('SELECT * FROM Posts WHERE id=?');
            $stmt->bindValue(SQLITE3_INTEGER, intval($path[2]));
            $result = $stmt->execute();

            while($row = $result->fetchArray()) {
                
                if($row['created'] == $row['modified']) {
                    $dateText = 'Posted ' . date('Y-m-d H:i', substr($row['created'], 0, 10));
                } else {
                    $dateText = 'Posted: '.date('Y-m-d H:i', substr($row['created'], 0, 10)).'<br>Modified: '.date('Y-m-d H:i', substr($row['modified'], 0, 10));
                }

                echo '

                    <h1>'.$row['title'].'</h1>
                    <h2>'.$row['teaser'].'</h2>
                    <p>'.$row['body'].'</p>
                    <span class="tags">'.$row['tags'].'</span>
                    <pre>'.$dateText.'</pre>
                
                ';

            }

            $stmt->close();
            $sql3->close();

        } else {

            echo '
                <h1>Ouch :(</h1>
                <h2>Looks like that post doesn\'t exist.</h2>
            ';

        }
    ?>
</article>

<a href="javascript:window.history.back();" class="back-button">Go back</a>