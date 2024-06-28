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
            margin-top: 35px;
        }

        input.kid {
            width: 250px;
            height: 45px;
            margin-top: 10px;
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
                <span>ZERUA BOOKSTORE</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
            <img src="images/admin.png" class="user_img">

        </div>
        <ul>
            <li>
                <a href="ko_giris.php">
                    <i class="bx bxs-home"></i>
                    <span class="nav-item">Anasayfa </span>
                </a>
                <span class="tooltip">Anasayfa</span>
            </li>
            <li>
                <a href="kitapekle.php">
                    <i class="bx bxs-book-add"></i>
                    <span class="nav-item">Kitap Ekle</span>
                </a>
                <span class="tooltip">Kitap Ekle</span>
            </li>
            <li>
                <a href="kitapsil.php">
                    <i class="bx bxs-book-alt"></i>
                    <span class="nav-item">Kitap Sil</span>
                </a>
                <span class="tooltip">Kitap Sil</span>
            </li>
            <li>
                <a href="kitapguncelle.php">
                    <i class="bx bxs-book-content"></i>
                    <span class="nav-item">Kitap Güncelle</span>
                </a>
                <span class="tooltip">Kitap Güncelle</span>
            </li>
            <li>
                <a href="kullanicisil.php">
                    <i class="bx bxs-user-minus"></i>
                    <span class="nav-item">Kullanıcı Sil</span>
                </a>
                <span class="tooltip">Kullanıcı Sil</span>
            </li>
            <li>
                <a href="kgdeneme.php">
                    <i class="bx bxs-user-detail"></i>
                    <span class="nav-item">Kullanıcı Güncelle</span>
                </a>
                <span class="tooltip">Kullanıcı Güncelle</span>
            </li>
            <li>
                <a href="a_kitaplar.php">
                    <i class="bx bxs-book"></i>
                    <span class="nav-item">Kitaplar</span>
                </a>
                <span class="tooltip">Kitaplar</span>
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
    <form action="kitapguncelle.php" method="post" class="guncelle">
        <h1>Kitap Güncelle</h1>
        <input type="text" placeholder="Kitap id" name="uid" class="kid" required>
        <button class="btn1 btn btn-danger" name="search" type="submit">Ara</button>
    </form>

<div class="container" style="display: inline-block;">
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

    if (isset($_POST["search"])) {
        $uid = $_POST["uid"];

        $sql = "SELECT * FROM books WHERE book_id='$uid'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form action='kitapguncelle.php' style='display: inline-block' method='post' class='kg'>";
                echo "Kitap id <br> <input type='text' name='book_id' value='" . $row['book_id'] . "' placeholder='Kitapid'><br> ";
                echo "Kitap Adı <br> <input type='text' name='book_name' value='" . $row['book_name'] . "' placeholder='Kitap Adı'><br> ";
                echo "Yazar Adı <br> <input type='text' name='writer' value='" . $row['writer'] . "' placeholder='Yazar Adı'><br> ";
                echo "Yayınevi <br> <input type='text' name='publisher' value='" . $row['publisher'] . "' placeholder='Yayınevi'><br>";
                echo "Sayfa Sayısı <br> <input type='text' name='page' value='" . $row['page'] . "' placeholder='Sayfa Sayısı'><br>";
                echo "Kitap Türü <br> <input type='text' name='book_g_id' value='" . $row['book_g_id'] . "' placeholder='Kitap Türü'><br><br> ";
                echo "<button type='submit' name='update' class='gncl'>GÜNCELLE</button>";
                echo "</form>";

            }
        } else {
            echo "Kayıt bulunamadı!";
        }
    }

    if (isset($_POST["update"])) {
        $book_id = $_POST["book_id"];
        $book_name = $_POST["book_name"];
        $writer = $_POST["writer"];
        $publisher = $_POST["publisher"];
        $page = $_POST["page"];
        $book_g_id = $_POST["book_g_id"];

        $sql = "UPDATE books SET book_name='$book_name', writer='$writer', publisher='$publisher', page='$page' WHERE book_id='$book_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Kayıt başarıyla güncellendi";
        } else {
            echo "Güncelleme hatası: " . $conn->error;
        }
    }

    $conn->close();

    ?>
</div>
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
