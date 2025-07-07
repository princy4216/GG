<?php
require 'includes/functions.php';

$limit = 3;

if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
    if ($page < 1) {
        $page = 1;
    }
} else {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$departments = get_departments_paginated($limit, $offset);
$total_departments = get_departments_total_count();

$total_pages = ceil($total_departments / $limit);
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
        <h1>Départements & Managers</h1>
        <a href="recherche.php" class="btn btn-success">🔍 Rechercher un employé</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Département</th>
                <th>Manager</th>
                <th>Nombre d'employés</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $dept) { ?>
                <tr>
                    <td>
                        <a href="departement.php?dept_no=<?php echo $dept['dept_no']; ?>" class="btn btn-outline-dark w-100 text-start">
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
                    <td><?php echo $dept['nb_employes']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?php echo ($page - 1); ?>">← Précédent</a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>

            <?php if ($page < $total_pages) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=<?php echo ($page + 1); ?>">Suivant →</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

</body>
</html>
