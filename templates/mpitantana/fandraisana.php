<?php
session_start();

$admin = $_SESSION['anarana'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>EduPlateforme MG - Mpiandraikitra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body class="tany-fototra">
 <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpitantana.php");  
?>

<main class="votoaty" id="votoaty">
    <div class="container-fluid">
        <div class="takelaka-fandraisana">
            <h2 class="mb-4"><i class="fas fa-chalkboard text-primary me-2"></i>Pejy fandraisana (Mpiandraikitra)</h2>
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i> Eto no itantanana ny mpampiasa, mpianatra, mpampianatra, fandaharam-potoana sy vaovao rehetra.
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-user-plus text-success me-2"></i>Fisoratana anarana</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="fanoratana_mpianatra.php">Mpianatra vaovao</a></li>
                        <li class="list-group-item"><a href="fanoratana_mpampianatra.php">Mpampianatra vaovao</a></li>
                    </ul>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <h4><i class="fas fa-cogs text-warning me-2"></i>Fitantanana hafa</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="fampidirana_fandaharana.php">Fandaharam-potoana</a></li>
                        <li class="list-group-item"><a href="fampahafantarana.php">Vaovao/Fampahafantarana</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include("../tongony.php");  
?>

</body>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>