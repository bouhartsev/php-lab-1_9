<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">

    <title>Bouhartsev, PHP_lab9, Базы данных</title>
</head>
<body>
    <header>
        <img src = "img/Mospolytech_logo.jpg">
        <h1>Базы данных, Бухарцев</h1>

        <nav id="menu">
            <?php
            $links = [
                'Просмотр' => '',
                'Добавление записи' => 'add.php',
                'Редактирование записи' => 'edit.php',
                'Удаление записи' => 'delete.php',
            ];
            $path = ''.basename($_SERVER['REQUEST_URI']);
            foreach($links as $key => $value) {
                echo '<a href="./'.$value.'"';
                if ($path==$value || $path==$value.'index.php' || $path==$value.'index') echo ' class="selected"';
                echo '>'.$key;
                echo '</a>';
            };
            ?>
        </nav>
    </header>
    <main>