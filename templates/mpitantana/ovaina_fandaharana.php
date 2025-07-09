<?php
session_start();
$mpampifandray = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$id = $_GET['id'] ?? 0;
$stmt = $mpampifandray->prepare("SELECT * FROM fandaharana WHERE id=?");
$stmt->execute([$id]);
$f = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$f) { echo "Fandaharana tsy hita."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lohateny = $_POST['lohateny'];
    $karazana = $_POST['karazana'];
    $daty = $_POST['daty'];
    $ora_manomboka = $_POST['ora_manomboka'];
    $ora_mifarana = $_POST['ora_mifarana'];
    $efitrano = $_POST['efitrano'];
    $mpampianatra = $_POST['mpampianatra'];
    $kilasy = $_POST['kilasy'];
    $fanamarihana = $_POST['fanamarihana'];
    $anarana_admin = $_SESSION['anarana'] ?? 'AdminDemo';
    $stmt2 = $mpampifandray->prepare("UPDATE fandaharana SET lohateny=?, karazana=?, daty=?, ora_manomboka=?, ora_mifarana=?, efitrano=?, mpampianatra=?, kilasy=?, fanamarihana=?, anarana_admin=? WHERE id=?");
    $stmt2->execute([$lohateny, $karazana, $daty, $ora_manomboka, $ora_mifarana, $efitrano, $mpampianatra, $kilasy, $fanamarihana, $anarana_admin, $id]);
    header('Location: lisitra_fandaharana.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Ovaina fandaharam-potoana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4"><i class="fas fa-edit me-2"></i> Ovaina fandaharam-potoana</h2>
    <form class="row g-3" method="post" autocomplete="off">
        <div class="col-md-6">
            <label class="form-label">Lohateny</label>
            <input type="text" class="form-control" name="lohateny" value="<?= htmlspecialchars($f['lohateny']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Karazana</label>
            <select class="form-select" name="karazana">
                <option <?= $f['karazana']=='Fampianarana'?'selected':'' ?>>Fampianarana</option>
                <option <?= $f['karazana']=='Fanadinana'?'selected':'' ?>>Fanadinana</option>
                <option <?= $f['karazana']=='Fihaonana'?'selected':'' ?>>Fihaonana</option>
                <option <?= $f['karazana']=='Hetsika manokana'?'selected':'' ?>>Hetsika manokana</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Daty</label>
            <input type="date" class="form-control" name="daty" value="<?= htmlspecialchars($f['daty']) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ora manomboka</label>
            <input type="time" class="form-control" name="ora_manomboka" value="<?= htmlspecialchars($f['ora_manomboka']) ?>" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ora mifarana</label>
            <input type="time" class="form-control" name="ora_mifarana" value="<?= htmlspecialchars($f['ora_mifarana']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Laharana efitrano</label>
            <input type="text" class="form-control" name="efitrano" value="<?= htmlspecialchars($f['efitrano']) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Mpampianatra</label>
            <input type="text" class="form-control" name="mpampianatra" value="<?= htmlspecialchars($f['mpampianatra']) ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kilasy</label>
            <input type="text" class="form-control" name="kilasy" value="<?= htmlspecialchars($f['kilasy']) ?>">
        </div>
        <div class="col-md-12">
            <label class="form-label">Fanamarihana (tsy voatery)</label>
            <textarea class="form-control" rows="2" name="fanamarihana"><?= htmlspecialchars($f['fanamarihana']) ?></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tehirizo</button>
            <a href="lisitra_fandaharana.php" class="btn btn-secondary">Hiverina</a>
        </div>
    </form>
</div>
</body>
</html>