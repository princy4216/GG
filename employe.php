<?php
require 'includes/functions.php';

if (!isset($_GET['emp_no'])) {
    echo "Employé non trouvé.";
    exit;
}

$emp_no = $_GET['emp_no'];
$emp = get_employee_details($emp_no);

if (!$emp) {
    echo "Employé introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fiche Employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   

    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Fiche de l'employé</h1>
        <div>
            <a href="index.php" class="btn btn-outline-secondary">← Retour</a>
            <a href="historique.php?emp_no=<?php echo $emp['emp_no']; ?>" class="btn btn-primary">Historique ↗</a>
        </div>
    </div>
    

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4"><?php echo $emp['first_name'] . ' ' . $emp['last_name']; ?> (<?php echo $emp['emp_no']; ?>)</h4>
            <table class="table table-bordered table-striped">
                <tr><th>Numéro</th><td><?php echo $emp['emp_no']; ?></td></tr>
                <tr><th>Nom</th><td><?php echo $emp['last_name']; ?></td></tr>
                <tr><th>Prénom</th><td><?php echo $emp['first_name']; ?></td></tr>
                <tr><th>Genre</th><td><?php echo $emp['gender']; ?></td></tr>
                <tr><th>Date de naissance</th><td><?php echo $emp['birth_date']; ?></td></tr>
                <tr><th>Date d'embauche</th><td><?php echo $emp['hire_date']; ?></td></tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>
