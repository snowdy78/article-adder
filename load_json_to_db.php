<?php
    include_once "Database.php";
    function parse_jsonfile($file_name) 
    {
        $file_content = file_get_contents($file_name);
        return json_decode($file_content, true);
    }
    $upload_dir = 'upload/';
    function upload_file($post_file_name, $upload_file_name)
    {
        global $upload_dir; 
        $upload_file = $upload_dir.basename($upload_file_name);
        print "<pre>";
        if ($_FILES[$post_file_name]["error"] == UPLOAD_ERR_OK)
        {
            move_uploaded_file($_FILES[$post_file_name]['tmp_name'], $upload_file);
            print_r($_FILES[$post_file_name]);
            return true;
        }
        print "</pre>";
        return false;
    }
    $load_var = $_POST['load_var'];
    if (!empty($load_var))
    {
        if (upload_file('file', "$load_var.json"))
        {
            $json = parse_jsonfile("upload/$load_var.json");
            $db = Database::load();
            if ($load_var === "posts")
            {
                $db->loadPosts($json);
            }
            else if ($load_var === "comments")
            {
                $db->loadComments($json);
            }
            header("location:/index.php?upload_state=1");
            exit;
        }
        header("location:/index.php?upload_state=0");
    }
?>