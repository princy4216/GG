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
<a href="recherche.php" class="btn btn-success">🔍 Rechercher un employé</a>

</body>



</html>
