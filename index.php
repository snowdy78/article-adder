<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <form enctype="multipart/form-data" action="load_json_to_db.php" method="POST">
        <select name="load_var" id="load_var">
            <option value="posts">Посты</option>
            <option value="comments">Комментарии</option>
        </select>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file" accept=".json">
        <br>
        <button type="submit">
            Загрузить Посты
        </button>
        <?php 
            if (!empty($_GET['upload_state']))
            {
                if ($_GET['upload_state'] === "0")
                    echo "<a style='color:red;'> Файл не загружен </a>";
                else if ($_GET['upload_state'] === "1")
                    echo "<a style='color:green;'> Файл загружен! </a>";
            }
        ?>
        <br>
        <a href="pages.php">статьи</a>
    </form>
</body>
</html>