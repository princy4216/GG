<?php
require_once 'includes/functions.php';

if (!isset($_GET['emp_no'])) {
    echo "Aucun employé sélectionné.";
    exit;
}

$emp_no = $_GET['emp_no'];
$salaries = get_salaries_by_employee($emp_no);
$titles = get_titles_by_employee($emp_no);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Historique de l'Employé</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<a href="employe.php?emp_no=<?php echo $emp_no; ?>" class="btn">← Retour à la fiche</a>
<a href="index.php" class="btn">← Retour</a>

<div class="salaire-container">
    <h2>Historique des Salaires</h2>
    <table class="salaire-table">
        <tr><th>Montant</th><th>De</th><th>À</th></tr>
        <?php foreach ($salaries as $sal) : ?>
        <tr>
            <td><?php echo $sal['salary']; ?> $</td>
            <td><?php echo $sal['from_date']; ?></td>
            <td><?php echo $sal['to_date']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="titre-container">
    <h2>Historique des Postes</h2>
    <table class="titre-table">
        <tr><th>Titre</th><th>De</th><th>À</th></tr>
        <?php foreach ($titles as $t) : ?>
        <tr>
            <td><?php echo $t['title']; ?></td>
            <td><?php echo $t['from_date']; ?></td>
            <td><?php echo $t['to_date']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
