
<?php

    session_name('SQLiteBlogger');
    session_start();

    require_once('./config.php');

    if(!empty($_SERVER['PATH_INFO'])) {
        $path = explode('/', $_SERVER['PATH_INFO']);
    }

    if(!empty($_GET['modal'])) {
        $modal = $_GET['modal'];
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="theme-color" content="#333" />
        <meta name="robotos" content="index, follow" />
        <meta name="autor" content="<?php echo $author; ?>"/>
        <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title><?php echo $name; ?></title>
    </head>
    <body>

        <nav>
            <a class="title" href="/"><?php echo $name; ?></a>
            <?php if($_SESSION['username'] == $username) echo '<a href="/manage?logout=true" class="nav-item">Log out</a>'; ?>
            <?php if(!empty($mainPage)) echo '<a href="https://'.$mainPage.'" class="nav-item">'.$mainPage.'</a>'; ?>
        </nav>

        <main>

            <section>
                <?php
                    switch($path[1]) {

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

                        $db = new SQLite3('./blogger.db');

                        $stmt = $db->prepare('SELECT tags FROM Posts');
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
                                echo '<a href="/search/'.$tag.'">'.$tag.'</a>, ';
                            }   
                        } else {
                            echo 'No posts, no tags';
                        }

                        $stmt->close();
                        $db->close();

                    ?>

                </p>
                <footer>
                    <?php echo $author; ?> &copy; <?php echo date('Y'); ?><br>
                    <?php if(!empty($twitter)) echo '<a href="https://twitter.com/'.$twitter.'">@'.$twitter.'</a>'; ?>
                </footer>
            </aside>

        </main>

        <footer class="max-1250px">
            <?php echo $author; ?> &copy; <?php echo date('Y'); ?>
        </footer>

        <div id="modal" style="<?php if(!empty($modal)) echo 'display: block;'; ?>">
            <h1><?php if(!empty($modal)) echo $modal; ?></h1>
            <button id="close-modal">OK</button>
        </div>

        <script>
            const searchBox = document.getElementById('search');
            document.getElementById('search-submit').onclick = () => {
                if(typeof(searchBox.value) == 'string' && searchBox.value !== '') {
                    window.location = window.location.origin + '/search/' + searchBox.value;
                } else {
                    document.getElementById('search-error').style.display = 'inline-block';
                }
            }
            document.getElementById('close-modal').onclick = () => {
                document.getElementById('modal').style.display = 'none';
            }

        </script>

    </body>
</html>
