<?php
require_once 'includes/functions.php';

if (!isset($_GET['emp_no'])) {
    echo "Aucun employé sélectionné.";
    exit;
}

$emp_no = $_GET['emp_no'];
$emp = get_employee_details($emp_no);

if (!$emp) {
    echo "Employé introuvable.";
    exit;
}

$salaries = get_salaries_by_employee($emp_no);
$departments_history = get_department_history_by_employee($emp_no); // nouvelle fonction à inclure
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

<h1>Historique de l'Employé</h1>
<h2>Employé : <?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?> (<?php echo $emp['emp_no']; ?>)</h2>


<div class="salaire-container">
    <h2>Historique des Salaires</h2>
    <table class="salaire-table">
        <tr><th>Montant</th><th>De</th><th>À</th></tr>
        <?php if (!empty($salaries)) : ?>
            <?php foreach ($salaries as $sal) : ?>
                <tr>
                    <td><?php echo $sal['salary']; ?> $</td>
                    <td><?php echo $sal['from_date']; ?></td>
                    <td><?php echo $sal['to_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="3">Aucun salaire trouvé.</td></tr>
        <?php endif; ?>
    </table>
</div>

<!-- Historique des Départements -->
<div class="titre-container">
    <h2>Historique des Départements</h2>
    <table class="titre-table">
        <tr><th>Département</th><th>De</th><th>À</th></tr>
        <?php if (!empty($departments_history)) : ?>
            <?php foreach ($departments_history as $dept) : ?>
                <tr>
                    <td><?php echo $dept['dept_name']; ?></td>
                    <td><?php echo $dept['from_date']; ?></td>
                    <td><?php echo $dept['to_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="3">Aucun historique de département trouvé.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
