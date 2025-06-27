<?php
require 'includes/functions.php';

if (!isset($_GET['emp_no'])) {
    echo "Employé non trouvé.";
    exit;
}

$emp_no = $_GET['emp_no'];
$emp = get_employee_details($emp_no);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Fiche Employé</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<a href="index.php" class="btn">← Retour</a>
<a href="historique.php?emp_no=<?php echo $emp['emp_no']; ?>" class="btn btn-primary mt-3">
    Voir l’historique des salaires et des postes
</a>

<h1>Fiche Employé</h1>



<table>
    <tr><th>Numéro</th><td><?php echo $emp['emp_no']; ?></td></tr>
    <tr><th>Nom</th><td><?php echo $emp['last_name']; ?></td></tr>
    <tr><th>Prénom</th><td><?php echo $emp['first_name']; ?></td></tr>
    <tr><th>Genre</th><td><?php echo $emp['gender']; ?></td></tr>
    <tr><th>Date de naissance</th><td><?php echo $emp['birth_date']; ?></td></tr>
    <tr><th>Date d'embauche</th><td><?php echo $emp['hire_date']; ?></td></tr>
</table>

</body>
</html>
