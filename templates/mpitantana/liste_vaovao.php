<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM vaovao WHERE id=?")->execute([$id]);
    header("Location: liste_vaovao.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM vaovao ORDER BY daty DESC, ora DESC");
$actu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Vaovao</title>
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
<div class="container py-4">
    <h2><i class="fas fa-newspaper me-2"></i> Fampahafantarana/vaovao (Mpiandraikitra)</h2>
    <a href="fampahafantarana.php" class="btn btn-success mb-3">+ Vaovao/Fampahafantarana</a>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Lohateny</th>
                    <th>Daty</th>
                    <th>Ora</th>
                    <th>Mpandefa</th>
                    <th>Mpandray</th>
                    <th>Votoaty</th>
                    <th>Hetsika</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($actu as $v): ?>
                <tr>
                    <td><?= htmlspecialchars($v['lohateny']) ?></td>
                    <td><?= htmlspecialchars($v['daty']) ?></td>
                    <td><?= htmlspecialchars($v['ora']) ?></td>
                    <td><?= htmlspecialchars($v['mpandefa']) ?></td>
                    <td><?= htmlspecialchars($v['mpandray']) ?></td>
                    <td><?= nl2br(htmlspecialchars($v['votoaty'])) ?></td>
                    <td>
                        <a href="fampahafantarana.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-primary">Ovaina</a>
                        <a href="?delete=<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hofafana ve?');">Fafana</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (!$actu): ?>
                <tr><td colspan="7" class="text-center text-muted">Tsy misy vaovao.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
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