<?php
$mpampifandray = new PDO('mysql:host=localhost;dbname=e_fanabe;charset=utf8', 'root', '');
$id = $_GET['id'] ?? 0;
$stmt = $mpampifandray->prepare("SELECT * FROM mpampianatra WHERE id=?");
$stmt->execute([$id]);
$mpampianatra = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$mpampianatra) { echo "Mpampianatra tsy hita."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anarana = $_POST['anarana'];
    $fanampiny = $_POST['fanampiny'];
    $cin = $_POST['cin'];
    $daty_nahaterahana = $_POST['daty_nahaterahana'];
    $lahy_vavy = $_POST['lahy_vavy'];
    $taranja = $_POST['taranja'];
    $stmt = $mpampifandray->prepare("
        UPDATE mpampianatra SET anarana=?, fanampiny=?, cin=?, daty_nahaterahana=?, lahy_vavy=?, taranja=? WHERE id=?
    ");
    $stmt->execute([$anarana, $fanampiny, $cin, $daty_nahaterahana, $lahy_vavy, $taranja, $id]);
    header('Location: lisitra_mpampianatra.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="mg">
<head><meta charset="UTF-8"><title>Ovaina mpampianatra</title></head>
<body>
<h2>Ovaina mpampianatra</h2>
<form method="post">
    <label>Anarana: <input name="anarana" value="<?= htmlspecialchars($mpampianatra['anarana']) ?>" required></label><br>
    <label>Fanampiny: <input name="fanampiny" value="<?= htmlspecialchars($mpampianatra['fanampiny']) ?>" required></label><br>
    <label>CIN: <input name="cin" value="<?= htmlspecialchars($mpampianatra['cin']) ?>" required></label><br>
    <label>Daty nahaterahana: <input type="date" name="daty_nahaterahana" value="<?= htmlspecialchars($mpampianatra['daty_nahaterahana']) ?>" required></label><br>
    <label>Lahy/Vavy: 
        <select name="lahy_vavy">
            <option value="lahy" <?= $mpampianatra['lahy_vavy']=='lahy'?'selected':'' ?>>Lahy</option>
            <option value="vavy" <?= $mpampianatra['lahy_vavy']=='vavy'?'selected':'' ?>>Vavy</option>
        </select>
    </label><br>
    <label>Taranja: <input name="taranja" value="<?= htmlspecialchars($mpampianatra['taranja']) ?>"></label><br>
    <button type="submit">Tehirizo</button>
</form>
</body>
</html>