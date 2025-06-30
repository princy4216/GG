<?php
require_once 'db_connect.php';



function get_departments_with_managers() {
    $conn = connect_db();

    $sql = "
        SELECT d.dept_no, d.dept_name, e.first_name, e.last_name
        FROM departments d
        LEFT JOIN dept_manager dm ON d.dept_no = dm.dept_no AND dm.to_date > NOW()
        LEFT JOIN employees e ON dm.emp_no = e.emp_no
        ORDER BY d.dept_name
    ";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur SQL: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

//  Liste des employés d’un département
function get_employees_by_department($dept_no) {
    $conn = connect_db();

    $dept_no = mysqli_real_escape_string($conn, $dept_no);

    $sql = "
        SELECT e.emp_no, e.first_name, e.last_name, e.hire_date
        FROM employees e
        JOIN dept_emp de ON e.emp_no = de.emp_no
        WHERE de.dept_no = '$dept_no' AND de.to_date > NOW()
        ORDER BY e.last_name, e.first_name
    ";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur SQL: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

function get_employee_details($emp_no) {
    $conn = connect_db();

    $sql = "
        SELECT emp_no, first_name, last_name, gender, birth_date, hire_date
        FROM employees
        WHERE emp_no = $emp_no
    ";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($conn);
    return $row;
}

function get_salaries_by_employee($emp_no) {
    $conn = connect_db();

    $emp_no = mysqli_real_escape_string($conn, $emp_no);

    $sql = "
        SELECT salary, from_date, to_date
        FROM salaries
        WHERE emp_no = '$emp_no'
        ORDER BY from_date DESC
    ";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur SQL (salaires) : " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}


function get_department_history_by_employee($emp_no) {
    $conn = connect_db();

    $sql = "
        SELECT de.from_date, de.to_date, d.dept_name
        FROM dept_emp de
        JOIN departments d ON de.dept_no = d.dept_no
        WHERE de.emp_no = $emp_no
        ORDER BY de.from_date
    ";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur SQL: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

