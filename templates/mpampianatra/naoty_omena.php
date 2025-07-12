<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpampianatra') {
    header('Location: ../fidirana.php');
    exit;
}

$id_prof = $_SESSION['id'];
$matiere = $_SESSION['matiere'] ?? '';

$stmt = $pdo->prepare("SELECT DISTINCT kilasy FROM mpianatra ORDER BY kilasy");
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_COLUMN);

$classe = $_GET['classe'] ?? ($classes[0] ?? '');

$eleves = [];
if (!empty($classe)) {
    $stmt = $pdo->prepare("SELECT * FROM mpianatra WHERE kilasy=? ORDER BY anarana");
    $stmt->execute([$classe]);
    $eleves = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!is_array($eleves)) { $eleves = []; }
}

//Manampy naoty
$info = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_naoty']) && !empty($classe)) {
    if (!empty($_POST['note']) && is_array($_POST['note'])) {
        foreach($_POST['note'] as $id_mpianatra => $note) {
            $type_note = $_POST['type_note'][$id_mpianatra] ?? '';
            $appreciation = $_POST['appreciation'][$id_mpianatra] ?? '';
            $date_note = $_POST['date_note'][$id_mpianatra] ?? date('Y-m-d');
            // Manamarina naoty
            if (is_numeric($note) && $note >= 0 && $note <= 20 && !empty($type_note)) {
                $stmt = $pdo->prepare("INSERT INTO notes (id_prof, id_mpianatra, matiere, classe, note, date_note, type_note, appreciation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$id_prof, $id_mpianatra, $matiere, $classe, $note, $date_note, $type_note, $appreciation]);
            }
        }
        $info = "<div class='alert alert-success'>Naoty nampidirina!</div>";
    }
}

// Mampiseho ireo naotin'ny kilasy voasafidy
$notes = [];
if (!empty($classe)) {
    $stmt = $pdo->prepare("SELECT n.*, m.anarana, m.fanampiny FROM notes n JOIN mpianatra m ON n.id_mpianatra=m.id WHERE n.id_prof=? AND n.matiere=? AND n.classe=? ORDER BY n.date_note DESC");
    $stmt->execute([$id_prof, $matiere, $classe]);
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!is_array($notes)) { $notes = []; }
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fitantanana naoty (mpampianatra)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include("../loha.php"); ?>
<?php include("../sisiny_mpampianatra.php"); ?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2>Fitantanana naoty – <?= htmlspecialchars($matiere ?? '') ?> (mpampianatra)</h2>
    <?= $info ?>
    <!-- Fitsinjnarana ny kilasy -->
    <form class="row g-2 mb-3" method="get" action="">
        <label class="col-form-label col-auto">kilasy :</label>
        <div class="col-auto">
            <select name="classe" class="form-select" onchange="this.form.submit()">
                <?php foreach($classes as $c): ?>
                <option value="<?= htmlspecialchars($c) ?>" <?= $classe == $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <!-- Toerana famenoana ny naoty -->
    <?php if(!empty($classe) && count($eleves) > 0): ?>
    <form method="post" class="mb-4">
        <input type="hidden" name="add_naoty" value="1">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Anarana</th>
                    <th>Fanampiny</th>
                    <th>Naoty</th>
                    <th>karazana</th>
                    <th>Fanamarihana</th>
                    <th>Daty</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($eleves as $el): ?>
                <tr>
                    <td><?= htmlspecialchars($el['anarana'] ?? '') ?></td>
                    <td><?= htmlspecialchars($el['fanampiny'] ?? '') ?></td>
                    <td>
                        <input type="number" name="note[<?= $el['id'] ?>]" class="form-control" min="0" max="20" step="0.01" required>
                    </td>
                    <td>
                        <select name="type_note[<?= $el['id'] ?>]" class="form-select" required>
                            <option value="Fanadinana">Fanadinana</option>
                            <option value="Devoir">Fampiasana</option>
                            <option value="TP">TP</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="appreciation[<?= $el['id'] ?>]" class="form-control">
                    </td>
                    <td>
                        <input type="date" name="date_note[<?= $el['id'] ?>]" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-success" type="submit">Hanampy naoty</button>
    </form>
    <?php elseif(!empty($classe)): ?>
        <div class="alert alert-info">Tsy misy mpianatra amin'ity kilasy ity.</div>
    <?php endif; ?>
    <!-- Ireo naoty efa misy  -->
    <div class="card">
        <div class="card-header">Naotin'ny kilasy : <b><?= htmlspecialchars($classe ?? '') ?></b></div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Anarana</th>
                        <th>Fanampiny</th>
                        <th>Naoty</th>
                        <th>karazana</th>
                        <th>daty</th>
                        <th>fanamarihana</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($notes as $n): ?>
                    <tr>
                        <td><?= htmlspecialchars($n['anarana'] ?? '') ?></td>
                        <td><?= htmlspecialchars($n['fanampiny'] ?? '') ?></td>
                        <td><?= htmlspecialchars($n['note'] ?? '') ?></td>
                        <td><?= htmlspecialchars($n['type_note'] ?? '') ?></td>
                        <td><?= htmlspecialchars($n['date_note'] ?? '') ?></td>
                        <td><?= htmlspecialchars($n['appreciation'] ?? '') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(!$notes): ?>
                    <tr><td colspan="6" class="text-muted">Tsy misy naoty.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>