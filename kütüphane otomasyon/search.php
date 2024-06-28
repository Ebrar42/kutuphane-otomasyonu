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

// Eğer 'search' parametresi yoksa veya boşsa, boş bir dize olarak atanır
$sql = "SELECT books.book_id, books.book_name, books.writer, publisher.publisher_name, books.page 
        FROM books 
        INNER JOIN publisher ON books.publisher = publisher.publisher_id 
        WHERE books.book_name LIKE '%$search%' 
        OR books.writer LIKE '%$search%' 
        OR publisher.publisher_name LIKE '%$search%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $book_id = $row["book_id"];
        $book_name = $row["book_name"];
        $writer = $row["writer"];
        $publisher_name = $row["publisher_name"];
        $page = $row["page"];

        $book_image = "images/" . $book_id . ".jpg";
        $modal_id_borrow = "modal_borrow_" . $book_id;
        $modal_id_return = "modal_return_" . $book_id;
        $borrow_btn_id = "borrow_btn_" . $book_id;
        $return_btn_id = "return_btn_" . $book_id;
        $close_borrow_btn_id = "close_borrow_" . $book_id;
        $close_return_btn_id = "close_return_" . $book_id;
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
                        <p class="card-text">Yayınevi: <?php echo $publisher_name; ?></p>
                        <p class="card-text">Sayfa Sayısı: <?php echo $page; ?></p>
                        <button type="button" class="btn btn-success" id="<?php echo $borrow_btn_id; ?>">Ödünç Al</button>
                        <div class="modal" tabindex="-1" role="dialog" id="<?php echo $modal_id_borrow; ?>">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ödünç Al</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Kitabı almak istediğinize emin misiniz?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="#" method="post">
                                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                                            <button name="borrow" type="submit" class="btn btn-primary">Ödünç Al</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" id="<?php echo $close_borrow_btn_id; ?>">Kapat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <form action="#" method="post">
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
}

?>