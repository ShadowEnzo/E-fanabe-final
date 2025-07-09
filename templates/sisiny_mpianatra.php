<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$classe_eleve = $_SESSION['kilasy'] ?? '';
// Récupérer toutes les matières où il y a du contenu pour cette classe
$stmt = $pdo->prepare("
    SELECT DISTINCT matiere FROM (
        SELECT matiere FROM rakitra WHERE classe=?
        UNION
        SELECT matiere FROM devoirs WHERE classe=?
        UNION
        SELECT taranja as matiere FROM mpampianatra
    ) as all_matieres
    ORDER BY matiere
");
$stmt->execute([$classe_eleve, $classe_eleve]);
$matieres = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<nav class="menu-ankavia" id="menu-ankavia">
    <button class="tsindry-hamburger" id="tsindry-hamburger" aria-label="Afficher le menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="pt-3 pb-2 text-center">
        <div class="logo-container">
    <img src="../../logo.png" alt="sary-famantarana" class="logo-img">
</div>
<h5 class="mb-0">Ny kaontinao</h5>
    </div>
    <div class="mt-3">
        <a href="lohany.php"><i class="fas fa-newspaper"></i> Pejy Fandraisana</a>
        <a href="naoty.php"><i class="fas fa-chart-line"></i> Ireo naoty</a>
        <a href="fampiasana_miandry.php"><i class="fas fa-tasks"></i> Ireo fampiasana miandry</a>
        <a href="fandaharam_potoana.php"><i class="fas fa-calendar-alt"></i> Fandaharam-potoana</a>
        <a href="#" id="sokajy-fianarana">
            <i class="fas fa-book"></i> Sokajy fianarana
            <i class="fas fa-chevron-down float-end mt-1" id="chevron-sokajy"></i>
        </a>
        <div class="lisitra-sokajy" id="lisitra-sokajy">
            <?php foreach($matieres as $m): ?>
                <a href="taranja_manokana.php?matiere=<?= urlencode($m) ?>"><?= htmlspecialchars($m) ?></a>
            <?php endforeach; ?>
            <?php if(!$matieres): ?>
                <span class="text-muted ps-2">Tsy misy taranja.</span>
            <?php endif; ?>
        </div>
        <a href="vao2.php"><i class="fas fa-newspaper"></i> Ireo vaovao samihafa</a>
        <a href="http://127.0.0.1:8000/"><i class="fas fa-newspaper"></i> Boty Malagasy</a>
        <a href="/E-fanabe/templates/mpitantana/ecolage_mpianatra.php?id=<?= $_SESSION['id'] ?>"><i class="fas fa-money"></i>Saram-pianarana</a>
        <a href="../mivoaka.php"><i class="fas fa-sign-out"></i> Hivoaka</a>
    </div>
</nav>