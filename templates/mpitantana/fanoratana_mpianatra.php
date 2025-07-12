<?php
// Connexion à la base de données
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');

// Message de retour
$hafatra = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anarana = htmlspecialchars($_POST['anarana']);
    $fanampiny = htmlspecialchars($_POST['fanampiny']);
    $daty_nahaterahana = $_POST['daty_nahaterahana'];
    $lahy_vavy = $_POST['lahy_vavy'];
    $ray = htmlspecialchars($_POST['ray']);
    $reny = htmlspecialchars($_POST['reny']);
    $finday_ray = htmlspecialchars($_POST['finday_ray']);
    $finday_reny = htmlspecialchars($_POST['finday_reny']);
    $adiresy = htmlspecialchars($_POST['adiresy']);
    $kilasy = htmlspecialchars($_POST['kilasy']);
    $solonanarana = htmlspecialchars($_POST['solonanarana']);
    $tenimiafina = password_hash($_POST['tenimiafina'], PASSWORD_DEFAULT);

    // Gestion de l’upload de la photo
    $anarana_sary = null;
    if (isset($_FILES['sary']) && $_FILES['sary']['error'] === UPLOAD_ERR_OK) {
        $sary_tmp = $_FILES['sary']['tmp_name'];
        $sary_voalohany = basename($_FILES['sary']['name']);
        $fanitarana = strtolower(pathinfo($sary_voalohany, PATHINFO_EXTENSION));
        $azo_ekena = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fanitarana, $azo_ekena)) {
            if (!is_dir('rakitra_sary/mpianatra')) mkdir('rakitra_sary/mpianatra', 0777, true);
            $anarana_sary = uniqid('mpianatra_').'.'.$fanitarana;
            move_uploaded_file($sary_tmp, 'rakitra_sary/mpianatra/'.$anarana_sary);
        }
    }

    // Vérification unicité du solonanarana
    $fanamarinana = $mpampifandray->prepare("SELECT id FROM mpianatra WHERE solonanarana = ?");
    $fanamarinana->execute([$solonanarana]);
    if ($fanamarinana->fetch()) {
        $hafatra = '<div class="alert alert-danger">Ce nom d\'utilisateur existe déjà.</div>';
    } else {
        $fanoratra = $mpampifandray->prepare("INSERT INTO mpianatra 
            (anarana, fanampiny, daty_nahaterahana, lahy_vavy, ray, reny, finday_ray, finday_reny, adiresy, kilasy, solonanarana, tenimiafina, sary) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $ok = $fanoratra->execute([
            $anarana, $fanampiny, $daty_nahaterahana, $lahy_vavy, $ray, $reny, $finday_ray, $finday_reny, $adiresy, $kilasy, $solonanarana, $tenimiafina, $anarana_sary
        ]);
        if ($ok) {
            $hafatra = '<div class="alert alert-success">Mpianatra voasoratra soa aman-tsara !</div>';
        } else {
            $hafatra = '<div class="alert alert-danger">Nisy olana tamin\'ny fisoratana anarana.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisoratana anarana mpianatra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="../style.css">
</head>
<body >
 <?php
include("../loha.php");  
?>
<?php
include("../sisiny_mpitantana.php");  
?>
<main class="votoaty" id="votoaty">
<main class="votoaty" id="votoaty">
    <div class="container">
        <h2><i class="fas fa-user-plus me-2"></i> Fisoratana anarana mpianatra</h2>
        <?php if ($hafatra) echo $hafatra; ?>
        <form class="row g-3 mt-2" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
                <label class="form-label">Anarana</label>
                <input type="text" class="form-control" name="anarana" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fanampiny</label>
                <input type="text" class="form-control" name="fanampiny" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Daty nahaterahana</label>
                <input type="date" class="form-control" name="daty_nahaterahana" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Lahy/Vavy</label>
                <select class="form-select" name="lahy_vavy" required>
                    <option value="lahy">Lahy</option>
                    <option value="vavy">Vavy</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Anaran'ny ray</label>
                <input type="text" class="form-control" name="ray">
            </div>
            <div class="col-md-6">
                <label class="form-label">Anaran-dreny</label>
                <input type="text" class="form-control" name="reny">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nomeraon-telefaonina ray</label>
                <input type="tel" class="form-control" name="finday_ray">
            </div>
            <div class="col-md-6">
                <label class="form-label">Nomeraon-telefaonina reny</label>
                <input type="tel" class="form-control" name="finday_reny">
            </div>
            <div class="col-md-6">
                <label class="form-label">Adiresy</label>
                <input type="text" class="form-control" name="adiresy">
            </div>
            <div class="col-md-6">
                <label class="form-label">Kilasy</label>
                <input type="text" class="form-control" name="kilasy">
            </div>
            <div class="col-md-6">
                <label class="form-label"><span class="text-danger">*</span> Solon'anarana</label>
                <input type="text" class="form-control" name="solonanarana" required>
            </div>
            <div class="col-md-6">
                <label class="form-label"><span class="text-danger">*</span> Tenimiafina</label>
                <input type="password" class="form-control" name="tenimiafina" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sary (photo de profil)</label>
                <input type="file" class="form-control" name="sary" accept="image/*">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Tehirizo</button>
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