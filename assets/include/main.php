<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    function loadData($amount) {

        $db = new SQLite3($GLOBALS['dbFile']);

        $stmt = $db->prepare('SELECT * FROM Posts ORDER BY created DESC');
        $result = $stmt->execute();

        while($row = $result->fetchArray()) {

            echo '
                <article data-id="'.$row['id'].'">
                    <h2>'.$row['title'].'</h2>
                    <p>'.$row['teaser'].'</p>
                    <span class="tags">'.str_replace('+', ' ', $row['tags']).'</span>
                    <pre>Posted: '.date('Y-m-d H:i', substr($row['created'], 0, 10)).' by '.$row['author'].'</pre>
                </article>
            ';
        
        }

        $stmt->close();
        $db->close();

    }

    loadData(null);

?>
<div id="no-posts">
    <h1>No posts :(</h1>
    <?php if(!empty($GLOBALS['twitter'])) echo 'Tell <a href="https://twitter.com/'.$GLOBALS['twitter'].'">@'.$GLOBALS['twitter'].'</a> to post someting interesting!'; ?>
</div>
<script src="/assets/js/list.min.js"></script>
