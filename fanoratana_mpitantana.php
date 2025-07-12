<?php
$pdo = new PDO("mysql:host=localhost;dbname=e-fanabe;charset=utf8mb4", "root", "");
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anarana = trim($_POST['anarana'] ?? '');
    $mailaka= trim($_POST['mailaka'] ?? '');
    $tenimiafina = $_POST['tenimiafina'] ?? '';
    $tenimiafina2 = $_POST['tenimiafina2'] ?? '';

    if (!$anarana|| !$mailaka || !$tenimiafina || !$tenimiafina2) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($mailaka, FILTER_VALIDATE_EMAIL)) {
        $error = "Tsy azo raisina ny adiresy mailaka.";
    } elseif ($tenimiafina !== $tenimiafina2) {
        $error = "Tsy mifanaraka ny tenimifinao";
    } else {
        // Manamarina raha efa misy mailaka
        $stmt = $pdo->prepare("SELECT id FROM admins WHERE mailaka = ?");
        $stmt->execute([$mailaka]);
        if ($stmt->fetch()) {
            $error = "Efa niasa ity mailaka ity";
        } else {
            $hash = password_hash($tenimiafina, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO admins (anarana, mailaka, tenimiafina) VALUES (?, ?, ?)");
            $stmt->execute([$anarana, $mailaka, $hash]);
            $success = "Voasoratra soa amantsara ny mpitantanana !";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fanoratana mpitantana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">FAnoratna Mpitantana</h3>
                </div>
                <div class="card-body">
                    <?php if($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Anarana </label>
                            <input type="text" name="anarana" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adirey mailaka</label>
                            <input type="email" name="mailaka" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tenimiafina</label>
                            <input type="password" name="tenimiafina" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hanamarina tenimiafina</label>
                            <input type="password" name="tenimiafina2" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Hisoratra</button>
                    </form>
                    <br>
                    <a href="/templates/fidirana.php"><button type="submit" class="btn btn-primary w-100">Hiditra</button></a>
                </div>

    </div>
</div>
</body>
</html>