<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$is_admin = isset($_SESSION['profil']) && ($_SESSION['profil'] === 'admin' || $_SESSION['profil'] === 'secretaire');
$is_self = isset($_SESSION['profil']) && $_SESSION['profil'] === 'mpianatra' && $_SESSION['id'] == $id;
if (!$is_admin && !$is_self) {
    die("<div class='alert alert-danger'>Tsy azo idirana</div>");
}


$stmt = $pdo->prepare("SELECT * FROM mpianatra WHERE id=?");
$stmt->execute([$id]);
$mpianatra = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$mpianatra) {
    die("<div class='alert alert-danger'>Mpianatra tsy hita.</div>");
}

// Fikarakarana (fanampiana, fandraisana,...)
$info = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_admin) {
    if (isset($_POST['add'])) {
        
        $volana = $_POST['volana'];
        $taona = $_POST['taona'];
        $vola = $_POST['vola'];
        $efa_voaloa = isset($_POST['efa_voaloa']) ? 1 : 0;
        $daty_voaloa = $_POST['daty_voaloa'] ?: null;
        $stmt = $pdo->prepare("INSERT INTO ecolage (id_mpianatra, volana, taona, vola, efa_voaloa, daty_voaloa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id, $volana, $taona, $vola, $efa_voaloa, $daty_voaloa]);
        $info = "<div class='alert alert-success'>Écolage nampidirina.</div>";
    }
    if (isset($_POST['edit'])) {
       
        $id_ecolage = $_POST['id_ecolage'];
        $volana = $_POST['volana'];
        $taona = $_POST['taona'];
        $vola = $_POST['vola'];
        $efa_voaloa = isset($_POST['efa_voaloa']) ? 1 : 0;
        $daty_voaloa = $_POST['daty_voaloa'] ?: null;
        $stmt = $pdo->prepare("UPDATE ecolage SET volana=?, taona=?, vola=?, efa_voaloa=?, daty_voaloa=? WHERE id=?");
        $stmt->execute([$volana, $taona, $vola, $efa_voaloa, $daty_voaloa, $id_ecolage]);
        $info = "<div class='alert alert-success'>Écolage nohavaozina.</div>";
    }
    if (isset($_POST['delete'])) {
        $id_ecolage = $_POST['id_ecolage'];
        $pdo->prepare("DELETE FROM ecolage WHERE id=?")->execute([$id_ecolage]);
        $info = "<div class='alert alert-warning'>Écolage voafafa.</div>";
    }
}

$edit_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
$ecolage_edit = null;
if ($edit_id && $is_admin) {
    $stmt = $pdo->prepare("SELECT * FROM ecolage WHERE id=? AND id_mpianatra=?");
    $stmt->execute([$edit_id, $id]);
    $ecolage_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

$stmt = $pdo->prepare("SELECT * FROM ecolage WHERE id_mpianatra=? ORDER BY taona DESC, 
    FIELD(volana,'Janoary','Febroary','Martsa','Avrily','Mey','Jona','Jolay','Aogositra','Septambra','Oktobra','Novambra','Desambra')");
$stmt->execute([$id]);
$ecolages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mois = ['Janoary','Febroary','Martsa','Avrily','Mey','Jona','Jolay','Aogositra','Septambra','Oktobra','Novambra','Desambra'];
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <title>Écolage - <?= htmlspecialchars($mpianatra['anarana']) ?></title>
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
    <h2>
        <i class="fas fa-money-check me-2"></i>
       Saram-pianaran'i <?= htmlspecialchars($mpianatra['anarana']) ?> <?= htmlspecialchars($mpianatra['fanampiny']) ?>
        <small class="text-muted">(<?= htmlspecialchars($mpianatra['kilasy']) ?>)</small>
    </h2>
    <?= $info ?>
    <?php if ($is_admin && !$ecolage_edit): ?>
   
    <form class="row g-2 mb-3" method="post">
        <input type="hidden" name="add" value="1">
        <div class="col-md-2">
            <select name="volana" class="form-select" required>
                <option value="">Volana</option>
                <?php foreach($mois as $m): ?>
                    <option><?= $m ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="taona" class="form-control" min="2020" max="2100" value="<?= date('Y') ?>" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="vola" class="form-control" placeholder="Vola" required>
        </div>
        <div class="col-md-2">
            <input type="checkbox" name="efa_voaloa" id="efa_voaloa_add"> 
            <label for="efa_voaloa_add">Efa voaloa</label>
        </div>
        <div class="col-md-2">
            <input type="date" name="daty_voaloa" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i> Ampidirina</button>
        </div>
    </form>
    <?php endif; ?>

    <?php if ($is_admin && $ecolage_edit): ?>
    <!-- fanovana raha misy  -->
    <form class="row g-2 mb-3" method="post">
        <input type="hidden" name="edit" value="1">
        <input type="hidden" name="id_ecolage" value="<?= $ecolage_edit['id'] ?>">
        <div class="col-md-2">
            <select name="volana" class="form-select" required>
                <?php foreach($mois as $m): ?>
                    <option <?= $ecolage_edit['volana']==$m?'selected':'' ?>><?= $m ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="taona" class="form-control" min="2020" max="2100" value="<?= htmlspecialchars($ecolage_edit['taona']) ?>" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="vola" class="form-control" value="<?= htmlspecialchars($ecolage_edit['vola']) ?>" required>
        </div>
        <div class="col-md-2">
            <input type="checkbox" name="efa_voaloa" id="efa_voaloa_edit" <?= $ecolage_edit['efa_voaloa'] ? 'checked':'' ?>> 
            <label for="efa_voaloa_edit">Efa voaloa</label>
        </div>
        <div class="col-md-2">
            <input type="date" name="daty_voaloa" class="form-control" value="<?= htmlspecialchars($ecolage_edit['daty_voaloa']) ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Tehirizo</button>
            <a href="ecolage_mpianatra.php?id=<?= $id ?>" class="btn btn-secondary">Hanafoana</a>
        </div>
    </form>
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Volana</th>
                <th>Taona</th>
                <th>Vola</th>
                <th>Fandoavana</th>
                <th>Daty voaloa</th>
                <?php if ($is_admin): ?><th>Hetsika</th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ecolages as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['volana']) ?></td>
                <td><?= htmlspecialchars($e['taona']) ?></td>
                <td><?= number_format($e['vola'], 0, ',', ' ') ?> Ar</td>
                <td>
                    <?php if ($e['efa_voaloa']): ?>
                        <span class="badge bg-success">Efa voaloa</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Tsy voaloa</span>
                    <?php endif; ?>
                </td>
                <td><?= $e['daty_voaloa'] ? htmlspecialchars($e['daty_voaloa']) : '-' ?></td>
                <?php if ($is_admin): ?>
                <td>
                    <a href="ecolage_mpianatra.php?id=<?= $id ?>&edit=<?= $e['id'] ?>" class="btn btn-sm btn-outline-primary" title="Ovaina"><i class="fas fa-edit"></i></a>
                    <form method="post" style="display:inline" onsubmit="return confirm('Tena hofafana ve?');">
                        <input type="hidden" name="delete" value="1">
                        <input type="hidden" name="id_ecolage" value="<?= $e['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger" title="Fafana"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            <?php if (!$ecolages): ?>
            <tr><td colspan="<?= $is_admin ? '6':'5' ?>" class="text-center text-muted">Tsy misy saram-pianarana voasoratra.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="javascript:history.back()" class="btn btn-secondary mt-3">Hiverina</a>
</div>
</main>
<?php
include("../tongony.php");  
?>

</body>
<script src="../script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>