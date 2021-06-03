<?php

    function getList() {
        session_from_get();
        $page=$_SESSION['pg'];

        require 'secret.php';
        $mysqli = mysqli_connect($DB_host, $DB_login, $DB_password, $DB_name);
        
        if( mysqli_connect_errno() ) // проверяем корректность подключения
            return 'Ошибка подключения к БД: '.mysqli_connect_error();
        
        // формируем и выполняем SQL-запрос для определения числа записей
        $sql_res=mysqli_query($mysqli, 'SELECT COUNT(*) FROM '.$DB_table_name);
        // проверяем корректность выполнения запроса и определяем его результат
        if( !mysqli_errno($mysqli) && $row=mysqli_fetch_row($sql_res) )
        {
            if( !$TOTAL=$row[0] ) // если в таблице нет записей
                return 'В таблице нет данных'; // возвращаем сообщение
            $PAGES = ceil($TOTAL/10); // вычисляем общее количество страниц
            if( $page>=$TOTAL ) // если указана страница больше максимальной
                $page=$TOTAL-1; // будем выводить последнюю страницу

            $sql='SELECT id, '.$DB_fields['surname'].', LEFT('.$DB_fields['name'].',1) AS name, LEFT('.$DB_fields['secondname'].',1) AS secondname FROM '.$DB_table_name.' ORDER BY id LIMIT '.($page*10).', 10'; 
            $sql_res=mysqli_query($mysqli, $sql);

            $ret = '<div class="div-edit">';
            while( $row=mysqli_fetch_assoc($sql_res) )
            {
                $isSelected = (isset($_GET['id'])&&$_GET['id']==$row['id']) ? ' class="currentRow"' : '';
                $ret .= '<a href="?id='.$row['id'].'"'.$isSelected.'>('.$row['id'].') '.$row[$DB_fields['surname']].' '.$row['name'].'. '.$row['secondname'].'.</a><br>';
            }
            $ret .= '</div>';
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
        }
        return $ret;
    }

    function changeValues($id=1) {
        if( isset($_POST['button']))
        {
            require 'secret.php';
            $mysqli = mysqli_connect($DB_host, $DB_login, $DB_password, $DB_name);

            if( mysqli_connect_errno() ) // проверяем корректность подключения
                echo 'Ошибка подключения к БД: '.mysqli_connect_error();
            
            // формируем и выполняем SQL-запрос для добавления записи
            $query_add = 'UPDATE '.$DB_table_name.' SET ';
            foreach($DB_fields as $key => $value) {
                $query_add .= $value.'="'.htmlspecialchars($_POST[$key]).'"';
                if ($key!='comment') $query_add .= ', ';
            }
            $query_add .= ' WHERE id='.$id;

            $sql_res=mysqli_query($mysqli, $query_add);

            // если при выполнении запроса произошла ошибка – выводим сообщение
            $_SESSION['query_result'] = !mysqli_errno($mysqli);
            header("Location: ".$_SERVER['REQUEST_URI']);
        }
        else {
            if (isset($_SESSION['query_result'])) {
                if( $_SESSION['query_result']=='0' )
                    echo '<div class="error">Запись не отредактирована</div>';
                else if ( $_SESSION['query_result']=='1' ) // если все прошло нормально – выводим сообщение
                    echo '<div class="ok">Запись отредактирована</div>';
            }
            $_SESSION['query_result']='-1';
        }
    }

    function getRowByID($id=1) {
        require 'secret.php';
        $mysqli = mysqli_connect($DB_host, $DB_login, $DB_password, $DB_name);
        
        if( mysqli_connect_errno() ) {// проверяем корректность подключения
            echo 'Ошибка подключения к БД: '.mysqli_connect_error();
            return null;
        }

        $sql_res=mysqli_query( $mysqli, 'SELECT * FROM '.$DB_table_name.' WHERE id='.$id );

        if( !mysqli_errno($mysqli) && $row=mysqli_fetch_assoc($sql_res) )
        {
            $db_data = [];
            foreach($DB_fields as $key => $value) {
                $db_data[$key] = $row[$value];
            }
            return $db_data;
        }
        else {
            echo 'Неизвестная ошибка';
            return null;
        }
    }

    require 'head.php';

    echo getList();

    if (isset($_GET['id'])) {
        changeValues($_GET['id']);
        $db_row_data = getRowByID($_GET['id']);
        $controlVar=false;
        if ($db_row_data!=null) $controlVar = true;
        if ($controlVar) require 'add.html';
    }
    
    require 'foot.php';
?>