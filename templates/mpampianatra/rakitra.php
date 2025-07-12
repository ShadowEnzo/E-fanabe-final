<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'mpampianatra') { header('Location: ../fidirana.php'); exit; }

$id_prof = $_SESSION['id'] ?? '';


$stmt = $pdo->query("SELECT DISTINCT kilasy FROM mpianatra ORDER BY kilasy");
$classes = $stmt->fetchAll(PDO::FETCH_COLUMN);


$stmt = $pdo->prepare("SELECT DISTINCT taranja FROM mpampianatra WHERE id = ?");
$stmt->execute([$id_prof]);
$matieres = [];
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    foreach(explode(',', $row['taranja']) as $m) {
        $m = trim($m);
        if ($m) $matieres[$m] = $m;
    }
}
if (!$matieres) $matieres = ["Aucune matière trouvée" => "Aucune matière trouvée"];

$classe = $_GET['classe'] ?? ($classes[0] ?? '');
$matiere = $_GET['matiere'] ?? (array_keys($matieres)[0] ?? '');

// MANAMPY FAMPIASANA
$success_devoir = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_devoir'])) {
    $titre = $_POST['titre_devoir'] ?? '';
    $classe_post = $_POST['classe_devoir'] ?? '';
    $matiere_post = $_POST['matiere_devoir'] ?? '';
    $description = $_POST['desc_devoir'] ?? '';
    $date_limite = $_POST['date_limite'] ?? null;
    $fichier = "";
    if (isset($_FILES['fichier_devoir']) && $_FILES['fichier_devoir']['error'] == 0) {
        $fichier = "uploads/devoir/".uniqid()."_".basename($_FILES['fichier_devoir']['name']);
        @mkdir("uploads/devoir",0777,true);
        move_uploaded_file($_FILES['fichier_devoir']['tmp_name'], $fichier);
    }
    if ($matiere_post && $classe_post) {
        $stmt = $pdo->prepare("INSERT INTO devoirs (id_prof, matiere, classe, titre, description, fichier, date_limite) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_prof, $matiere_post, $classe_post, $titre, $description, $fichier, $date_limite]);
        $success_devoir = "<div class='alert alert-success'>Devoir ajouté avec succès !</div>";
    } else {
        $success_devoir = "<div class='alert alert-danger'>Classe ou matière non renseignée !</div>";
    }
}

// mANAPY RAKITRA
$success_rakitra = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_rakitra'])) {
    $titre = $_POST['titre_rakitra'] ?? '';
    $classe_post = $_POST['classe_rakitra'] ?? '';
    $matiere_post = $_POST['matiere_rakitra'] ?? '';
    $fichier = "";
    if (isset($_FILES['fichier_rakitra']) && $_FILES['fichier_rakitra']['error'] == 0) {
        $fichier = "uploads/rakitra/".uniqid()."_".basename($_FILES['fichier_rakitra']['name']);
        @mkdir("uploads/rakitra",0777,true);
        move_uploaded_file($_FILES['fichier_rakitra']['tmp_name'], $fichier);
    }
    if ($matiere_post && $classe_post) {
        $stmt = $pdo->prepare("INSERT INTO rakitra (id_prof, matiere, classe, titre, fichier) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_prof, $matiere_post, $classe_post, $titre, $fichier]);
        $success_rakitra = "<div class='alert alert-success'>Leçon/Rakitra ajoutée avec succès !</div>";
    } else {
        $success_rakitra = "<div class='alert alert-danger'>Classe ou matière non renseignée !</div>";
    }
}

