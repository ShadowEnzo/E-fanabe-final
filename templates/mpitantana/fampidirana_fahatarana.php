<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e_-anabe;charset=utf8', 'root', '');

$sokajy = $_GET['sokajy'] ?? '';
$id_persona = $_GET['id_persona'] ?? 0;
$info = null;

if ($sokajy === 'mpianatra') {
    $stmt = $mpampifandray->prepare("SELECT * FROM mpianatra WHERE id = ?");
    $stmt->execute([$id_persona]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
} elseif ($sokajy === 'mpampianatra') {
    $stmt = $mpampifandray->prepare("SELECT * FROM mpampianatra WHERE id = ?");
    $stmt->execute([$id_persona]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (!$info) { echo "Tsy hita"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $daty = $_POST['daty'];
    $karazana = $_POST['karazana'];
    $fanamarihana = $_POST['fanamarihana'];
    $anarana = $info['anarana'];
    $fanampiny = $info['fanampiny'] ?? '';
    $kilasy = $info['kilasy'] ?? '';
    $stmt = $mpampifandray->prepare(
        "INSERT INTO fahatarana_tsy_fahatongavana (sokajy, id_persona, anarana, fanampiny, kilasy, daty, karazana, fanamarihana)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->execute([$sokajy, $id_persona, $anarana, $fanampiny, $kilasy, $daty, $karazana, $fanamarihana]);
    header('Location: fahatarana_tsy_fahatongavana.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fampidirana fahatarana / tsy fahatongavana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
 <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpitantana.php");  
?>
<main class="votoaty" id="votoaty">
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Fampidirana fahatarana / tsy fahatongavana</h4>
                </div>
                <div class="card-body">
                    <form method="post" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Anarana</label>
                            <div class="form-control bg-light"><?= htmlspecialchars($info['anarana']) ?> <?= htmlspecialchars($info['fanampiny'] ?? '') ?></div>
                        </div>
                        <?php if($sokajy === 'mpianatra' || !empty($info['kilasy'])): ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kilasy</label>
                            <div class="form-control bg-light"><?= htmlspecialchars($info['kilasy'] ?? '') ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="daty" class="form-label">Daty</label>
                            <input type="date" class="form-control" id="daty" name="daty" required>
                        </div>
                        <div class="mb-3">
                            <label for="karazana" class="form-label">Karazana</label>
                            <select class="form-select" id="karazana" name="karazana">
                                <option value="Absence">Tsy fahatongavana</option>
                                <option value="Retard">Fahatarana</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fanamarihana" class="form-label">Fanamarihana</label>
                            <input type="text" class="form-control" id="fanamarihana" name="fanamarihana" placeholder="Fanazavana raha ilaina">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="javascript:history.back()" class="btn btn-secondary">Hiverina</a>
                            <button type="submit" class="btn btn-primary">Tehirizo</button>
                        </div>
                    </form>
                </div>
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