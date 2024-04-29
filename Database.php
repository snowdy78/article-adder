<?php
    class Database extends mysqli 
    {
        public static function load()
        {
            return new Database('localhost', 'root', '', 'test', 3306);
        }
        public function __construct($servername, $username, $password, $dbname, $port)
        {
            mysqli::__construct($servername, $username, $password, $dbname, $port);
        }
        public function loadPosts(array $posts)
        {
            $loaded = 0;
            for ($i = 0; $i < count($posts); $i++ )
            {
                $title = $posts[$i]['title'];
                $user_id = $posts[$i]['userId'];
                $body = $posts[$i]['body'];
                $id = $posts[$i]['id'];
                if ($this->getFrom('posts', $id) !== null)
                {
                    // update
                    $query = "UPDATE `posts` SET body=$body, user_id=$user_id, title=$title WHERE id=$id";
                }
                else 
                {
                    // insert
                    
                    $query = "INSERT INTO `posts` VALUES ($id, $user_id, '$title', '$body')";
                }
                $result = $this->query($query);
                if (empty($result))
                {   
                    print "post ($id) is failed to load";
                }
                else
                    $loaded++;
            }
            print "Done!";
            return $loaded;
        }
        public function loadComments(array $comments)
        {
            $loaded = 0;
            for ($i = 0; $i < count($comments); $i++ )
            {
                $name = $comments[$i]['name'];
                $email = $comments[$i]['email'];
                $post_id = $comments[$i]['postId'];
                $body = $comments[$i]['body'];
                $id = $comments[$i]['id'];
                if ($this->getFrom('comments', $id) !== null)
                {
                    // update
                    $query = "UPDATE `comments` SET post_id=$post_id, body=$body, email=$email, cname=$name WHERE id=$id";
                }
                else 
                {
                    // insert
                    $query = "INSERT INTO `comments` VALUES ($id, $post_id, '$email', '$name', '$body')";
                }
                $result = $this->query($query);
                if (empty($result))
                {   
                    print "comment ($id) ($email) is failed to load\n";
                } 
                else 
                    $loaded++;
                
            }
            print "Done!\n";
            return $loaded;
        }
        
        public function getFrom($table_name, $id)
        {
            $result = $this->query("SELECT * FROM `$table_name` WHERE id=$id");
            if ($result)
            {
                $data = $result->fetch_assoc();
                if ($data)
                    return $data;
            }
            return null;
        }
        public function getAll($table_name)
        {
            $result = $this->query("SELECT * FROM `$table_name`");
            if ($result)
            {
                $data = $result->fetch_all(MYSQLI_ASSOC);
                if ($data)
                    return $data;
            }
            return null;
        }
        // TODO: make search
        public function getCommentsToPost($post_id)
        {
            $result = $this->query("SELECT * FROM `comments` WHERE post_id=$post_id");
            if ($result)
            {
                $comments = $result->fetch_all(MYSQLI_ASSOC);
                return $comments;
            } 
        }
        public function findPostWithCommentPart(string $part)
        {
            $posts = array();
            $comments = $this->getAll('comments');
            foreach( $comments as $comment )
            {
                $body = $comment['body'];
                $id = $comment['id'];
                $index = strpos($body, $part);
                if ($index)
                {
                    $post_id = $comment['post_id'];
                    array_push($posts, array('post_id' => $post_id, 'comment_id' => $id, 'position' => $index));
                }
            }
            return $posts; 
        }
    }
?>