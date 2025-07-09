<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');

// Pas de filtre semaine : on récupère tout ce qui concerne les professeurs
$stmt = $pdo->prepare("
    SELECT * FROM vaovao 
    WHERE (mpandray='rehetra' OR mpandray='mpampianatra')
    ORDER BY daty DESC, ora DESC
");
$stmt->execute();
$actu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Vaovao mpampianatra (tout)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css" rel="stylesheet">
</head>
<body>
    <?php include("../loha.php"); ?>
    <?php include("../sisiny_mpampianatra.php"); ?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2><i class="fas fa-newspaper me-2"></i>Vaovao sy Fampandrenesana rehetra</h2>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Fanavaozam-baovao avy amin'ny sekoly</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
            <?php foreach ($actu as $v): ?>
                <li class="list-group-item">
                    <strong><?= date('d/m/Y', strtotime($v['daty'])) ?> <?= substr($v['ora'],0,5) ?> :</strong>
                    <b><?= htmlspecialchars($v['lohateny']) ?></b>
                    <br>
                    <?= nl2br(htmlspecialchars($v['votoaty'])) ?>
                </li>
            <?php endforeach; ?>
            <?php if (!$actu): ?>
                <li class="list-group-item text-muted">Tsy misy vaovao.</li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>