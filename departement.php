<?php
require 'includes/functions.php';

if (isset($_GET['dept_no'])) {
    $dept_no = $_GET['dept_no'];
    $employees = get_employees_by_department($dept_no);
} else {
    echo "Département non spécifié.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employés du département</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<h1>Liste des employés</h1>
<a href="index.php">← Retour à la liste des départements</a>

<table class="table table-striped mt-3">
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date d'embauche</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $emp) { ?>
            <tr>
                <td><?php echo $emp['emp_no']; ?></td>
                <td><?php echo $emp['last_name']; ?></td>
                <td><?php echo $emp['first_name']; ?></td>
                <td><?php echo $emp['hire_date']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>
