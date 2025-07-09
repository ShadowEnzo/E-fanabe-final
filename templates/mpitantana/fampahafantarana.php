<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');

// Authentification admin
// if ($_SESSION['profil'] !== 'admin') { header('Location: login.php'); exit; }

$success = "";
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lohateny = $_POST['lohateny'];
    $daty = $_POST['daty'];
    $ora = $_POST['ora'];
    $votoaty = $_POST['votoaty'];
    $mpandefa = $_SESSION['anarana'] ?? $_POST['mpandefa'] ?? 'Admin';
    $mpandray = $_POST['mpandray'];

    if (!empty($_POST['id'])) {
        // MODIFICATION
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE vaovao SET lohateny=?, daty=?, ora=?, votoaty=?, mpandefa=?, mpandray=? WHERE id=?");
        $stmt->execute([$lohateny, $daty, $ora, $votoaty, $mpandefa, $mpandray, $id]);
        $success = "<div class='alert alert-success'>Vaovao nohavaozina!</div>";
    } else {
        // AJOUT
        $stmt = $pdo->prepare("INSERT INTO vaovao (lohateny, daty, ora, votoaty, mpandefa, mpandray) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$lohateny, $daty, $ora, $votoaty, $mpandefa, $mpandray]);
        $success = "<div class='alert alert-success'>Voatahiry ny vaovao!</div>";
    }
}

// Si modification, pré-remplir le formulaire
$edit = null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM vaovao WHERE id=?");
    $stmt->execute([$id]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Hanampy/modifier vaovao/fampahafantarana</title>
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
    <h2 class="mb-4"><i class="fas fa-info-circle me-2"></i> Hanampy / Hanova vaovao na fampahafantarana</h2>
    <?= $success ?>
    <form class="row g-3" method="post" autocomplete="off">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $edit['id'] ?>">
        <?php endif; ?>
        <div class="col-md-12">
            <label class="form-label">Lohateny</label>
            <input type="text" class="form-control" name="lohateny" required value="<?= htmlspecialchars($edit['lohateny'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Daty</label>
            <input type="date" class="form-control" name="daty" required value="<?= htmlspecialchars($edit['daty'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Ora</label>
            <input type="time" class="form-control" name="ora" required value="<?= htmlspecialchars($edit['ora'] ?? '') ?>">
        </div>
        <div class="col-md-12">
            <label class="form-label">Votoaty/Details</label>
            <textarea class="form-control" rows="3" name="votoaty" required><?= htmlspecialchars($edit['votoaty'] ?? '') ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mpandefa</label>
            <input type="text" class="form-control" name="mpandefa" value="<?= htmlspecialchars($_SESSION['anarana'] ?? ($edit['mpandefa'] ?? '')) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mpandray (kilasy, rehetra, mpampianatra, mpianatra...)</label>
            <input type="text" class="form-control" name="mpandray" value="<?= htmlspecialchars($edit['mpandray'] ?? '') ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tehirizo</button>
            <a href="liste_vaovao.php" class="btn btn-secondary">Hiverina</a>
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