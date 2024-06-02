<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управения базой данных</title>
    <link rel="shortcut icon" href="../img/plane.svg" type="image/x-icon">
</head>
<body>
    <div class="box">
        <a href="cleardb.php">Очистить бд</a>
    </div>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .box{
            display: flex;
            height: 100vh;
            align-items: stretch;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
            margin: 0 auto;
            max-width: max-content;
        }
        a{
            padding: 10px;
            border-radius: 5px;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
            text-decoration: none;
            color: white;
            background: black;
            text-align: center;
        }
    </style>
</body>
</html>