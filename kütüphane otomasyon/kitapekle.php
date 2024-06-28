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
    <title>Kitap Ekle</title>
    <style>
        .bilgi {
            background-color: #9da6c4;
            width: 500px;
            height: 500px;
            text-align: center;
            border-color: #fffff7;
            box-shadow: 10px 10px 5px rgba(41, 63, 87, 0.71);
            border-radius: 3px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Tablet ve telefon boyutları için ekstra stiller */
        @media screen and (max-width: 768px) {
            .bilgi {
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

    <div class="container">
    <form action="kitapekle.php" method="post">
        <div class="bilgi" role="group" >
            <h1>Kitap Ekle</h1>
            <input type="text" placeholder="Kitabın Adı" name="bname"> <br> <br>
            <input type="text" placeholder="Yazarın Adı" name="wname"> <br> <br>
            <input type="text" placeholder="Sayfa Sayısı" name="page"> <br> <br>
            <input type="text" placeholder="Yayın Evi" name="pubname"> <br> <br>
            <input type="text" placeholder="Kitap Türü" name="genre"> <br> <br>
            <button class="btn1 btn btn-success" name="submit1" type="submit" value="kaydet">Kaydet</button>

        </div>
    </form>
</div>



    <?php
    if(isset($_POST["submit1"])){
        $bname = $_POST["bname"];
        $wname = $_POST["wname"];
        $page = $_POST["page"];
        $pubname= $_POST["pubname"];
        $genre= $_POST["genre"];


        $servername = "localhost";
        $uname = "root";
        $password = "";
        $dbname = "kutuphane";

        $conn = new mysqli($servername,$uname,$password,$dbname);
        $conn->set_charset("utf8");

        if($conn->connect_error){
            die("Bağlantı hatası : ".$conn->connect_error);
        }

        $sql = "INSERT INTO books (book_name,writer,publisher,page,book_g_id) 
VALUES ('".$bname."','".$wname."','.$page.','".$pubname."','.$genre.')";

        if($conn->query($sql)===TRUE){
            echo  "Kaydedildi";
        } else {
            echo "Hata:".$sql."<br>".$conn->error;
        }

        $conn->close();

    }
    ?>
</body>
<script>
    let btn= document.querySelector('#btn');
    let sidebar= document.querySelector('.sidebar');

    btn.onclick = function (){
        sidebar.classList.toggle('active');
    };
</script>
</html>