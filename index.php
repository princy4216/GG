<?php
require 'includes/functions.php';

$limit = 3;
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$departments = get_departments_paginated($limit, $offset);
$total_departments = get_departments_total_count();
$total_pages = ceil($total_departments / $limit);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Départements - Interface Élégante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-custom text-white">

<header class="sticky-top bg-header shadow-sm p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <h2 class="mb-0 fw-bold">🏛️ Interface </h2>
        <a href="recherche.php" class="btn btn-outline-light">🔍 Rechercher</a>
    </div>
</header>

<main class="container py-5">
    <h1 class="mb-4 fw-bold border-bottom pb-2">Départements & Managers</h1>

    <div class="table-responsive rounded shadow">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead class="table-light text-dark">
                <tr>
                    <th>Département</th>
                    <th>Manager</th>
                    <th>Nombre d'employés</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $dept): ?>
                <tr>
                    <td>
                        <a href="departement.php?dept_no=<?php echo $dept['dept_no']; ?>" class="btn btn-outline-secondary w-100 text-start">
                            <?php echo $dept['dept_name']; ?>
                        </a>
                    </td>
                    <td>
                        <?php
                        if ($dept['first_name']) {
                            echo $dept['first_name'] . ' ' . $dept['last_name'];
                        } else {
                            echo '<span class="text-muted fst-italic">Aucun manager</span>';
                        }
                        ?>
                    </td>
                    <td><?php echo $dept['nb_employes']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $page - 1; ?>">← Précédent</a>
            </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="index.php?page=<?php echo $page + 1; ?>">Suivant →</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</main>

<footer class="text-center text-muted py-4">
    © <?php echo date('Y'); ?> RH Design – Élégance & Performance
</footer>

</body>
</html>
