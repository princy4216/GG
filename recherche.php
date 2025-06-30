<?php
require 'includes/functions.php';

$departments = get_all_departments();
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && (
    isset($_GET['nom']) || isset($_GET['dept_no']) || isset($_GET['age_min']) || isset($_GET['age_max'])
)) {
    $dept_no = $_GET['dept_no'] ?? '';
    $nom = $_GET['nom'] ?? '';
    $age_min = $_GET['age_min'] ?? '';
    $age_max = $_GET['age_max'] ?? '';

    $results = search_employees($dept_no, $nom, $age_min, $age_max);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recherche d'Employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">🔍 Recherche d'employés</h1>
        
        <a href="index.php" class="btn btn-secondary">← Retour aux départements</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Département :</label>
                        <select name="dept_no" class="form-select">
                            <option value="">-- Tous --</option>
                            <?php foreach ($departments as $d) { ?>
                                <option value="<?php echo $d['dept_no']; ?>" <?php if (!empty($_GET['dept_no']) && $_GET['dept_no'] == $d['dept_no']) echo 'selected'; ?>>
                                    <?php echo $d['dept_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nom :</label>
                        <input type="text" name="nom" class="form-control" value="<?php echo $_GET['nom'] ?? ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Âge minimum :</label>
                        <input type="number" name="age_min" class="form-control" value="<?php echo $_GET['age_min'] ?? ''; ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Âge maximum :</label>
                        <input type="number" name="age_max" class="form-control" value="<?php echo $_GET['age_max'] ?? ''; ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>
        </div>
    </div>

    <?php if (!empty($results)) { ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>Résultats :</h4>
                <table class="table table-striped table-bordered align-middle mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>Numéro</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Âge</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $e) { ?>
                            <tr>
                                <td><?php echo $e['emp_no']; ?></td>
                                <td><?php echo $e['last_name']; ?></td>
                                <td><?php echo $e['first_name']; ?></td>
                                <td><?php echo $e['age']; ?> ans</td>
                                <td>
                                    <a href="employe.php?emp_no=<?php echo $e['emp_no']; ?>" class="btn btn-sm btn-info">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) { ?>
        <div class="alert alert-warning mt-4">Aucun résultat trouvé.</div>
    <?php } ?>

</div>

</body>
</html>
