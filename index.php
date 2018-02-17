
<?php
    
    $path = explode('/', $_SERVER['PATH_INFO']);


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <title>SQLite3 Blogger</title>
    </head>
    <body>

        <nav>
            <a class="title" href="/">SQLite Blogger</a>
        </nav>

        <main>

            <section>
                <?php
                    switch($path[1]) {

                        case 'new':
                            require(__DIR__.'/assets/include/new.php');
                            break;

                        case 'post':
                            require(__DIR__.'/assets/include/post.php');
                            break;

                        default:
                            require(__DIR__.'/assets/include/main.php');
                    
                    }
                ?>
            </section>

            <aside>
                <h2>Search</h2>
                <input type="search" name="search" id="search" />
            </aside>

        </main>

    </body>
</html>