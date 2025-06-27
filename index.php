<?php
require 'includes/functions.php';

$departments = get_departments_with_managers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des départements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<h1>Liste des départements et managers</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Département</th>
            <th>Manager</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($departments as $dept) { ?>
            <tr>
                <td>
                    <a href="departement.php?dept_no=<?php echo $dept['dept_no']; ?>">
                        <?php echo $dept['dept_name']; ?>
                    </a>
                </td>
                <td>
                    <?php
                    if ($dept['first_name']) {
                        echo $dept['first_name'] . ' ' . $dept['last_name'];
                    } else {
                        echo 'Aucun manager';
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
<a href="historique.php?emp_no=<?php echo $emp['emp_no']; ?>" class="btn btn-primary mt-3">
    Voir l’historique des salaires et des postes
</a>
<a href="employe.php" class="btn">← Voir les employees</a>

</html>
