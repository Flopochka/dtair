<?php
include_once $_SERVER['DOCUMENT_ROOT']."/handlers/db.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Air - личный кабинет</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/plane.svg" type="image/x-icon">
</head>
<body>
    <header>
        <div class="section header_section">
           <div class="container header_container">
                <a href="../" class="link logo_link">
                    <img class="logo" src="../img/plane.svg" alt="Логотип">
                </a>
                <nav class="header_nav">
                    <?php
                    if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
                        echo '<a href="..login/" class="link nav-link">Войти</a>
                        <a href="..singup/" class="link nav-btn">Зарегестироватся</a>';
                    } else{
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $data = $query->fetch();
                        if (!password_verify($_SESSION['password'], $data['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            header("location: ../handlers/logout.php");
                            exit;
                        }else{
                            echo '<a href="/" class="link nav-link"><img class="user-ico" src="../'.$data['profile_pic'].'" alt="Профиль пользователя"></a>';  
                        }
                    }
                    ?>
                </nav>
           </div>
        </div>
    </header>
    <main>
        <section class="section search_section">
            <div class="container search_container">
                <h1>Результаты поиска</h1>
                <?php
                    // Получаем параметры из GET запроса
                    $from_dest = $_GET['from_dest'];
                    $to_dest = $_GET['to_dest'];
                    $from_date = $_GET['from_date'];
                    $to_date = $_GET['to_date'];
                    $query = $con->prepare("SELECT * FROM destinations");
                    $query->execute();
                    $dest_data = $query->fetchAll();
                    $dest = [];
                    foreach ($dest_data as $opt) {
                        if ($from_dest == $opt['title']) {
                            $from_dest = $opt['id'];
                        }
                        if ($to_dest == $opt['title']) {
                            $to_dest = $opt['id'];
                        }
                        if (!$dest[$opt['id']]) {
                            $dest[$opt['id']] = $opt['title'];
                        }
                    }

                    // Готовим SQL запрос для получения рейсов
                    $stmt = $con->prepare("SELECT * FROM flights WHERE departure_destination = ? AND arrival_destination = ? AND date = ?");
                    $stmt->execute([$from_dest, $to_dest, $from_date]);
                    $result1 = $stmt->fetchAll();

                    $stmt = $con->prepare("SELECT * FROM flights WHERE departure_destination = ? AND arrival_destination = ? AND date = ?");
                    $stmt->execute([$to_dest, $from_dest, $to_date]);
                    $result2 = $stmt->fetchAll();

                    if ($result1) {
                        // Начало вывода HTML таблицы
                        echo "<table cellspacing='0' width='100%' id='flightTable'>";
                        echo "<tr>
                                <th>Дата вылета</th>
                                <th>Авиакомпания</th>
                                <th>Страна</th>
                                <th>Номер рейса</th>
                                <th>Время вылета</th>
                                <th>Место вылета</th>
                                <th>Время в пути</th>
                                <th>Остановки</th>
                                <th>Время прибытия</th>
                                <th>Место прибытия</th>
                                <th>Цена</th>
                                <th>Класс</th>
                              </tr>";
                        
                        // Вывод данных из массива в таблицу
                        foreach ($result1 as $flight) {
                            if ($flight['Type']==1) {
                                $flight['Type'] = "Бизнес";
                            }else{
                                $flight['Type'] = "Эконом";
                            }
                            echo "<tr>
                                    <td>{$flight['date']}</td>
                                    <td>{$flight['airline']}</td>
                                    <td>{$flight['ch_code']}</td>
                                    <td>{$flight['num_code']}</td>
                                    <td>{$flight['dep_time']}</td>
                                    <td>".$dest[$flight['departure_destination']]."</td>
                                    <td>{$flight['time_taken']}</td>
                                    <td>{$flight['stop']}</td>
                                    <td>{$flight['arr_time']}</td>
                                    <td>".$dest[$flight['arrival_destination']]."</td>
                                    <td>{$flight['price']}</td>
                                    <td>{$flight['Type']}</td>
                                  </tr>";
                        }
                        foreach ($result2 as $flight) {
                            if ($flight['Type']==1) {
                                $flight['Type'] = "Бизнес";
                            }else{
                                $flight['Type'] = "Эконом";
                            }
                            echo "<tr>
                                    <td>{$flight['date']}</td>
                                    <td>{$flight['airline']}</td>
                                    <td>{$flight['ch_code']}</td>
                                    <td>{$flight['num_code']}</td>
                                    <td>{$flight['dep_time']}</td>
                                    <td>".$dest[$flight['departure_destination']]."</td>
                                    <td>{$flight['time_taken']}</td>
                                    <td>{$flight['stop']}</td>
                                    <td>{$flight['arr_time']}</td>
                                    <td>".$dest[$flight['arrival_destination']]."</td>
                                    <td>{$flight['price']}</td>
                                    <td>{$flight['Type']}</td>
                                  </tr>";
                        }
                        
                        // Конец вывода HTML таблицы
                        echo "</table>";
                    } else {
                        echo "Нет рейсов, соответствующих вашим требованиям.";
                    }

                    ?>
            </div>
        </section>
    </main>
    <footer>
        <div class="section footer_section">
            <div class="footer_contacts">
                <h3 class="footer-title">Контакты</h3>
                <a href="" class="link nav-link">
                    +7 (800) 000-00-00
                    <p class="footer-text">Консультации по телефону</p>
                </a>
                <a href="" class="link nav-link">
                    infi@sitename.ru
                    <p class="footer-text">Электронная почта</p>
                </a>
            </div>
            <nav class="footer_nav">
                <a href="" class="link nav-link">Оплата</a>
                <a href="" class="link nav-link">Контакты</a>
                <a href="" class="link nav-link">Реквезиты</a>
                <a href="" class="link nav-link">Заказ удобного рейса</a>
                <a href="" class="link nav-link">Бронирование онлайн</a>
                <a href="" class="link nav-link">Выбор маршрута</a>
            </nav>
        </div>
    </footer>
    <script src="../js/main.js"></script>
</body>
</html>