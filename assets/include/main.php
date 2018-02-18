<?php

    if(count(get_included_files()) == 1){
        header('Location: /');
        die();
    }

    function loadData($amount) {

        $db = new SQLite3('./blogger.db');

        $stmt = $db->prepare('SELECT * FROM Posts');
        $result = $stmt->execute();

        while($row = $result->fetchArray()) {

            echo '
                <article post-id="'.$row['id'].'">
                    <h1>'.$row['title'].'</h1>
                    <p>'.$row['teaser'].'</p>
                    <span class="tags">'.$row['tags'].'</span>
                    <pre>Posted: '.date('Y-m-d H:i', substr($row['created'], 0, 10)).' by '.$row['author'].'</pre>
                </article>
            ';
            //var_dump($row);
        }

        $stmt->close();
        $db->close();

    }

    loadData(null);

?>
<div id="no-posts">
    <h1>No posts :(</h1>
    <?php if(!empty($twitter)) echo 'Tell <a href="https://twitter.com/'.$twitter.'">@'.$twitter.'</a> to post someting interesting!'; ?>
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
