<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>üye girişi</title>
    <style>
        .color1 {color: #758cb4;}
        .color2 {color: #9da6c4;}
        .color3 {color: #c1c3d4;}
        .color4 {color: #e2e2e5;}
        .color5 {color: #fffff7;}

        body {
            font-family: sans-serif;
            background-color: #758cb4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(216, 217, 224, 0.85);
            box-shadow: 0px 0px 10px rgb(1, 1, 1);
            border-radius: 7px;
            padding: 30px;
            width: 500px;
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

            .form-control {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            .form-control {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<form action="ko_giris.php" method="post">
    <div class="container">
        <h2>Giriş Yap</h2><br>
        <input class="form-control" aria-label="Large" type="text" name="email" placeholder="E-posta" required><br>
        <input class="form-control" aria-label="Large" type="password" name="password" placeholder="Şifre" required><br>
        <input id="buton" class="btn btn-success btn-lg mt-3" name="submit2" type="submit" value="Giriş Yap"><br>
        Üye değilim: <a href="ko_kayıt.php" target="_blank">üye ol</a><br><br>
        <a href="anasayfa.php"></a><br>
    </div>
</form>

<?php
if(isset($_POST["submit2"])){
    $e = $_POST["email"];
    $p = $_POST["password"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kutuphane";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    if($conn->connect_error){
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM kullanici WHERE email='$e' AND sifre='$p'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Kullanıcı oturumunu başlatma
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["user_id"];
        header("Location: roman.php");
        exit();
    } else {
        echo "Hatalı kullanıcı adı veya şifre!";
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
