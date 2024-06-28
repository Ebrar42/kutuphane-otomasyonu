<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="deneme2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Kitaplarım</title>
</head>
<body>
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
<div class="main-content">
    <h2 style="color: #758cb4; text-align: center; margin-top: 20px; margin-bottom: 20px; border: #9da6c4 1px solid; border-radius:5px; padding: 5px 0px 5px">Ödünç alınan kitaplar</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kutuphane";

    // Veritabanına bağlanma
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantı hatasını kontrol etme
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }
    // Giriş yapan kullanıcıyı kontrol et
    if (isset($_SESSION['user_id'])) {
        $admin = $_SESSION['admin_id'] ?? false; // Admin kontrolü

        // Admin ise tüm kullanıcıların ödünç aldığı kitapları sorgula
        if ($admin) {
            $sql = "SELECT books.book_id, books.book_name, books.writer, books.publisher, books.page, kullanici.user_name
                FROM borrow 
                JOIN books ON borrow.book_id = books.book_id 
                JOIN kullanici ON borrow.user_id = kullanici.user_id";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $book_id = $row["book_id"];
                    $book_name = $row["book_name"];
                    $writer = $row["writer"];
                    $publisher = $row["publisher"];
                    $page = $row["page"];
                    $book_image = "images/" . $book_id . ".jpg";
                    ?>
                    <div class="card mb-3" style="max-width: 600px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo $book_image; ?>" class="img-fluid rounded-start" alt="<?php echo $book_name; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $book_name; ?></h5>
                                    <p class="card-text">Yazar: <?php echo $writer; ?></p>
                                    <p class="card-text">Yayınevi: <?php echo $publisher; ?></p>
                                    <p class="card-text">Sayfa Sayısı: <?php echo $page; ?></p>
                                    <p class="card-text">Kullanıcı: <?php echo $row["user_name"]; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Ödünç alınan kitap bulunamadı!";
            }
        } else {
            echo "Bu sayfayı görüntüleme yetkiniz yok!";
        }
    } else {
        echo "Lütfen giriş yapın!";
    }

    $conn->close();
    ?>
</div>

<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
</script>
</body>
</html>
