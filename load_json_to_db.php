<?php
    include_once "Database.php";
    function parse_jsonfile($file_name) 
    {
        $file_content = file_get_contents($file_name);
        return json_decode($file_content, true);
    }
    $upload_dir = 'upload/';
    function load_file($post_file_name, $upload_file_name, $id = 0)
    {
        global $upload_dir; 
        $upload_file = $upload_dir.basename($upload_file_name);
        
        if ($_FILES[$post_file_name]["error"][$id] == UPLOAD_ERR_OK)
        {
            move_uploaded_file($_FILES[$post_file_name]['tmp_name'][$id], $upload_file);
            return true;
        }
        return false;
    }
    if (load_file('file', "posts.json", 0))
    {
        $posts_json = parse_jsonfile("upload/posts.json");
        $db = Database::load();
        $db->loadPosts($posts_json);
        echo "Постов загружено - ";
        echo sizeof($posts_json)."<br>";
    }
    else 
    {
        echo "Посты не загружены<br>";
        exit;
    }
    if (load_file("file", "comments.json", 1))
    {
        $comments_json = parse_jsonfile("upload/comments.json");
        $db = Database::load();
        $db->loadComments($comments_json);
        echo "комментариев загружено - ";
        echo sizeof($comments_json)."<br>";
    }
    else 
    {
        echo "Комментарии не загружены<br>";
    }

?>