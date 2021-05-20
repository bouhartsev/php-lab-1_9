<?php
// если были переданы данные для добавления в БД
if( isset($_POST['button']) && $_POST['button']== 'Добавить запись')
{
    require 'secret.php';
    $mysqli = mysqli_connect($DB_host, $DB_login, $DB_password, $DB_name);

    if( mysqli_connect_errno() ) // проверяем корректность подключения
        echo 'Ошибка подключения к БД: '.mysqli_connect_error();
    
    // формируем и выполняем SQL-запрос для добавления записи
    $query_add = 'INSERT INTO '.$DB_table_name.' (';
    foreach($DB_fields as $key => $value) {
        $query_add .= $value;
        if ($key!='comment') $query_add .= ', ';
    }
    $query_add .= ') VALUES (';
    foreach($DB_fields as $key => $value) {
        $query_add .= '"'.$_POST[$key].'"';
        if ($key!='comment') $query_add .= ', ';
    }
    $query_add .= ')';

    echo $query_add;

    $sql_res=mysqli_query($mysqli, $query_add);
    // если при выполнении запроса произошла ошибка – выводим сообщение
    if( mysqli_errno($mysqli) )
        echo '<div class="error">Запись не добавлена</div>';
    else // если все прошло нормально – выводим сообщение
        echo '<div class="ok">Запись добавлена</div>';
}

require 'add.html';
?>