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
function get_all_departments() {
    $conn = connect_db();
    $sql = "SELECT dept_no, dept_name FROM departments ORDER BY dept_name";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    mysqli_close($conn);
    return $data;
}

function search_employees($dept_no, $nom, $age_min, $age_max) {
    
    
    $conn = connect_db();

    if ($age_min == '') $age_min = 0;
    if ($age_max == '') $age_max = 150;

   
    $sql = "SELECT e.emp_no, e.first_name, e.last_name,
                   TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age
            FROM employees e
            JOIN dept_emp de ON e.emp_no = de.emp_no
            WHERE de.to_date > NOW()";

   
    if ($dept_no != '') {
        $sql .= " AND de.dept_no = '$dept_no'";
    }

   
    if ($nom != '') {
        $sql .= " AND e.last_name LIKE '%$nom%'";
    }

    $sql .= " AND TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) BETWEEN $age_min AND $age_max";

    
    $sql .= " ORDER BY e.emp_no";

    $result = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

function get_departments_paginated($limit, $offset) {
    $conn = connect_db();

    $sql = "
        SELECT d.dept_no, d.dept_name, e.first_name, e.last_name
        FROM departments d
        LEFT JOIN dept_manager dm ON d.dept_no = dm.dept_no AND dm.to_date > NOW()
        LEFT JOIN employees e ON dm.emp_no = e.emp_no
        ORDER BY d.dept_name
        LIMIT $limit OFFSET $offset
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

function get_departments_total_count() {
    $conn = connect_db();

    $sql = "SELECT COUNT(*) AS total FROM departments";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($conn);
    return $row['total'];
}
function get_employees_by_department_paginated($dept_no, $limit, $offset) {
    $conn = connect_db();

    $sql = "
        SELECT e.emp_no, e.first_name, e.last_name, e.hire_date
        FROM employees e
        INNER JOIN dept_emp de ON e.emp_no = de.emp_no
        WHERE de.dept_no = '" . $dept_no . "' AND de.to_date > NOW()
        ORDER BY e.last_name, e.first_name
        LIMIT " . $limit . " OFFSET " . $offset;

    $result = mysqli_query($conn, $sql);
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

function get_total_employees_in_department($dept_no) {
    $conn = connect_db();

    $sql = "
        SELECT COUNT(*) AS total
        FROM dept_emp
        WHERE dept_no = '" . $dept_no . "' AND to_date > NOW()";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    mysqli_close($conn);
    return $row['total'];
}


function search_employees_paginated_limit($dept_no, $nom, $age_min, $age_max, $limit, $offset) {
    $conn = connect_db();

    if (!is_numeric($age_min)) {
        $age_min = 0;
    }

    if (!is_numeric($age_max)) {
        $age_max = 1000;
    }

    $conditions = [];

    if ($dept_no != '') {
        $conditions[] = "de.dept_no = '" . $dept_no . "'";
    }

    if ($nom != '') {
        $conditions[] = "e.last_name = '" . $nom . "'";
    }

    $conditions[] = "TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) BETWEEN $age_min AND $age_max";

    $sql = "SELECT e.emp_no, e.first_name, e.last_name,
                   TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age
            FROM employees e
            JOIN dept_emp de ON e.emp_no = de.emp_no";

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $sql .= " ORDER BY e.emp_no LIMIT $offset, $limit";

    $result = mysqli_query($conn, $sql);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

function count_total_search_limit($dept_no, $nom, $age_min, $age_max) {
    $conn = connect_db();

    if (!is_numeric($age_min)) {
        $age_min = 0;
    }

    if (!is_numeric($age_max)) {
        $age_max = 1000;
    }

    $conditions = [];

    if ($dept_no != '') {
        $conditions[] = "de.dept_no = '" . $dept_no . "'";
    }

    if ($nom != '') {
        $conditions[] = "e.last_name = '" . $nom . "'";
    }

    $conditions[] = "TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) BETWEEN $age_min AND $age_max";

    $sql = "SELECT COUNT(*) AS total
            FROM employees e
            JOIN dept_emp de ON e.emp_no = de.emp_no";

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'];
}
