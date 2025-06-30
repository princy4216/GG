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
    <title>Recherche Employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<h1>Recherche d'employés</h1>

<form method="GET" class="mb-4">
    <div class="mb-3">
        <label>Département :</label>
        <select name="dept_no" class="form-control">
            <option value="">-- Tous --</option>
            <?php foreach ($departments as $d) { ?>
                <option value="<?php echo $d['dept_no']; ?>" <?php if (!empty($_GET['dept_no']) && $_GET['dept_no'] == $d['dept_no']) echo 'selected'; ?>>
                    <?php echo $d['dept_name']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Nom :</label>
        <input type="text" name="nom" class="form-control" value="<?php echo $_GET['nom'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Âge minimum :</label>
        <input type="number" name="age_min" class="form-control" value="<?php echo $_GET['age_min'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label>Âge maximum :</label>
        <input type="number" name="age_max" class="form-control" value="<?php echo $_GET['age_max'] ?? ''; ?>">
    </div>

    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<?php if (!empty($results)) { ?>
    <h2>Résultats :</h2>
    <table class="table table-striped">
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Action</th>
        </tr>
        <?php foreach ($results as $e) { ?>
            <tr>
                <td><?php echo $e['emp_no']; ?></td>
                <td><?php echo $e['last_name']; ?></td>
                <td><?php echo $e['first_name']; ?></td>
                <td><?php echo $e['age']; ?> ans</td>
                <td><a href="employe.php?emp_no=<?php echo $e['emp_no']; ?>" class="btn btn-sm btn-info">Voir</a></td>
            </tr>
        <?php } ?>
    </table>
<?php } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
    <p>Aucun résultat trouvé.</p>
<?php } ?>

<a href="index.php" class="btn btn-secondary mt-3">← Retour à la liste des départements</a>

</body>
</html>
