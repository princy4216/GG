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
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">📋 Liste des employés du département</h1>
        <a href="index.php" class="btn btn-secondary">← Retour à la liste des départements</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
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
                            <td>
                                <a href="employe.php?emp_no=<?php echo $emp['emp_no']; ?>" class="text-decoration-none text-primary">
                                    <?php echo $emp['last_name']; ?>
                                </a>
                            </td>
                            <td><?php echo $emp['first_name']; ?></td>
                            <td><?php echo $emp['hire_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
