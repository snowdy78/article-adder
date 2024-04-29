<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Статьи</title>

</head>
<body>
    <a href="pages.php">Назад</a>
    <?php
        include_once "Database.php";
        $db = Database::load();
        if($_POST['search_data'])
		{
			$search_data = $_POST['search_data'];
			$search_results = $db->findPostWithCommentPart($search_data);
			$query = "SELECT * FROM `posts` WHERE id IN (";
			for ($i = 0; $i < sizeof($search_results); $i++) 
			{
				$result = $search_results[$i];
				$query = $query.$result['post_id'];
				if ($i != sizeof($search_results) - 1)
					$query = $query.",";
				echo $result['post_id'].",";
			}
			$query = $query.")";
			$result = $db->query($query);
			$posts = $result->fetch_all(MYSQLI_ASSOC);
			echo '<div class="posts">';
			$i = 0;
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
							<h3>".$comment['name']."</h3> <h4>".$comment['email']."</h4>";
					$search_selection = "<div class='text-selection'>".$search_data."</div>";
					$comment_body = substr_replace($comment['body'], $search_selection, $search_results[$i]['position'], 0);
					echo "<p class='execution-commetary'>".$comment_body."</p>
						</div>
					";
					
				}
				echo "</div>"; // comments block closed
				echo "</div>"; // post block closed
				echo "<hr>";
				$i++;
			}
			echo '</div>';
		}
    ?>
</body>
</html>