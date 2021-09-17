<?php
    function getTable($sort_type, $page)
    {
        echo '<div class="submenu">'; // выводим подменю
        echo '<a href="?sort=byid"'; // первый пункт подменю
        if( $sort_type == 'byid' )
        echo ' class="selected"';
        echo '>По-умолчанию</a>';
        echo '<a href="?sort=fam"'; // второй пункт подменю
        if( $sort_type == 'fam' )
        echo ' class="selected"';
        echo '>По фамилии</a>';
        echo '<a href="?sort=born"'; // третий пункт подменю
        if( $sort_type == 'born' )
        echo ' class="selected"';
        echo '>По дате рождения</a>';
        echo '</div>'; // конец подменю

        require 'secret.php';
        $mysqli = mysqli_connect($DB_host, $DB_login, $DB_password, $DB_name);
        
        if( mysqli_connect_errno() ) // проверяем корректность подключения
            return 'Ошибка подключения к БД: '.mysqli_connect_error();
        
        $mysqli->set_charset("utf8mb4");
        
        // формируем и выполняем SQL-запрос для определения числа записей
        $sql_res=mysqli_query($mysqli, 'SELECT COUNT(*) FROM '.$DB_table_name);
        // проверяем корректность выполнения запроса и определяем его результат
        if( !mysqli_errno($mysqli) && $row=mysqli_fetch_row($sql_res) )
        {
            if( !$TOTAL=$row[0] ) // если в таблице нет записей
                return 'В таблице нет данных'; // возвращаем сообщение
            $PAGES = ceil($TOTAL/10); // вычисляем общее количество страниц
            if( $page>=$PAGES ) // если указана страница больше максимальной
                $page=$PAGES-1; // будем выводить последнюю страницу
        // формируем и выполняем SQL-запрос для выборки записей из БД
            $sort_type_db = 'id';
            if ($sort_type == 'fam') $sort_type_db = $DB_fields['surname'];
            else if ($sort_type == 'born') $sort_type_db =  $DB_fields['birthday'];
            $sql='SELECT * FROM '.$DB_table_name.' ORDER BY '.$sort_type_db.' LIMIT '.($page*10).', 10'; 
            $sql_res=mysqli_query($mysqli, $sql);

            $ret='<table>'; // строка с будущим контентом страницы
            $ret.='<tr>';
            $ret.='<th>ID</th>';
            $ret.='<th>Фамилия</th>';
            $ret.='<th>Имя</th>';
            $ret.='<th>Отчество</th>';
            $ret.='<th>Пол</th>';
            $ret.='<th>Дата рождения</th>';
            $ret.='<th>Телефон</th>';
            $ret.='<th>Адрес</th>';
            $ret.='<th>Email</th>';
            $ret.='<th>Комментарий</th>';
            $ret.='</tr>';

            while( $row=mysqli_fetch_assoc($sql_res) ) // пока есть записи
            {
                // выводим каждую запись как строку таблицы
                $ret.='<tr>';
                $ret .= '<td>'.$row['id'].'</td>';
                foreach($DB_fields as $key => $value) {
                    $ret .= '<td>'.$row[$value].'</td>';
                }
                $ret.='</tr>';
            }
            $ret.='</table>'; // заканчиваем формирование таблицы с контентом
            if( $PAGES>1 ) // если страниц больше одной – добавляем пагинацию
            {
                $ret.='<div class="pages">'; // блок пагинации
                for($i=0; $i<$PAGES; $i++) // цикл для всех страниц пагинации
                if( $i != $page ) // если не текущая страница
                $ret.='<a href="?pg='.$i.'">'.($i+1).'</a>';
                else // если текущая страница
                $ret.='<span>'.($i+1).'</span>';
                $ret.='</div>';
            }
         return $ret; // возвращаем сформированный контент
        }
        // если запрос выполнен некорректно
        else return 'Неизвестная ошибка'; // возвращаем сообщение
    }
?>