// LISITRY NY FAMPIASAINA TOKONY ATAON'NY OLONA
$stmt = $pdo->prepare("SELECT * FROM devoirs WHERE id_prof=? AND matiere=? AND classe=? ORDER BY date_limite DESC, id DESC");
$stmt->execute([$id_prof, $matiere, $classe]);
$devoirs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// LISITRY NY FAMPIASANA NALEFAN'NY MPIANATRA
$stmt = $pdo->prepare("SELECT d.id, d.titre, d.classe, e.anarana, e.fanampiny, dr.fichier, dr.date_envoi, dr.appreciation
    FROM devoirs d
    JOIN devoirs_rendus dr ON dr.id_devoir = d.id
    JOIN mpianatra e ON dr.id_mpianatra = e.id
    WHERE d.id_prof=? AND d.matiere=? AND d.classe=?
    ORDER BY dr.date_envoi DESC");
$stmt->execute([$id_prof, $matiere, $classe]);
$devoirs_rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT * FROM rakitra WHERE id_prof=? AND matiere=? AND classe=? ORDER BY id DESC");
$stmt->execute([$id_prof, $matiere, $classe]);
$rakitras = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fandrindrana Rakitra</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body>
 <?php
include("../loha.php");  
include("../sisiny_mpampianatra.php");  
?>
<main class="votoaty" id="votoaty">
    <div class="container py-3">
        <form class="mb-3" method="get">
            <label for="classe" class="form-label">Fanavahana isan-kilasy :</label>
            <select name="classe" id="classe" class="form-select w-auto d-inline" onchange="this.form.submit()">
                <?php foreach($classes as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>" <?= $classe==$c?'selected':'' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
            <label for="matiere" class="form-label ms-3">Fanavahana isan-taranja:</label>
            <select name="matiere" id="matiere" class="form-select w-auto d-inline" onchange="this.form.submit()">
                <?php foreach($matieres as $m): ?>
                    <option value="<?= htmlspecialchars($m) ?>" <?= $matiere==$m?'selected':'' ?>><?= htmlspecialchars($m) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <div class="row g-4">
            <!-- Fampiasana -->
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Andatsaka fampiasana</div>
                    <div class="card-body">
                        <?= $success_devoir ?>
                        <form method="post" enctype="multipart/form-data" class="row g-2">
                            <input type="hidden" name="add_devoir" value="1">
                            <div class="col-md-5">
                                <select name="classe_devoir" class="form-select" required>
                                    <option value="">Hisafidy kilasy</option>
                                    <?php foreach($classes as $c): ?>
                                        <option value="<?= htmlspecialchars($c) ?>" <?= $classe==$c?'selected':'' ?>><?= htmlspecialchars($c) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="matiere_devoir" class="form-select" required>
                                    <option value="">Hisafidy taranja</option>
                                    <?php foreach($matieres as $m): ?>
                                        <option value="<?= htmlspecialchars($m) ?>" <?= $matiere==$m?'selected':'' ?>><?= htmlspecialchars($m) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="titre_devoir" class="form-control" required placeholder="Lohateny fampiasana">
                            </div>
                            <div class="col-12">
                                <textarea name="desc_devoir" class="form-control" placeholder="Toro-lalana"></textarea>
                            </div>
                            <div class="col-md-7">
                                <input type="file" name="fichier_devoir" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="date_limite" class="form-control" placeholder="Daty farany">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success w-100" type="submit">Hanampy</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header bg-light fw-bold">Fampiasana hatao (<?= htmlspecialchars($classe) ?>, <?= htmlspecialchars($matiere) ?>)</div>
                    <div class="card-body p-2">
                        <ul class="list-group">
                            <?php foreach($devoirs as $d): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong><?= htmlspecialchars($d['titre'] ?? '') ?></strong>
                                        <?php if($d['date_limite']): ?>
                                            <span class="badge bg-info ms-2"><?= htmlspecialchars($d['date_limite']) ?></span>
                                        <?php endif; ?>
                                        <br>
                                        <small><?= htmlspecialchars($d['description'] ?? '') ?></small>
                                        <?php if(!empty($d['fichier'])): ?>
                                            <a href="<?= htmlspecialchars($d['fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2"><i class="fas fa-eye"></i> Voir</a>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <?php if(!$devoirs): ?>
                                <li class="list-group-item text-muted">Tsy misy fampiasana.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-light fw-bold">Fampiasana nalefan'ny mpianatra</div>
                    <div class="card-body p-2">
                        <ul class="list-group">
                            <?php foreach($devoirs_rendus as $r): ?>
                                <li class="list-group-item">
                                    <strong><?= htmlspecialchars($r['anarana']) ?> <?= htmlspecialchars($r['fanampiny']) ?></strong>
                                    - <span class="text-muted">fampiasana: <?= htmlspecialchars($r['titre']) ?></span>
                                    <?php if(!empty($r['fichier'])): ?>
                                        <a href="<?= htmlspecialchars($r['fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-primary ms-2"><i class="fas fa-eye"></i> Hijery</a>
                                    <?php endif; ?>
                                    <span class="badge bg-secondary ms-2"><?= htmlspecialchars($r['date_envoi']) ?></span>
                                    <?php if($r['appreciation']): ?>
                                        <span class="badge bg-success ms-2"><?= htmlspecialchars($r['appreciation']) ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            <?php if(!$devoirs_rendus): ?>
                                <li class="list-group-item text-muted">Tsy mbola namerina fampiasana.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- RAKITRA -->
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header bg-warning text-dark">Hanampy lesona / rakitra</div>
                    <div class="card-body">
                        <?= $success_rakitra ?>
                        <form method="post" enctype="multipart/form-data" class="row g-2">
                            <input type="hidden" name="add_rakitra" value="1">
                            <div class="col-md-5">
                                <select name="classe_rakitra" class="form-select" required>
                                    <option value="">Hisafidy kilasy</option>
                                    <?php foreach($classes as $c): ?>
                                        <option value="<?= htmlspecialchars($c) ?>" <?= $classe==$c?'selected':'' ?>><?= htmlspecialchars($c) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="matiere_rakitra" class="form-select" required>
                                    <option value="">Hisafidy taranja</option>
                                    <?php foreach($matieres as $m): ?>
                                        <option value="<?= htmlspecialchars($m) ?>" <?= $matiere==$m?'selected':'' ?>><?= htmlspecialchars($m) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="titre_rakitra" class="form-control" required placeholder="Lohateny Lesona">
                            </div>
                            <div class="col-md-8">
                                <input type="file" name="fichier_rakitra" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success w-100" type="submit">Hanampy</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header bg-light fw-bold">Lesona / Rakitra nalefa (<?= htmlspecialchars($classe) ?>, <?= htmlspecialchars($matiere) ?>)</div>
                    <div class="card-body p-2">
                        <ul class="list-group">
                            <?php foreach($rakitras as $r): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= htmlspecialchars($r['titre'] ?? '') ?></span>
                                    <?php if(!empty($r['fichier'])): ?>
                                        <a href="<?= htmlspecialchars($r['fichier']) ?>" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Voir</a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            <?php if(!$rakitras): ?>
                                <li class="list-group-item text-muted">Tsy misy lesona/rakitra lasa.</li>
                            <?php endif; ?>
                        </ul>
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
</body>
</html>