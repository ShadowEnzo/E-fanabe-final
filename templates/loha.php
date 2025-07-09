<?php

$avatar = "https://via.placeholder.com/40"; // sary par défaut

// FAngalana sary any amin'ny mpampiasa
try {
    $pdo = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
} catch (Exception $e) {
   
}

if (isset($_SESSION['id']) && isset($_SESSION['profil'])) {
    $id = $_SESSION['id'];
    $profil = $_SESSION['profil'];
    if ($profil === 'mpampianatra') {
        $stmt = $pdo->prepare("SELECT sary FROM mpampianatra WHERE id=?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user['sary'])) {
            $avatar = "/mpitantana/rakitra_sary/mpampianatra/" . htmlspecialchars($user['sary']);
        }
    } elseif ($profil === 'mpianatra') {
        $stmt = $pdo->prepare("SELECT sary FROM mpianatra WHERE id=?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user['sary'])) {
            $avatar = "/mpitantana/rakitra_sary/mpianatra/" . htmlspecialchars($user['sary']);
        }
    }
}
?>
<header class="lohany">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <button class="tsindry-hamburger" id="tsindry-hamburger">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="h4 mb-0">E-Fanabe</h1>
            <div class="d-flex align-items-center">
                <span class="me-3">Tongasoa!</span>
                <img src="<?= $avatar ?>" alt="Sarin'ny mpampiasa" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
            </div>
        </div>
    </div>
</header>