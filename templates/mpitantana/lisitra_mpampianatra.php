<?php
// Connexion à la base de données
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

// Récupération de tous les professeurs
$fanontaniana = $mpampifandray->query("SELECT * FROM mpampianatra ORDER BY anarana ASC");
?>

<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lisitry ny Mpampianatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
    <style>
        .profil-mpampianatra { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; }
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
            <h2><i class="fas fa-users me-2"></i>Lisitry ny Mpampianatra</h2>
            <a href="fanoratana_mpampianatra.php" class="btn btn-success"><i class="fas fa-plus"></i> Hanampy mpampianatra</a>
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
                                <th>CIN</th>
                                <th>Daty nahaterahana</th>
                                <th>Sokajy</th>
                                <th>Telefaona</th>
                                <th>Taranja</th>
                                <th>Tsy tonga/Tara</th>
                                <th>Hetsika</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($mpampianatra = $fanontaniana->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($mpampianatra['sary'])): ?>
                                        <img src="rakitra_sary/mpampianatra/<?= htmlspecialchars($mpampianatra['sary']) ?>" class="profil-mpampianatra" alt="Sary profil">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/40" class="profil-mpampianatra" alt="Profil par défaut">
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($mpampianatra['anarana']) ?></td>
                                <td><?= htmlspecialchars($mpampianatra['fanampiny']) ?></td>
                                <td><?= htmlspecialchars($mpampianatra['cin']) ?></td>
                                <td><?= htmlspecialchars($mpampianatra['daty_nahaterahana']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($mpampianatra['lahy_vavy'])) ?></td>
                                <td><?= htmlspecialchars($mpampianatra['finday']) ?></td>
                                <td><?= htmlspecialchars($mpampianatra['taranja']) ?></td>
                                <td>
                                <a href="fampidirana_fahatarana.php?sokajy=mpampianatra&id_persona=<?= $mpampianatra['id'] ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-add"></i>
                                </a>
                                </td>
                                <td>
<a href="ovaina_mpampianatra.php?id=<?= $mpampianatra['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
<a href="fafana_mpampianatra.php?id=<?= $mpampianatra['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tena hofafana ve?');"><i class="fas fa-trash"></i></a>
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