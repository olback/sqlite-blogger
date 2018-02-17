<?php

    function loadData($amount) {

        $sql3 = new SQLite3('./blogger.db');

        $stmt = $sql3->prepare('SELECT * FROM Posts');
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
        $sql3->close();

    }

    $path = $_SERVER['PATH_INFO'];



    loadData(null);

?>
<script src="/assets/js/main.js"></script>
