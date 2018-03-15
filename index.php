
<?php

    session_name('SQLiteBlogger');
    session_start();

    $config_file = './config.php';

    if(!file_exists($config_file)) {
        echo 'Please rename <code>sample-config.php</code> to <code>config.php</code>!';
        die();
    }

    require($config_file);

    if(!empty($_SERVER['PATH_INFO'])) {
        $GLOBALS['path'] = explode('/', $_SERVER['PATH_INFO']);
    }

    if(!empty($_GET['modal'])) {
        $modal = $_GET['modal'];
    }

?>

<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['lang']; ?>">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="theme-color" content="#333" />
        <meta name="robotos" content="index, follow" />
        <meta name="autor" content="<?php echo $GLOBALS['author']; ?>" />
        <meta name="owner" content="<?php echo $GLOBALS['author']; ?>" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="/assets/css/main.min.css" />
        <script src="/assets/js/main.min.js"></script>
        <title><?php echo $GLOBALS['site-name']; ?></title>
    </head>
    <body>

        <nav>
            <a class="title" href="/"><?php echo $GLOBALS['site-name']; ?></a>
            <?php if($_SESSION['username'] == $GLOBALS['username']) echo '<a href="/manage/logout" class="nav-item">Log out</a>'; ?>
        </nav>

        <main>

            <section>
                <?php
                    switch($GLOBALS['path'][1]) {

                        case 'new':
                            header('Location: /manage/new');
                            break;

                        case 'manage':
                            require(__DIR__.'/assets/include/manage.php');
                            break;

                        case 'post':
                            require(__DIR__.'/assets/include/post.php');
                            break;

                        case 'search':
                            require(__DIR__.'/assets/include/search.php');
                            break;

                        default:
                            require(__DIR__.'/assets/include/main.php');
                    
                    }
                ?>
            </section>

            <aside>
                <h2>Search</h2>
                <input type="search" id="search" placeholder="title, teaser, body, tags..." />
                <p id="search-error">Search field may not be empty!</p>
                <button type="submit" id="search-submit">Search</button>

                <h2 class="tags-title">Tags</h2>
                <p class="tags">
                    
                    <?php

                        $tags = [];

                        $db = new SQLite3($GLOBALS['dbFile']);

                        $stmt = $db->prepare('SELECT tags FROM Posts ORDER BY id DESC');
                        $result = $stmt->execute();

                        while($row = $result->fetchArray()) {
                            
                            $newTags = array_filter(explode(',', $row['tags']));

                            foreach($newTags as &$newTag) {
                                if(!in_array($newTag, $tags)) {
                                    array_push($tags, trim($newTag));
                                }
                            }

                            unset($newTag);
                            
                        }

                        if(count($tags) > 0) {
                            foreach($tags as $tag) {
                                echo '<a href="/search/'.$tag.'">'.str_replace('+', ' ', $tag).'</a>, ';
                            }   
                        } else {
                            echo 'No articles with tags';
                        }

                        $stmt->close();
                        $db->close();

                    ?>

                </p>
                <footer>
                    <?php
                        echo $GLOBALS['author']; echo ' &copy; '.date('Y');
                        if(!empty($GLOBALS['website'])) echo '<br /><a href="https://'.$GLOBALS['website'].'">'.$GLOBALS['website'].'</a>';
                        if(!empty($GLOBALS['twitter'])) echo '<br /> Tweet at me? <a href="https://twitter.com/'.$GLOBALS['twitter'].'">@'.$GLOBALS['twitter'].'</a>';
                        if(!empty($GLOBALS['github'])) echo '<br/>'; if(!empty($GLOBALS['github'])) echo '<a href="https://github.com/'.$GLOBALS['github'].'">Follow me on GitHub</a>';
                    ?>
                </footer>
            </aside>

        </main>

        <footer class="max-1250px">
            <?php
                echo $GLOBALS['author']; echo ' &copy; '.date('Y').'<br />';
                if(!empty($GLOBALS['website'])) echo '<a href="https://'.$GLOBALS['website'].'">'.$GLOBALS['website'].'</a> ';
                if(!empty($GLOBALS['twitter'])) echo '<a href="https://twitter.com/'.$GLOBALS['twitter'].'">@'.$GLOBALS['twitter'].'</a>';
                if(!empty($GLOBALS['twitter']) || !empty($GLOBALS['website'])) echo '<br />';
                if(!empty($GLOBALS['github'])) echo '<a href="https://github.com/'.$GLOBALS['github'].'">Follow me on GitHub</a>';
            ?>
        </footer>

        <div id="modal" style="<?php if(!empty($modal)) echo 'display: block;'; ?>">
            <h2><?php if(!empty($modal)) echo $modal; ?>.</h2>
            <button id="close-modal">OK</button>
        </div>

    </body>
</html>
