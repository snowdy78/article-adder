<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Статьи</title>

</head>
<body>
    <a href="index.php">Назад</a>
    <form action="search_result.php" method="post">
        <input type="text" name="search_data" minlength=3>
        <button type="submit">Search</button>
    </form>
    <?php
        include_once "Database.php";
        $db = Database::load();
        $result = $db->query('SELECT * FROM `posts`');

        $posts = $db->getAll('posts');
        echo '<div class="posts">';
        foreach( $posts as $post )
        {
            echo "
                <div class='post'> 
                    <h2>Articulus: ".$post['title']."</h2>
                    <p>".$post['body']."</p>
                    <div class='author-mention'>
                        Author: <a href='#'>".$post['user_id']."</a>
                    </div>
                    <h2>Comments</h2>
                
            "; // post block open
            $comments = $db->getCommentsToPost($post['id']);
            echo "<div class='comments'>"; // comments block open
            foreach( $comments as $comment )
            {
                echo "<div class='comment'>
                        <h3>".$comment['name']."</h3> <h4>".$comment['email']."</h4>
                        <p class='execution-commetary'>".$comment['body']."</p>
                    </div>
                ";
                
            }
            echo "</div>"; // comments block closed
            echo "</div>"; // post block closed
            echo "<hr>";
        }
        echo '</div>'
    ?>
</body>
</html>