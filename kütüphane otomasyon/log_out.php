<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Çıkış</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container{
            margin-top: 250px;
        }
    </style>
</head>
<body  style="background-color: #758cb4"  >
<?php
session_unset();
session_abort();
?>
<div class="container  ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" >Çıkış Başarılı</div>
                <div class="card-body">
                    <p class="card-text">Oturumunuz başarıyla kapatıldı.</p>
                    <a href="anasayfa.php" class="btn btn-success">Anasayfaya Dönebilirsiniz</a>
                </div>
            </div>
        </div>
    </div>
</div>



</body>
</html>
