<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <style>
        body {
            font-family: sans-serif;
            background-color: #758cb4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }


        #icon {
            padding: 10px;
            margin: 10px;
        }

        a {
            text-decoration: none;
        }

        h2 {
            text-align: center;
        }

        .container {
            background-color: rgba(216, 217, 224, 0.85);
            width: 500px;
            height: auto;
            padding: 30px;
            box-shadow: 0px 0px 10px rgb(1, 1, 1);
            border-radius: 7px;
            text-align: center;
        }

        .form-control {
            margin-top: 10px;
        }

        #buton {
            width: 100%;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .container {
                width: 80%;
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .container {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<form action="ko_kayıt.php" method="post">
    <div class="container">
        <h2>Kayıt Ol</h2><br>
        <input class="form-control" type="text" name="name" placeholder="İsim" required><br>
        <input class="form-control" type="text" name="surname" placeholder="Soyisim" required><br>
        <input class="form-control" type="text" name="email" placeholder="E-posta" required><br>
        <input class="form-control" type="text" name="password" placeholder="Şifre" required><br>
        <input id="buton" class="btn btn-success btn-lg" type="submit" name="submit" value="Kaydet"><br><br>
        Zaten hesabım var: <a href="ko_giris.php" target="_blank">üye girişi</a><br><br>
    </div>
</form>

<?php
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Şifreyi veritabanına kaydetmeden önce hashle
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $servername = "localhost";
    $uname = "root";
    $dbpassword = "";  // Kullanıcı girdisi olan $password değişkeni ile çakışmaması için değişken adı değiştirildi
    $dbname = "kutuphane";

    $conn = new mysqli($servername, $uname, $dbpassword, $dbname);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "INSERT INTO kullanici (user_name, user_surname, email, sifre) 
           VALUES ('".$name."','".$surname."','".$email."','".$password."')";

    if ($conn->query($sql) === TRUE) {
        echo "Kaydedildi";
        header("Location: ko_giris.php");  // Giriş sayfasına yönlendir
        exit();  // Daha fazla kod çalıştırılmasını engelle
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
        crossorigin="anonymous"></script>
</body>
</html>
