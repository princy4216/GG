<?php
require 'includes/functions.php';

$job_stats = get_job_stats();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistiques par Emploi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Statistiques par Emploi</h1>
        <a href="index.php" class="btn btn-secondary">← Retour</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Emploi</th>
                <th>Total Employés</th>
                <th>Hommes</th>
                <th>Femmes</th>
                <th>Salaire Moyen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($job_stats as $stat) { ?>
                <tr>
                    <td><?php echo $stat['title']; ?></td>
                    <td><?php echo $stat['total_employees']; ?></td>
                    <td><?php echo $stat['male_count']; ?></td>
                    <td><?php echo $stat['female_count']; ?></td>
                    <td><?php echo number_format($stat['avg_salary'], 2); ?> $</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>