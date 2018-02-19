<h1>Search results for '<?php echo $GLOBALS['path'][2]; ?>':</h1>

<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if (!empty($GLOBALS['path'][2])) {
        
        $db = new SQLite3($GLOBALS['dbFile']);
        
        $query = 'SELECT * FROM Posts WHERE title LIKE ? OR teaser LIKE ? OR body LIKE ? OR tags LIKE ?';
        $stmt = $db->prepare($query);
        for($i = 1; $i < substr_count($query, '?')+1; $i++) {
            $stmt->bindValue($i, '%'.$GLOBALS['path'][2].'%', SQLITE3_TEXT);
        }
        $result = $stmt->execute();

        while($row = $result->fetchArray()) {

            echo '
                <article post-id="'.$row['id'].'">
                    <h1>'.$row['title'].'</h1>
                    <p>'.$row['teaser'].'</p>
                    <span class="tags">'.$row['tags'].'</span>
                    <pre>Posted: '.date('Y-m-d H:i', substr($row['created'], 0, 10)).'</pre>
                </article>
            ';
        
        }

        $stmt->close();
        $db->close();

    }

?>
<div id="no-posts">
    <h2>No posts :(</h2>
</div>
<script src="/assets/js/list.min.js"></script>
