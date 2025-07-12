<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$nom = $_SESSION['anarana'] ?? '';
$classe = $_SESSION['kilasy'] ?? '';
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Pejy Fandraisana - Mpianatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body class="tany-fototra">
<?php
include("../loha.php");  // inclut le contenu du fichier header.php ici
?>
<?php
include("../sisiny_mpianatra.php");  // inclut le contenu du fichier header.php ici
?>
<main class="votoaty" id="votoaty">
    <div class="container-fluid">
        <div class="takelaka-fandraisana">
            <h2 class="mb-4">Tongasoa <?= htmlspecialchars($nom) ?> (<?= htmlspecialchars($classe) ?>)</h2>
            <!-- Annonce écolage -->
            <div class="alert alert-info d-flex align-items-center my-3" role="alert">
                <i class="fas fa-coins fa-2x me-3"></i>
                <div>
                    <strong>Saram-pianarana&nbsp;:</strong> Raha mbola tsy nandoa ianao dia aza adino ny mandoa alohan'ny <b>15/07/2025</b>.
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-bell text-warning me-2"></i>Fampahafantarana</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Fivoriana ho an'ny ray aman-dreny 15/10/2025</li>
                        <li class="list-group-item">Daty farany handoavana ny saram-pianarana 15/07/2025</li>
                        <li class="list-group-item">Fanadinana farany 15/12/2025</li>
                    </ul>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <h4><i class="fas fa-star text-primary me-2"></i>Ireo naoty vaovao</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Matematika: 15/20</li>
                        <li class="list-group-item">Fizika: 12/20</li>
                        <li class="list-group-item">Français: 18/20</li>
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