<?php
session_start();
?>
<!DOCTYPE html>
<html lang="tr">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="deneme2.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <title>Kitaplarım</title>
</head>
<body>
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
<div class="main-content">
    <h2 style="color: #758cb4 ; text-align: center; margin-top: 20px; margin-bottom: 20px; border: #9da6c4 1px solid; border-radius:5px; padding: 5px 0px 5px " >Ödünç aldığım kitaplar</h2>
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
    $user_id = $_SESSION['user_id'];

    // Kullanıcının ödünç aldığı kitapları sorgula
    $sql = "SELECT books.book_id, books.book_name, books.writer, books.publisher, books.page
            FROM borrow 
            JOIN books ON borrow.book_id = books.book_id 
            WHERE borrow.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
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
