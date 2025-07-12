<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$kilasy = $_SESSION['kilasy'] ?? '';

// Pas de filtre semaine : on récupère tout ce qui concerne cet élève
$stmt = $pdo->prepare("
    SELECT * FROM vaovao 
    WHERE (mpandray='rehetra' OR mpandray='mpianatra' OR FIND_IN_SET(?, mpandray))
    ORDER BY daty DESC, ora DESC
");
$stmt->execute([$kilasy]);
$actu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Ireo vaovao rehetra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include("../loha.php"); ?>
    <?php include("../sisiny_mpianatra.php"); ?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2><i class="fas fa-newspaper me-2"></i>Ireo vaovao rehetra</h2>
    <div class="row mt-4">
        <?php foreach($actu as $v): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/300x200" class="card-img-top">
                <div class="card-body">
                    <span class="badge bg-primary mb-2"><?= htmlspecialchars($v['mpandray']) ?></span>
                    <h5 class="card-title"><?= htmlspecialchars($v['lohateny']) ?></h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($v['votoaty'])) ?></p>
                    <p class="text-muted small"><i class="far fa-clock me-1"></i><?= date('d/m/Y', strtotime($v['daty'])) ?> <?= substr($v['ora'],0,5) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (!$actu): ?>
        <div class="col-12"><div class="alert alert-secondary">Tsy misy vaovao.</div></div>
        <?php endif; ?>
    </div>
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
</html>