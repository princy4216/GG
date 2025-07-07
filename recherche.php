<?php
require 'includes/functions.php';

$departments = get_all_departments();

$dept_no = '';
$nom = '';
$age_min = '';
$age_max = '';

$results = [];
$page = 1;
$limit = 20;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}

$offset = ($page - 1) * $limit;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['dept_no'])) {
        $dept_no = $_GET['dept_no'];
    }
    if (isset($_GET['nom'])) {
        $nom = $_GET['nom'];
    }
    if (isset($_GET['age_min'])) {
        $age_min = $_GET['age_min'];
    }
    if (isset($_GET['age_max'])) {
        $age_max = $_GET['age_max'];
    }

   
    if ($dept_no != '' || $nom != '' || $age_min != '' || $age_max != '') {
        $results = search_employees_paginated_limit($dept_no, $nom, $age_min, $age_max, $limit, $offset);
        $total = count_total_search_limit($dept_no, $nom, $age_min, $age_max);
        $total_pages = ceil($total / $limit);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recherche d'employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <a href="index.php" class="btn btn-link mt-3">← Retour à la liste des départements</a>
</head>
<body class="p-4 bg-light">

<div class="container">
    <h1 class="mb-4">🔍 Recherche d'employés</h1>

    <form method="GET" class="mb-4">
        <label>Département :</label>
        <select name="dept_no" class="form-select mb-3">
            <option value="">-- Tous --</option>
            <?php foreach ($departments as $d) {
                $selected = '';
                if ($dept_no == $d['dept_no']) {
                    $selected = 'selected';
                }
                echo '<option value="' . $d['dept_no'] . '" ' . $selected . '>' . $d['dept_name'] . '</option>';
            } ?>
        </select>

        <label>Nom :</label>
        <input type="text" name="nom" class="form-control mb-3" value="<?php echo $nom; ?>">

        <label>Âge minimum :</label>
        <input type="number" name="age_min" class="form-control mb-3" value="<?php echo $age_min; ?>">

        <label>Âge maximum :</label>
        <input type="number" name="age_max" class="form-control mb-3" value="<?php echo $age_max; ?>">

        <button type="submit" class="btn btn-primary">Rechercher</button>
        <a href="recherche.php" class="btn btn-outline-dark ms-2">Réinitialiser</a>
    </form>

    <?php if (!empty($results)) { ?>
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Numéro</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                    <th>Plus d'informations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $e) { ?>
                    <tr>
                        <td><?php echo $e['emp_no']; ?></td>
                        <td><?php echo $e['last_name']; ?></td>
                        <td><?php echo $e['first_name']; ?></td>
                        <td><?php echo $e['age']; ?> ans</td>
                        <td><a href="employe.php?emp_no=<?php echo $e['emp_no']; ?>" class="btn btn-sm btn-info">Voir</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?dept_no=<?php echo $dept_no; ?>&nom=<?php echo $nom; ?>&age_min=<?php echo $age_min; ?>&age_max=<?php echo $age_max; ?>&page=<?php echo $page - 1; ?>">
                            ← Précédent
                        </a>
                    </li>
                <?php } ?>

                <li class="page-item disabled">
                    <span class="page-link">Page <?php echo $page; ?> / <?php echo $total_pages; ?></span>
                </li>

                <?php if ($page < $total_pages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?dept_no=<?php echo $dept_no; ?>&nom=<?php echo $nom; ?>&age_min=<?php echo $age_min; ?>&age_max=<?php echo $age_max; ?>&page=<?php echo $page + 1; ?>">
                            Suivant →
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } else if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($dept_no != '' || $nom != '' || $age_min != '' || $age_max != '')) { ?>
       
        <div class="alert alert-warning">Aucun résultat trouvé.</div>
    <?php } ?>

   
</div>

</body>
</html>
