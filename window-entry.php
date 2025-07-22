<?php
$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = 'localhost';
    $user = 'pevkun';
    $password = ',jujvLFY30082006';
    $dbname = 'contact_form_db';

    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    $fio = htmlspecialchars(trim($_POST['fio']));
    $tel = htmlspecialchars(trim($_POST['tel']));
    $usl = htmlspecialchars(trim($_POST['usl']));

    $stmt = $conn->prepare("INSERT INTO requests (fio, tel, usl) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fio, $tel, $usl);

    if ($stmt->execute()) {
        $msg = "✅ Данные успешно отправлены!";
    } else {
        $msg = "❌ Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ | BogSavDes</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header class="header" id="myHeader">
        <div class="wrapper">
            
            <div class="header__wrapper">
                <div class="header__logo">
                <a href="./index.html" class="header__logo link">
                    <img src="./img/svg/logo.svg" alt="44PEV" class="header__logo-pic">
                </a>
            </div>
            <div class="header__nav">
                <ul class="header_list">
                    <li class="header__item">
                        <a href="./index.html" class="header__link">Главная</a>
                    </li>
                    <li class="header__item">
                        <a href="./window-portf.html" class="header__link">Портфолио</a>
                    </li>
                    <li class="header__item">
                        <a href="./window-contacts.html" class="header__link">Галерея</a>
                    </li>
                    <li class="header__item">
                        <a href="./window-entry.php" class="header__link__active">Сделать заказ</a>
                    </li>
                </ul>
            </div>
            </div>
        </div>
    </header>
    <main class="main">
        <section class="ent__int">
            <div class="wrapper">
                <h1 class="intro__title4">
                    СДЕЛАТЬ ЗАКАЗ
                </h1>
                <form action="" method="POST" class="contact-form">
                    <fieldset class="contact-form_wrap">
                          <p class="contact-form_info">
                            <input type="text" name="fio" class="contact-form_field" placeholder="ФИО" required>
                            <input type="tel" name="tel" class="contact-form_field" placeholder="НОМЕР ТЕЛЕФОНА" required>
                            <!-- <input type="text" name="usl" class="contact-form_field" placeholder="УСЛУГА" required> -->

                            <select name="usl" class="contact-form_field" required>
                                <option value=""disabled selected hidden>ВЫБЕРИТЕ УСЛУГУ</option>
                                <option value="карточки WB">Карточки WB</option>
                                <option value="разработка логотипа">Разработка логотипа</option>
                                <option value="разработка сайта">Разработка дизайна сайта</option>
                                <option value="прочее">Прочее...</option>
                            </select>

                            <button type="submit" class="contact-form_submit">ОТПРАВИТЬ</button>
                          </p>
                    </fieldset>
                </form>

                <?php if (!empty($msg)): ?>
                <p style="color: green; font-weight: bold; margin-top: 15px;">
                    <?= $msg ?>
                </p>
                <?php endif; ?>

            </div>
        </section>
    </main>
</body>
</html>