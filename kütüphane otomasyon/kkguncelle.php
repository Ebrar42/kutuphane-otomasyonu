<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Kullanıcı Güncelle</title>
    <style>
        .guncelle {
            width: 500px;
            height: auto; /* Otomatik yükseklik */
            background-color: #9da6c4;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            border-color: #fffff7;
            box-shadow: 10px 10px 5px rgba(41, 63, 87, 0.71);
            border-radius: 3px;
            margin-top:60px;
        }

        input.kid {
            width: 250px;
            height: 45px;
            margin-top: 30px;
            border-radius: 10px;
            border-color: #325c85;
            z-index: 1;
        }

        .kg {
            background-color: #9da6c4;
            width: 500px;
            height: auto; /* Otomatik yükseklik */
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            border-color: #fffff7;
            border-radius: 3px;
            box-shadow: 10px 10px 5px rgba(41, 63, 87, 0.71);
            margin-top: 20px;
        }

        button.gncl {
            color: white;
            background-color: green;
            border-color: green;
            border-radius: 2px;
        }


        /* Tablet ve telefon boyutları için ekstra stiller */
        @media screen and (max-width: 768px) {
            .guncelle, .kg {
                width: 90%; /* Ekranın genişliğine bağlı olarak ayarla */
                margin-left: auto; /* Otomatik olarak hizala */
                margin-right: auto; /* Otomatik olarak hizala */
            }
        }

    </style>
</head>
<body>
<div class="main-content">
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <i class="bx bx-book-bookmark"></i>
                <span>ZERUA KİTAPEVİ</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
            <img src="images/me.jpeg" class="user_img">
        </div>
        <ul>
            <li>
                <a href="anasayfa.php">
                    <i class="bx bxs-home"></i>
                    <span class="nav-item">Anasayfa</span>
                </a>
                <span class="tooltip">Anasayfa</span>
            </li>
            <li>
                <a href="roman.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Roman</span>
                </a>
                <span class="tooltip">Roman</span>
            </li>
            <li>
                <a href="hikaye.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Hikaye</span>
                </a>
                <span class="tooltip">Hikaye</span>
            </li>
            <li>
                <a href="manga.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Manga</span>
                </a>
                <span class="tooltip">Manga</span>
            </li>
            <li>
                <a href="bilimkurgu.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Bilimkurgu</span>
                </a>
                <span class="tooltip">Bilimkurgu</span>
            </li>
            <li>
                <a href="kkguncelle.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Bilgi Güncele</span>
                </a>
                <span class="tooltip">Bilgi Güncele</span>
            </li>
            <li>
                <a href="k_kitap.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Kitaplarım</span>
                </a>
                <span class="tooltip">Kitaplarım</span>
            </li>
            <li>
                <a href="log_out.php">
                    <i class="bx bx-log-out"></i>
                    <span class="nav-item">Çıkış</span>
                </a>
                <span class="tooltip">Çıkış</span>
            </li>
        </ul>
    </div>
    <div class="container" style="display: inline-block; text-align: center;">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kutuphane";

        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        if (!isset($_SESSION['user_id'])) {
            echo "Lütfen giriş yapın!";
            exit;
        }

        $current_user_id = $_SESSION['user_id'];

        // Kullanıcının bilgilerini getirme
        $sql = "SELECT * FROM kullanici WHERE user_id='$current_user_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form action='kkguncelle.php' class='kg' method='post'>";
                echo "<input type='hidden' name='user_id' value='" . $row['user_id'] . "'>";
                echo "Numara <br> <input type='text' name='user_name' value='" . $row['user_name'] . "' placeholder='Kullanıcı Adı'><br><br> ";
                echo "Ad <br> <input type='text' name='user_surname' value='" . $row['user_surname'] . "' placeholder='Kullanıcı Soyadı'><br><br> ";
                echo "Soyad <br> <input type='text' name='email' value='" . $row['email'] . "' placeholder='email'><br><br> ";
                echo "Şifre <br> <input type='text' name='u_password' value='" . $row['sifre'] . "' placeholder='Şifre'><br><br> ";
                echo "<button type='submit' name='update' class='gncl'>GÜNCELLE</button>";
                echo "</form>";
            }
        } else {
            echo "Kullanıcı bilgileri bulunamadı!";
        }

        if (isset($_POST["update"])) {
            $user_id = $_POST["user_id"];
            $user_name = $_POST["user_name"];
            $user_surname = $_POST["user_surname"];
            $email = $_POST["email"];
            $u_password = $_POST["u_password"];

            if ($user_id == $current_user_id) {
                $sql = "UPDATE kullanici SET user_name='$user_name', user_surname='$user_surname', email='$email', sifre='$u_password' WHERE user_id='$user_id'";

                if ($conn->query($sql) === TRUE) {
                    echo "<br>";
                    echo "Kayıt başarıyla güncellendi";
                } else {
                    echo "Güncelleme hatası: " . $conn->error;
                }
            } else {
                echo "Yalnızca kendi bilgilerinizi güncelleyebilirsiniz!";
            }
        }

        $conn->close();
        ?>
    </div>
</div>
</body>
<script>
    let btn= document.querySelector('#btn');
    let sidebar= document.querySelector('.sidebar');

    btn.onclick = function (){
        sidebar.classList.toggle('active');
    };
</script>
</html>
