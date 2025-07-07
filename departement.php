<?php
require 'includes/functions.php';

if (!isset($_GET['dept_no']))
 {
    echo "Département non spécifié.";
    exit;
}

$dept_no = $_GET['dept_no'];

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
}

$limit = 2000;
$offset = ($page - 1) * $limit;

$total = get_total_employees_in_department($dept_no);
$employees = get_employees_by_department_paginated($dept_no, $limit, $offset);
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">Liste des employés du département</h1>
    <a href="index.php" class="btn btn-secondary mb-3">← Retour</a>
   

    

    <table class="table table-striped table-bordered">
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
                    <td><a href="employe.php?emp_no=<?php echo $emp['emp_no']; ?>"><?php echo $emp['last_name']; ?></a></td>
                    <td><?php echo $emp['first_name']; ?></td>
                    <td><?php echo $emp['hire_date']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

   
    <?php if ($total_pages > 1) { ?>
        <nav>
            <ul class="pagination justify-content-center">
             
                <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $page - 1; ?>">← Précédent</a>
                    </li>
                <?php } ?>

               
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>

            
                <?php if ($page < $total_pages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $page + 1; ?>">Suivant →</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>
</div>

</body>
</html>
