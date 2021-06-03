<?php
    require 'head.php';

    include 'viewer.php'; // подключаем модуль с библиотекой функций
    // если в параметрах не указан тип сортировки или он недопустим
    if(!isset($_SESSION['sort']) || ($_SESSION['sort']!='byid' && $_SESSION['sort']!='fam' && $_SESSION['sort']!='born'))
            $_SESSION['sort']='byid'; // устанавливаем сортировку по умолчанию
    // формируем контент страницы с помощью функции и выводим его
    session_from_get();
    echo getTable($_SESSION['sort'], $_SESSION['pg']);

    require 'foot.php';
?>