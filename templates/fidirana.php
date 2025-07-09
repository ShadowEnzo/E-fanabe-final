<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$hafatra = "";

// Fikirakirana ny fangatahana fidirana
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solonanarana = trim($_POST['solonanarana']);
    $tenimiafina = $_POST['tenimiafina'];
    $profil = $_POST['profil'];

    if ($profil === "mpampianatra") {
        $stmt = $pdo->prepare("SELECT * FROM mpampianatra WHERE solonanarana = ?");
        $stmt->execute([$solonanarana]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($tenimiafina, $user['tenimiafina'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['anarana'] = $user['anarana'];
            $_SESSION['solonanarana'] = $user['solonanarana'];
            $_SESSION['profil'] = 'mpampianatra';
            $_SESSION['matiere'] = $user['matiere'];
            session_write_close(); // <-- Ajout ici
            header("Location: mpampianatra/lohany_mpampianatra.php");
            exit;
        } else {
            $hafatra = '<div class="alert alert-danger">Misy fandisoana ny anarana na tenimiafina ho an\'ny mpampianatra.</div>';
        }
    } elseif ($profil === "mpianatra") {
        $stmt = $pdo->prepare("SELECT * FROM mpianatra WHERE solonanarana = ?");
        $stmt->execute([$solonanarana]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($tenimiafina, $user['tenimiafina'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['anarana'] = $user['anarana'];
            $_SESSION['solonanarana'] = $user['solonanarana'];
            $_SESSION['profil'] = 'mpianatra';
            $_SESSION['kilasy'] = $user['kilasy'];
            session_write_close(); // <-- Ajout ici
            header("Location: mpianatra/lohany.php");
            exit;
        } else {
            $hafatra = '<div class="alert alert-danger">Misy fandisoana ny anarana na tenimiafina ho an\'ny mpianatra.</div>';
        }
    } elseif ($profil === "admin") {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE anarana = ?");
        $stmt->execute([$solonanarana]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($tenimiafina, $user['tenimiafina'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['anarana'] = $user['anarana'];
            $_SESSION['profil'] = 'admin';
            session_write_close(); // <-- Ajout ici
            header("Location: mpitantana/fandraisana.php");
            exit;
        } else {
            $hafatra = '<div class="alert alert-danger">Misy fandisoana ny anarana na tenimiafina ho an\'ny admin.</div>';
        }
    } else {
        $hafatra = '<div class="alert alert-danger">Misafidiana andraikitra!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="mg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fidirana - Hiditra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tany-mainty { background-color: #f0f2f5; min-height: 100vh; padding-top: 50px; }
        .trano-fampidirana { background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px; max-width: 400px; margin: 0 auto; }
        .sary-famantarana { display: block; margin: 0 auto 20px; max-width: 200px; }
        .tandrokely { border-bottom: 1px solid #ddd; margin-bottom: 20px; padding-bottom: 10px; text-align: center; }
        .boky-fampidirana { margin-bottom: 15px; }
        .tsindry-hiditra { background-color: #1877f2; border: none; color: white; font-weight: bold; padding: 10px; width: 100%; border-radius: 5px; margin-bottom: 15px; }
        .tsindry-hiditra:hover { background-color: #166fe5; }
    </style>
</head>
<body class="tany-mainty">
    <div class="container">
        <div class="trano-fampidirana">
            <img src="../logo.png" alt="Logo" class="sary-famantarana">
            <h2 class="tandrokely">Hiditra ao amin'ny rafitra</h2>
            <?php if ($hafatra) echo $hafatra; ?>
            <form method="post" autocomplete="off">
                <div class="mb-3 boky-fampidirana">
                    <label for="solonanarana" class="form-label">Solon'anarana</label>
                    <input type="text" class="form-control" id="solonanarana" name="solonanarana" placeholder="Ampidiro ny solon'anaranao" required>
                </div>
                <div class="mb-3 boky-fampidirana">
                    <label for="tenimiafina" class="form-label">Tenimiafina</label>
                    <input type="password" class="form-control" id="tenimiafina" name="tenimiafina" placeholder="Ampidiro ny tenimiafinao" required>
                </div>
                <div class="mb-3 boky-fampidirana">
                    <label for="profil" class="form-label">Andraikitra</label>
                    <select class="form-select" id="profil" name="profil" required>
                        <option value="" selected disabled>Safidio ny andraikitrao</option>
                        <option value="mpampianatra">Mpampianatra</option>
                        <option value="mpianatra">Mpianatra</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn tsindry-hiditra">Hiditra</button>
            </form>
        </div>
    </div>
</body>
</html>