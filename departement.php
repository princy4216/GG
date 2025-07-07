<?php
require 'includes/functions.php';

if (!isset($_GET['dept_no'])) {
    echo "Département non spécifié.";
    exit;
}

$dept_no = $_GET['dept_no'];


$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 2000;
$offset = ($page - 1) * $limit;

$total = get_total_employees_in_department($dept_no);
$employees = get_employees_by_department_paginated($dept_no, $limit, $offset);
$total_pages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Employés du département</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-custom text-white">

<header class="sticky-top bg-header shadow-sm p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h2 class="mb-0 fw-bold">🏛️ Département #<?php echo $dept['dept_name'] ?></h2>
        <a href="index.php" class="btn btn-outline-light">⬅ Retour</a>
    </div>
</header>

<main class="container py-5">
    <h1 class="mb-4 fw-bold border-bottom pb-2">Liste des employés</h1>

    <div class="table-responsive shadow rounded">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-light text-dark">
                <tr>
                    <th>Numéro</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date d'embauche</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp): ?>
                <tr>
                    <td><?php echo $emp['emp_no']; ?></td>
                    <td>
                        <a href="employe.php?emp_no=<?php echo $emp['emp_no']; ?>" class="text-decoration-none">
                            <?php echo $emp['last_name']; ?>
                        </a>
                    </td>
                    <td><?php echo $emp['first_name']; ?></td>
                    <td><?php echo $emp['hire_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($total_pages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $page - 1; ?>">← Précédent</a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="departement.php?dept_no=<?php echo $dept_no; ?>&page=<?php echo $page + 1; ?>">Suivant →</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</main>

<footer class="text-center text-muted py-4">
    © <?php echo date('Y'); ?> RH Design – Excellence & Clarté
</footer>

</body>
</html>
