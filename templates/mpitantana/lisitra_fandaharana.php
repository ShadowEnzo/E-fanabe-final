<?php
// Connexion
$mpampifandray = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$fanontaniana = $mpampifandray->query("SELECT * FROM fandaharana ORDER BY daty DESC, ora_manomboka");
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Lisitra fandaharam-potoana</title>
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
    <h2><i class="fas fa-calendar-alt me-2"></i> Lisitry ny fandaharam-potoana rehetra</h2>
    <a href="fampidirana_fandaharana.php" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Hanampy vaovao</a>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Lohateny</th>
                    <th>Karazana</th>
                    <th>Daty</th>
                    <th>Ora</th>
                    <th>Mpampianatra</th>
                    <th>Kilasy</th>
                    <th>Efitrano</th>
                    <th>Fanamarihana</th>
                    <th>Admin</th>
                    <th>Hetsika</th>
                </tr>
            </thead>
            <tbody>
                <?php while($f = $fanontaniana->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= htmlspecialchars($f['lohateny']) ?></td>
                    <td><?= htmlspecialchars($f['karazana']) ?></td>
                    <td><?= htmlspecialchars($f['daty']) ?></td>
                    <td><?= htmlspecialchars($f['ora_manomboka']) ?> - <?= htmlspecialchars($f['ora_mifarana']) ?></td>
                    <td><?= htmlspecialchars($f['mpampianatra']) ?></td>
                    <td><?= htmlspecialchars($f['kilasy']) ?></td>
                    <td><?= htmlspecialchars($f['efitrano']) ?></td>
                    <td><?= htmlspecialchars($f['fanamarihana']) ?></td>
                    <td><?= htmlspecialchars($f['anarana_admin']) ?></td>
                    <td>
                        <a href="ovaina_fandaharana.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <a href="fafana_fandaharana.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hofafana ve?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
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