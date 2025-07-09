<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['profil'] !== 'mpianatra') {
    header('Location: ../fidirana.php');
    exit;
}
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$id_mpianatra = $_SESSION['id'];
$classe = $_SESSION['kilasy'];
$matiere = $_GET['matiere'] ?? 'Matematika';

// Rakitra/Leçons pour cette matière et cette classe
$stmt = $pdo->prepare("SELECT * FROM rakitra WHERE matiere=? AND classe=? ORDER BY date_pub DESC");
$stmt->execute([$matiere, $classe]);
$rakitras = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devoirs pour cette matière et cette classe
$stmt = $pdo->prepare("SELECT * FROM devoirs WHERE matiere=? AND classe=? ORDER BY date_limite DESC");
$stmt->execute([$matiere, $classe]);
$devoirs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Notes pour cette matière et cet élève
$stmt = $pdo->prepare("SELECT * FROM notes WHERE matiere=? AND id_mpianatra=? ORDER BY date_note DESC");
$stmt->execute([$matiere, $id_mpianatra]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($matiere) ?> (Matière)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
include("../loha.php");
include("../sisiny_mpianatra.php");
?>
<main class="votoaty" id="votoaty">
<div class="container py-4">
    <h2><?= htmlspecialchars($matiere) ?> – Kilasy <?= htmlspecialchars($classe) ?></h2>
    <div class="row mt-4">
        <div class="col-md-8">
            <!-- Devoirs matière -->
            <div class="card mb-3">
                <div class="card-header">Devoirs amin'ity matière ity</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach($devoirs as $d): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($d['titre'] ?? '') ?></strong><br>
                                <span class="small text-muted">Daty farany : <?= htmlspecialchars($d['date_limite'] ?? '') ?></span>
                            </div>
                            <?php if($d['fichier']): ?>
                                <a href="<?= htmlspecialchars($d['fichier']) ?>" class="btn btn-sm btn-info" target="_blank">Télécharger</a>
                            <?php endif; ?>
                            <?php
                                // Vérifier si l'élève a déjà rendu ce devoir
                                $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM devoirs_rendus WHERE id_devoir=? AND id_mpianatra=?");
                                $stmt2->execute([$d['id'], $id_mpianatra]);
                                $deja_rendu = $stmt2->fetchColumn();
                            ?>
                            <?php if(!$deja_rendu): ?>
                                <!-- Formulaire d'envoi de devoir -->
                                <form method="post" enctype="multipart/form-data" action="rendre_devoir.php?matiere=<?= urlencode($matiere) ?>">
                                    <input type="hidden" name="id_devoir" value="<?= $d['id'] ?>">
                                    <input type="file" name="fichier" required class="form-control form-control-sm mb-1">
                                    <button class="btn btn-sm btn-success" type="submit">Envoyer</button>
                                </form>
                            <?php else: ?>
                                <span class="badge bg-success">Déjà envoyé</span>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                        <?php if(!$devoirs): ?>
                        <li class="list-group-item text-muted">Tsy misy devoir.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- Rakitra/Leçons -->
            <div class="card mb-3">
                <div class="card-header">Ireo rakitra misy</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach($rakitras as $r): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($r['titre'] ?? '') ?>
                            <?php if($r['fichier']): ?>
                                <a href="<?= htmlspecialchars($r['fichier']) ?>" class="btn btn-sm btn-primary ms-2" target="_blank">Télécharger</a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                        <?php if(!$rakitras): ?>
                        <li class="list-group-item text-muted">Tsy misy rakitra.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Notes matière -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Naoty (<?= htmlspecialchars($matiere) ?>)</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Note</th><th>Date</th><th>Type</th><th>Appreciation</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach($notes as $n): ?>
                            <tr>
                                <td><?= htmlspecialchars($n['note'] ?? '') ?></td>
                                <td><?= htmlspecialchars($n['date_note'] ?? '') ?></td>
                                <td><?= htmlspecialchars($n['type_note'] ?? '') ?></td>
                                <td><?= htmlspecialchars($n['appreciation'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(!$notes): ?>
                        <tr><td colspan="4" class="text-muted">Tsy misy naoty.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php include("../tongony.php"); ?>
</body>
<script src="../script.js"></script>
</html>