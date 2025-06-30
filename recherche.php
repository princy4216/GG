<?php
require 'includes/functions.php';


$departments = get_all_departments();


$dept_no = '';
$nom = '';
$age_min = '';
$age_max = '';

$results = [];

// On vérifie si la méthode est GET et qu’au moins un paramètre est présent
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

    // On lance la recherche seulement si au moins un filtre est rempli
    if ($dept_no != '' || $nom != '' || $age_min != '' || $age_max != '') {
        $results = search_employees($dept_no, $nom, $age_min, $age_max);
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
<body class="p-4">

<h1>Recherche d'employés</h1>

<form method="GET" class="mb-4">
    <label>Département :</label>
    <select name="dept_no" class="form-select mb-3">
        <option value="">-- Tous --</option>
        <?php
     
        foreach ($departments as $d) {
            $selected = '';
            if ($dept_no == $d['dept_no']) {
                $selected = 'selected';
            }
            echo '<option value="' . $d['dept_no'] . '" ' . $selected . '>' . $d['dept_name'] . '</option>';
        }
        ?>
    </select>

    <label>Nom :</label>
    <input type="text" name="nom" class="form-control mb-3" value="<?php echo htmlspecialchars($nom); ?>">

    <label>Âge minimum :</label>
    <input type="number" name="age_min" class="form-control mb-3" value="<?php echo htmlspecialchars($age_min); ?>">

    <label>Âge maximum :</label>
    <input type="number" name="age_max" class="form-control mb-3" value="<?php echo htmlspecialchars($age_max); ?>">

    <button type="submit" class="btn btn-primary">Rechercher</button>
    <a href="recherche.php" class="btn btn-secondary ms-2">Réinitialiser</a>
</form>

<?php
if (!empty($results)) {
    echo '<h2>Résultats :</h2>';
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Numéro</th><th>Nom</th><th>Prénom</th><th>Âge</th><th>Action</th></tr></thead><tbody>';
    foreach ($results as $e) {
        echo '<tr>';
        echo '<td>' . $e['emp_no'] . '</td>';
        echo '<td>' . $e['last_name'] . '</td>';
        echo '<td>' . $e['first_name'] . '</td>';
        echo '<td>' . $e['age'] . ' ans</td>';
        echo '<td><a href="employe.php?emp_no=' . $e['emp_no'] . '" class="btn btn-sm btn-info">Voir</a></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
   
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($dept_no != '' || $nom != '' || $age_min != '' || $age_max != '')) {
        echo '<p>Aucun résultat trouvé.</p>';
    }
}
?>



</body>
</html>
