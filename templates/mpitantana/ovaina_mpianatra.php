<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e-fanabe;charset=utf8', 'root', '');
$id = $_GET['id'] ?? 0;
$stmt = $mpampifandray->prepare("SELECT * FROM mpianatra WHERE id=?");
$stmt->execute([$id]);
$mpianatra = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mpianatra) { echo "Mpianatra tsy hita."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anarana = $_POST['anarana'];
    $fanampiny = $_POST['fanampiny'];
    $daty_nahaterahana = $_POST['daty_nahaterahana'];
    $lahy_vavy = $_POST['lahy_vavy'];
    $kilasy = $_POST['kilasy'];
    $stmt = $mpampifandray->prepare("
        UPDATE mpianatra SET anarana=?, fanampiny=?, daty_nahaterahana=?, lahy_vavy=?, kilasy=? WHERE id=?
    ");
    $stmt->execute([$anarana, $fanampiny, $daty_nahaterahana, $lahy_vavy, $kilasy, $id]);
    header('Location: lisitra_mpianatra.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="mg">
<head><meta charset="UTF-8"><title>Ovaina mpianatra</title></head>
<body>
<h2>Ovaina mpianatra</h2>
<form method="post">
    <label>Anarana: <input name="anarana" value="<?= htmlspecialchars($mpianatra['anarana']) ?>" required></label><br>
    <label>Fanampiny: <input name="fanampiny" value="<?= htmlspecialchars($mpianatra['fanampiny']) ?>" required></label><br>
    <label>Daty nahaterahana: <input type="date" name="daty_nahaterahana" value="<?= htmlspecialchars($mpianatra['daty_nahaterahana']) ?>" required></label><br>
    <label>Lahy/Vavy: 
        <select name="lahy_vavy">
            <option value="lahy" <?= $mpianatra['lahy_vavy']=='lahy'?'selected':'' ?>>Lahy</option>
            <option value="vavy" <?= $mpianatra['lahy_vavy']=='vavy'?'selected':'' ?>>Vavy</option>
        </select>
    </label><br>
    <label>Kilasy: <input name="kilasy" value="<?= htmlspecialchars($mpianatra['kilasy']) ?>"></label><br>
    <button type="submit">Tehirizo</button>
</form>
</body>
</html>