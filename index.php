<?php
    require 'head.php';
    // require 'menu.php';
    // if( $_GET['p'] == 'viewer' ) // если выбран пункт меню "Просмотр"
    // {
        include 'viewer.php'; // подключаем модуль с библиотекой функций
    //     // если в параметрах не указана текущая страница – выводим самую первую
        if( !isset($_GET['pg']) || $_GET['pg']<0 ) $_GET['pg']=0;
        // если в параметрах не указан тип сортировки или он недопустим
        if(!isset($_GET['sort']) || ($_GET['sort']!='byid' && $_GET['sort']!='fam' && $_GET['sort']!='born'))
            $_GET['sort']='byid'; // устанавливаем сортировку по умолчанию
    //     // формируем контент страницы с помощью функции и выводим его
        echo getFriendsList($_GET['sort'], $_GET['pg']);
    // }
    // // подключаем другие модули с контентом страницы
    // elseif ( isset($_GET['p']) ) include $_GET['p'].'.php';

    require 'foot.php';
?>