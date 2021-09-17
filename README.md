# php-lab-1_9
Polytech php, 1 course, 2 semester, lab9

## Installation
Создайте файл `secret.php`. В нём должна содержаться вся информация о базе данных. В значения словаря "DB_fields" запишите свои названия полей (кроме 'id'; это поле должно называться в точности так, значения создаются автоматически). Все необходимые переменные перечислены в шаблоне.
```php
<?php
    $DB_host = 'std-mysql.ist.mospolytech.ru:3306'; //host of database
    $DB_login = 'login'; //login
    $DB_password = 'password123';//password
    $DB_name = 'name_1374';//name of database
    $DB_table_name = 'lab9';//name of table in database
    $DB_fields = [
        //меняйте только значения (справа!)
        'surname' => 'LastName',
        'name' => 'Name',
        'secondname' => 'SecondName',
        'gender' => 'Gender',
        'birthday' => 'Birthday',
        'phone' => 'Phone',
        'address' => 'Address',
        'email' => 'Email',
        'comment' => 'Comment',
    ];
?>
```

Чтобы работало подключение к базе локально - найдите файл конфигурации PHP `php.ini`.
Добавьте или расскомментируйте эту строчку:
```
extension=php_mysql.dll
```
или
```
extension=mysqli
```

Проверьте, правильно ли у вас указана папка с расширениями. Там должна быть реально существующая папка. Например:
```
extension_dir = "c:/php/ext"
```

Если вы запускаете php сервер локально и при этом используете базу данных Московского Политеха, не забудьте включить *VPN*!
