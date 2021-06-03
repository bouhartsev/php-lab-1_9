<?php
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

            $_SESSION['query_result_data'] = '('.$id.') '.htmlspecialchars($_POST['surname']);
            // если при выполнении запроса произошла ошибка – выводим сообщение
            $_SESSION['query_result'] = !mysqli_errno($mysqli);
            header("Location: ".$_SERVER['REQUEST_URI']);
        }
        else {
            if (isset($_SESSION['query_result'])) {
                if( $_SESSION['query_result']=='0' )
                    echo '<div class="error">Запись не отредактирована</div>';
                else if ( $_SESSION['query_result']=='1' ) // если все прошло нормально – выводим сообщение
                    echo '<div class="ok">Запись "'.$_SESSION['query_result_data'].'" отредактирована</div>';
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

    require 'editing.php';

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