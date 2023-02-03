<?php
session_start();
if(isset($_GET['do'])) {
    if($_GET['do'] == 'logout') {
        unset($_SESSION['admin']);
        session_destroy();
    }
}
if(!$_SESSION['admin']) {
    header("Location: auth.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои Ссылки</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<?php
$localhost = 'localhost';
$login = 'root';
$password = '';
$db = 'link_database';
$conn = new mysqli($localhost, $login, $password, $db);

// Подключение к базе данных
function connect($conn) {
    if (!$conn) {
        echo "Error: " . mysqli_connect_error();
    }
}
connect($conn);

// Записываем данные из поля ввода в БД
function insert_info($conn) {
    if (isset($_GET['title']) AND $_GET['title'] != '' AND isset($_GET['link']) AND $_GET['link'] != '') {
        $get_title = $_GET['title'];
        $get_link = $_GET['link'];

        $sql_insert = "INSERT INTO `link` (`id`, `title`, `link_str`, `date_input`) VALUES (NULL, '$get_title', '$get_link', current_timestamp())";

        if (mysqli_query($conn, $sql_insert)) {
            header('Location: index.php');
            exit; 
        } else {
            echo "Error: <br>" . mysqli_error($conn);
        };   
    }
}
insert_info($conn);
?>

<body>
    <div class="container">
        <h2>Сохраненные ссылки</h2>

        <p class="link-logout">
            <a href="index.php?do=logout">Выйти</a>
        </p>
        
        <div class="form-box">
            <form action="index.php" method="get">
                <fieldset>
                    <legend>Создать ссылку:</legend>
                    <input type="text" name="title" placeholder="Заголовок"><br>
                    <input type="text" name="link" placeholder="Адресс"><br>
                    <input type="submit" name="submit" value="Сохранить">
                </fieldset>
            </form>
        </div>
        
        <br>
        <h3>Список ссылок</h3>
        <table>
        <?php
            // Получаем информацию из базы данных
            function select_info($conn) {
                $sql_select = "SELECT * FROM `link` ORDER BY `id` DESC";
                if($result = mysqli_query($conn, $sql_select)) {

                    // Если записи есть выводим через цикл, если нет то вывод сообщения...
                    if (mysqli_num_rows($result) > 0) {
                        $counter = 1;
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $counter . ". </td>
                                    <td class='data-td'><a target='_blank' href='" . $row['link_str'] . "'>" . $row['title'] . "</a></td>
                                    <td>
                                        <form action='link_delete.php' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "' >
                                            <input type='submit' class='btn-submit' value='Удалить'>
                                        </form>
                                    </td>
                                  </tr>"; 
                            $counter++;
                        } 
                        
                    } else {
                        echo '<i class="db-table-null">База данных - пустая!</i>';    
                    } 
                }; 
            }
            select_info($conn);

            // Закрываем подключение с базой данных
            function close_connect($conn) {
                mysqli_close($conn); 
            }
            close_connect($conn);
        ?>
        </table>
    </div>

</body>
</html>
