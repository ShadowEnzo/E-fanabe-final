<?php
session_start();

$prof_nom = $_SESSION['anarana'] ?? 'Professeur';
$matiere = $_SESSION['matiere'] ?? 'Taranja';
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>EduPlateforme MG - Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body class="tany-fototra">
    <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpampianatra.php");  
?>
<main class="votoaty" id="votoaty">
    <div class="container-fluid">
        <div class="takelaka-fandraisana">
            <h2 class="mb-4"><i class="fas fa-chalkboard-teacher text-primary me-2"></i>Pejy fandraisana (Professeur)</h2>
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i> Miarahaba anao Pr. <?= htmlspecialchars($prof_nom) ?>! Ampianaro: <b><?= htmlspecialchars($matiere) ?></b>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-list-check text-success me-2"></i>Asa amin'ity herinandro ity</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Manampy naoty <?= htmlspecialchars($matiere) ?> <span class="badge bg-primary float-end">Andrasana</span></li>
                        <li class="list-group-item">Manampy rakitra amin'ny fandaharana</li>
                        <li class="list-group-item">Manao fanitsiana fandaharam-potoana</li>
                    </ul>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <h4><i class="fas fa-envelope-open-text text-warning me-2"></i>Hafatra avy amin'ny sekoly</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Fivoriana an-dakilasy: 20/10/2025</li>
                        <li class="list-group-item">Fanavaozana programa: 01/11/2025</li>
                        <li class="list-group-item text-success">
                            <i class="fas fa-money-bill-wave me-1"></i>
                            Saram-pianarana: Fandoavana farany 07/07/2025
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include("../tongony.php");  
?>

<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>