<?php
require 'includes/functions.php';

$departments = get_departments_with_managers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Départements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Départements & Managers</h1>
        <a href="recherche.php" class="btn btn-success">🔍 Rechercher un employé</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
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
                                    echo '<span class="text-muted">Aucun manager</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
