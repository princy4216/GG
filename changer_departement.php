<?php
require 'includes/functions.php';

if (!isset($_GET['emp_no'])) {
    die("Employé non spécifié.");
}

$emp_no = $_GET['emp_no'];
$departements = get_all_departments();
$actuel = get_current_department($emp_no);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_dept = $_POST['new_dept'];
    $new_date = $_POST['start_date'];

    if ($new_date < $actuel['from_date']) {
        $message = "❌ Erreur : la date est antérieure à l'affectation actuelle.";
    } elseif ($new_dept == $actuel['dept_no']) {
        $message = "❌ Ce département est déjà le département actuel.";
    } else {
        change_department($emp_no, $new_dept, $new_date);
        header("Location: employe.php?emp_no=$emp_no");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Changer de Département</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <a href="index.php" class="btn btn-outline-secondary">← Retour</a>
</head>
<body class="bg-light p-5">
<div class="container">
    <h2 class="mb-4">🔁 Changer de département</h2>
    <p class="mb-3 text-muted">
        Département actuel : <strong><?php echo $actuel['dept_name']; ?></strong> (depuis le <?php echo $actuel['from_date']; ?>)
    </p>

    <?php if ($message): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nouveau département :</label>
            <select name="new_dept" class="form-select" required>
                <option value="">-- Choisir un département --</option>
                <?php foreach ($departements as $d): ?>
                    <?php if ($d['dept_no'] !== $actuel['dept_no']) { ?>
                        <option value="<?php echo $d['dept_no']; ?>"><?php echo $d['dept_name']; ?></option>
                    <?php } ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de début :</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Changer</button>
        <a href="employe.php?emp_no=<?php echo $emp_no; ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
