<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$fanontaniana = $mpampifandray->query("SELECT * FROM fahatarana_tsy_fahatongavana ORDER BY daty DESC");
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Fahatarana sy tsy fahatongavana</title>
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
    <div class="container-fluid">
        <h2>Fitantanana fahatarana sy tsy fahantongavana</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sokajy</th>
                                <th>Anarana</th>
                                <th>Fanampiny</th>
                                <th>Kilasy</th>
                                <th>Daty</th>
                                <th>Karazana</th>
                                <th>Fanamarihana</th>
                                <th>Hetsika</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while($f = $fanontaniana->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?= htmlspecialchars($f['sokajy']) ?></td>
                                <td><?= htmlspecialchars($f['anarana']) ?></td>
                                <td><?= htmlspecialchars($f['fanampiny']) ?></td>
                                <td><?= htmlspecialchars($f['kilasy']) ?></td>
                                <td><?= htmlspecialchars($f['daty']) ?></td>
                                <td><?= htmlspecialchars($f['karazana']) ?></td>
                                <td><?= htmlspecialchars($f['fanamarihana']) ?></td>
                                <td>
                                    <a href="ovaina_fahatarana.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <a href="fafana_fahatarana.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tena hofafana ve?');"><i class="fas fa-trash"></i></a>
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
