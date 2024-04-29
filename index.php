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
        <label value="posts">Посты</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file[]" accept=".json">
        <br>
        <label value="comments">Комментарии</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file[]" accept=".json">
        <br>
        <button type="submit">
            Загрузить
        </button>
       
        <br>
        <a href="pages.php">статьи</a>
    </form>
</body>
</html>