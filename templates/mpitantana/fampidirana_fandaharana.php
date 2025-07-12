<?php
session_start();
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

// Récupérer tous les mpampianatra
$mpampianatra_liste = $mpampifandray->query("SELECT id, anarana, fanampiny FROM mpampianatra ORDER BY anarana")->fetchAll(PDO::FETCH_ASSOC);

$anarana_admin = $_SESSION['anarana'] ?? 'AdminDemo';
$hafatra = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lohateny = $_POST['lohateny'];
    $karazana = $_POST['karazana'];
    $daty = $_POST['daty'];
    $ora_manomboka = $_POST['ora_manomboka'];
    $ora_mifarana = $_POST['ora_mifarana'];
    $efitrano = $_POST['efitrano'];
    $kilasy = $_POST['kilasy'];
    $fanamarihana = $_POST['fanamarihana'];
    $anarana_admin = $_POST['anarana_admin'];
    // Multi-sélection
    $mpampianatra_ids = isset($_POST['mpampianatra_ids']) ? $_POST['mpampianatra_ids'] : [];
    $mpampianatra_ids_str = implode(',', $mpampianatra_ids);

    $stmt = $mpampifandray->prepare("INSERT INTO fandaharana (lohateny, karazana, daty, ora_manomboka, ora_mifarana, efitrano, kilasy, fanamarihana, anarana_admin, mpampianatra_ids)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lohateny, $karazana, $daty, $ora_manomboka, $ora_mifarana, $efitrano, $kilasy, $fanamarihana, $anarana_admin, $mpampianatra_ids_str]);
    $hafatra = '<div class="alert alert-success">Agenda voatahiry soa aman-tsara !</div>';
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Hanampy fandaharam-potoana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
     <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpitantana.php");  
?>
<main class="votoaty" id="votoaty">
<div class="container py-5">
    <h2 class="mb-4"><i class="fas fa-calendar-plus me-2"></i> Hanampy fandaharam-potoana</h2>
    <?php if ($hafatra) echo $hafatra; ?>
    <form class="row g-3" method="post" autocomplete="off">
        <input type="hidden" name="anarana_admin" value="<?= htmlspecialchars($anarana_admin) ?>">
        <div class="col-md-6">
            <label class="form-label">Lohateny</label>
            <input type="text" class="form-control" name="lohateny" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Karazana</label>
            <select class="form-select" name="karazana">
                <option>Fampianarana</option>
                <option>Fanadinana</option>
                <option>Fihaonana</option>
                <option>Hetsika manokana</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Daty</label>
            <input type="date" class="form-control" name="daty" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ora manomboka</label>
            <input type="time" class="form-control" name="ora_manomboka" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Ora mifarana</label>
            <input type="time" class="form-control" name="ora_mifarana" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Laharana efitrano</label>
            <input type="text" class="form-control" name="efitrano">
        </div>
        <div class="col-md-6">
            <label class="form-label">Mpampianatra (misafidiana)</label>
            <select class="form-select" name="mpampianatra_ids[]" multiple required size="5">
                <?php foreach ($mpampianatra_liste as $mp): ?>
                    <option value="<?= $mp['id'] ?>">
                        <?= htmlspecialchars($mp['anarana'].' '.$mp['fanampiny']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kilasy</label>
            <input type="text" class="form-control" name="kilasy">
        </div>
        <div class="col-md-12">
            <label class="form-label">Fanamarihana (tsy voatery)</label>
            <textarea class="form-control" rows="2" name="fanamarihana"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tehirizo</button>
        </div>
    </form>
</div>
</main>
<?php
include("../tongony.php");  
?>

</body>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>