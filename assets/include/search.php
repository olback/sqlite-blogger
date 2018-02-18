<h1>Search results for '<?php echo $path[2]; ?>':</h1>

<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    if (!empty($path[2])) {
        
        $db = new SQLite3('./blogger.db');
        
        $query = 'SELECT * FROM Posts WHERE title LIKE ? OR teaser LIKE ? OR body LIKE ? OR tags LIKE ?';
        $stmt = $db->prepare($query);
        for($i = 1; $i < substr_count($query, '?')+1; $i++) {
            $stmt->bindValue($i, '%'.$path[2].'%', SQLITE3_TEXT);
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
            //var_dump($row);
        }

        $stmt->close();
        $db->close();

    }

?>
<div id="no-posts">
    <h2>No posts :(</h2>
</div>
<script>
    const articles = document.getElementsByTagName('article');
    if(articles) {
        for(let article of articles) {
            let id = article.getAttribute('post-id');
            article.onclick = () => {
                window.location = window.location.origin + '/post/' + id;
            }
        }
    } else {
        document.getElementById('no-posts').style.display = 'block;'
    }
</script>
