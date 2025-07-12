<?php
// Connexion et récupération des élèves (inchangé)
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

$kilasy_requete = $mpampifandray->query("SELECT DISTINCT kilasy FROM mpianatra ORDER BY kilasy ASC");
$kilasy_liste = $kilasy_requete->fetchAll(PDO::FETCH_COLUMN);

$kilasy_voafantina = isset($_GET['kilasy']) ? $_GET['kilasy'] : '';
if ($kilasy_voafantina && in_array($kilasy_voafantina, $kilasy_liste)) {
    $fanontaniana = $mpampifandray->prepare("SELECT * FROM mpianatra WHERE kilasy = ? ORDER BY anarana ASC");
    $fanontaniana->execute([$kilasy_voafantina]);
} else {
    $fanontaniana = $mpampifandray->query("SELECT * FROM mpianatra ORDER BY anarana ASC");
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisitry ny Mpianatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
    <style>
        .profil-mpianatra { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
    </style>
</head>

<body class="tany-fototra">
 <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpitantana.php");  
?>

<main class="votoaty" id="votoaty">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2><i class="fas fa-users me-2"></i>Lisitry ny Mpianatra</h2>
            <form method="get" class="d-flex align-items-center" id="filtreForm">
                <select class="form-select form-select-sm w-auto" name="kilasy" onchange="document.getElementById('filtreForm').submit()">
                    <option value="">Kilasy rehetra</option>
                    <?php foreach($kilasy_liste as $kilasy): ?>
                        <option value="<?= htmlspecialchars($kilasy) ?>" <?= $kilasy_voafantina === $kilasy ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kilasy) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
            <a href="fanoratana_mpianatra.php" class="btn btn-success"><i class="fas fa-plus"></i> Hanampy mpianatra</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sary</th>
                                <th>Anarana</th>
                                <th>Fanampiny</th>
                                <th>Daty nahaterahana</th>
                                <th>Sokajy</th>
                                <th>Telefaona ray</th>
                                <th>Telefaona reny</th>
                                <th>Kilasy</th>
                                <th>Tsy tonga/tara</th>
                                <th>Saram-pianarana</th>
                                <th>Hetsika</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($mpianatra = $fanontaniana->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($mpianatra['sary'])): ?>
                                        <img src="rakitra_sary/mpianatra/<?= htmlspecialchars($mpianatra['sary']) ?>" class="profil-mpianatra" alt="Sary profil">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/40" class="profil-mpianatra" alt="Profil par défaut">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($mpianatra['anarana']) ?></td>
                                <td><?= htmlspecialchars($mpianatra['fanampiny']) ?></td>
                                <td><?= htmlspecialchars($mpianatra['daty_nahaterahana']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($mpianatra['lahy_vavy'])) ?></td>
                                <td><?= htmlspecialchars($mpianatra['finday_ray']) ?></td>
                                <td><?= htmlspecialchars($mpianatra['finday_reny']) ?></td>
                                <td><?= htmlspecialchars($mpianatra['kilasy']) ?></td>
                                <td>
                                    <a href="fampidirana_fahatarana.php?sokajy=mpianatra&id_persona=<?= $mpianatra['id'] ?>" 
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-add"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="ecolage_mpianatra.php?id=<?= $mpianatra['id'] ?>" class="btn btn-sm btn-outline-info" title="Historique écolage">
                                        <i class="fas fa-money-check"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="ovaina_mpianatra.php?id=<?= $mpianatra['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <a href="fafana_mpianatra.php?id=<?= $mpianatra['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tena hofafana ve?');"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
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