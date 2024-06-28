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
    <link rel="stylesheet" href="deneme2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Manga</title>
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
    <div class="container ">
        <form method="GET" action="manga.php" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Kitap adı, yazar veya yayınevi ara..."><br>
                <button type="submit" class="btn btn-primary">Ara</button>
            </div>
        </form>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "kutuphane";

        // Veritabanı bağlantısı
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        // Kullanıcı girdisinin alınması ve boş olup olmadığının kontrolü
        $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        if (isset($_GET['search'])) {
            // search.php sayfasını include et
            include 'search.php';
        }

        $sql = "SELECT books.book_id, books.book_name, books.writer, publisher.publisher_name, books.page, book_genre.book_genre, books.stok
                FROM books
                INNER JOIN publisher ON books.publisher = publisher.publisher_id
                INNER JOIN book_genre ON books.book_g_id = book_genre.book_g_id
                WHERE book_genre.book_genre = 'Manga'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $book_id = $row["book_id"];
                $book_name = $row["book_name"];
                $writer = $row["writer"];
                $publisher_name = $row["publisher_name"];
                $page = $row["page"];
                $stock = $row["stok"];

                $book_image = "images/" . $book_id . ".jpg";
                $modal_id_borrow = "modal_borrow_" . $book_id;
                $modal_id_return = "modal_return_" . $book_id;
                $borrow_btn_id = "borrow_btn_" . $book_id;
                $return_btn_id = "return_btn_" . $book_id;
                $close_borrow_btn_id = "close_borrow_" . $book_id;
                $close_return_btn_id = "close_return_" . $book_id;
                ?>
<br>
                <hr>
                <div class="card mb-3" style="max-width: 600px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo $book_image; ?>" class="img-fluid rounded-start" alt="<?php echo $book_name; ?>">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $book_name; ?></h5>
                                <p class="card-text">Yazar: <?php echo $writer; ?></p>
                                <p class="card-text">Yayınevi: <?php echo $publisher_name; ?></p>
                                <p class="card-text">Sayfa Sayısı: <?php echo $page; ?></p>
                               <?php if ($stock > 0) { ?>
                                <button type="button" class="btn btn-success" id="<?php echo $borrow_btn_id; ?>">Ödünç Al</button>
                                <div class="modal" tabindex="-1" role="dialog" id="<?php echo $modal_id_borrow; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ödünç Al</h5>
                                                <?php
                                                $u_id = $_SESSION["user_id"];
                                                ?>
                                            </div>
                                            <div class="modal-body">
                                                <p>Kitabı almak istediğinize emin misiniz?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="manga.php" method="post">
                                                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                                    <button name="borrow" type="submit" class="btn btn-primary">Ödünç Al</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" id="<?php echo $close_borrow_btn_id; ?>">Kapat</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <?php } else { ?>
                                   <button type="button" class="btn btn-secondary" disabled>Kitap Başka Birisinde</button>
                               <?php } ?>
                                <button type="button" class="btn btn-danger" id="<?php echo $return_btn_id; ?>">İade Et</button>
                                <div class="modal" tabindex="-1" role="dialog" id="<?php echo $modal_id_return; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">İade Et</h5>
                                            </div>
                                            <div class="modal-body">
                                                <p>Kitabı iade etmek istediğinize emin misiniz?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="manga.php" method="post">
                                                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                                    <button name="return" type="submit" class="btn btn-primary">İade Et</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" id="<?php echo $close_return_btn_id; ?>">Kapat</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "Hiç sonuç bulunamadı.";
        }
        $conn->close();
        ?>

        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Bağlantı hatası: " . $conn->connect_error);
        }

        if (isset($_POST["borrow"])) {
            $user_id = $_SESSION["user_id"];
            $book_id = $conn->real_escape_string($_POST["book_id"]);
            $today = date("Y-m-d");

            $check_sql = "SELECT * FROM borrow WHERE user_id = '$user_id'";
            $check_result = $conn->query($check_sql);

            if ($check_result->num_rows >= 3) {
                echo '<script>alert("Üzgünüz, en fazla 3 kitap ödünç alabilirsiniz.");</script>';
            } else {
                $check_sql = "SELECT * FROM borrow WHERE book_id = '$book_id' AND user_id = '$user_id'";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows == 0) {
                    $stock_check_sql = "SELECT stok FROM books WHERE book_id = '$book_id'";
                    $stock_check_result = $conn->query($stock_check_sql);
                    $stock_row = $stock_check_result->fetch_assoc();

                    if ($stock_row['stok'] > 0) { // Buradaki 'stok' alanının doğru olduğunu kontrol edin
                        $sqla = "INSERT INTO borrow (book_id, b_date, user_id) VALUES ('$book_id', '$today', '$user_id')";
                        $update_stock_sql = "UPDATE books SET stok = stok - 1 WHERE book_id = '$book_id'";

                        if ($conn->query($sqla) === TRUE && $conn->query($update_stock_sql) === TRUE) {
                            echo '<script>alert("Kitap ödünç alındı.");</script>';
                        } else {
                            echo "Hata: " . $sqla . "<br>" . $conn->error;
                        }
                    } else {
                        echo '<script>alert("Bu kitap başka birisinde.");</script>';
                    }
                } else {
                    echo '<script>alert("Bu kitabı zaten ödünç aldınız.");</script>';
                }
            }
        }

        if (isset($_POST["return"])) {
            $user_id = $_SESSION["user_id"];
            $book_id = $conn->real_escape_string($_POST["book_id"]);
            $today = date("Y-m-d");

            $sql = "DELETE FROM borrow WHERE book_id = '$book_id' AND user_id = '$user_id'";
            $update_stock_sql = "UPDATE books SET stok = stok + 1 WHERE book_id = '$book_id'";
            $sql_lend = "INSERT INTO lend (book_id, l_date, user_id) VALUES ('$book_id', '$today', '$user_id')";

            if ($conn->query($sql) === TRUE && $conn->query($update_stock_sql) === TRUE && $conn->query($sql_lend) === TRUE) {
                echo '<script>alert("Kitap iade edildi.");</script>';
            } else {
                echo "Hata: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
        <script>
            let btn = document.querySelector('#btn');
            let sidebar = document.querySelector('.sidebar');

            btn.onclick = function() {
                sidebar.classList.toggle('active');
            };

            document.querySelectorAll("[id^=borrow_btn_]").forEach(borrowBtn => {
                borrowBtn.addEventListener("click", function() {
                    const bookId = borrowBtn.id.replace("borrow_btn_", "");
                    document.getElementById("modal_borrow_" + bookId).style.display = "block";
                });
            });

            document.querySelectorAll("[id^=close_borrow_]").forEach(closeBtn => {
                closeBtn.addEventListener("click", function() {
                    const bookId = closeBtn.id.replace("close_borrow_", "");
                    document.getElementById("modal_borrow_" + bookId).style.display = "none";
                });
            });

            document.querySelectorAll("[id^=return_btn_]").forEach(returnBtn => {
                returnBtn.addEventListener("click", function() {
                    const bookId = returnBtn.id.replace("return_btn_", "");
                    document.getElementById("modal_return_" + bookId).style.display = "block";
                });
            });

            document.querySelectorAll("[id^=close_return_]").forEach(closeBtn => {
                closeBtn.addEventListener("click", function() {
                    const bookId = closeBtn.id.replace("close_return_", "");
                    document.getElementById("modal_return_" + bookId).style.display = "none";
                });
            });
        </script>
    </div>
</div>
</body>
</html>
