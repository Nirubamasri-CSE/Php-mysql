<?php
include 'db_connect.php';

// 1. All Students
$sqlAllStudents = "SELECT student_id, name, age, gender, email, dob FROM Students";
$resultAll = $conn->query($sqlAllStudents);

echo "<h2>All Students</h2>";
if ($resultAll->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Email</th><th>DOB</th></tr>";
    while($row = $resultAll->fetch_assoc()) {
        echo "<tr>
                <td>".$row["student_id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["age"]."</td>
                <td>".$row["gender"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["dob"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No students found.";
}

// 2. LIKE – students whose name starts with 'A'
$sqlLike = "SELECT * FROM Students WHERE name LIKE 'A%'";
$resultLike = $conn->query($sqlLike);

echo "<h2>Students with names starting with 'A'</h2>";
if ($resultLike->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Name</th><th>Age</th></tr>";
    while($row = $resultLike->fetch_assoc()) {
        echo "<tr>
                <td>".$row["student_id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["age"]."</td>
              </tr>";
    }
    echo "</table>";
}

// 3. SUM + GROUP BY – average age by gender
$sqlGroup = "SELECT gender, AVG(age) AS avg_age FROM Students GROUP BY gender";
$resultGroup = $conn->query($sqlGroup);

echo "<h2>Average Age by Gender</h2>";
if ($resultGroup->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Gender</th><th>Average Age</th></tr>";
    while($row = $resultGroup->fetch_assoc()) {
        echo "<tr><td>".$row["gender"]."</td><td>".$row["avg_age"]."</td></tr>";
    }
    echo "</table>";
}

// 4. ORDER BY – students sorted by age (youngest → oldest)
$sqlOrder = "SELECT name, age FROM Students ORDER BY age ASC";
$resultOrder = $conn->query($sqlOrder);

echo "<h2>Students Ordered by Age (Young → Old)</h2>";
if ($resultOrder->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Name</th><th>Age</th></tr>";
    while($row = $resultOrder->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["age"]."</td></tr>";
    }
    echo "</table>";
}

// 5. SUBQUERY – students older than average age
$sqlSub = "SELECT name, age FROM Students 
           WHERE age > (SELECT AVG(age) FROM Students)";
$resultSub = $conn->query($sqlSub);

echo "<h2>Students Older Than Average Age</h2>";
if ($resultSub->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Name</th><th>Age</th></tr>";
    while($row = $resultSub->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["age"]."</td></tr>";
    }
    echo "</table>";
}

// 6. JOIN – students with their enrolled courses
$sqlJoin = "SELECT s.name, c.course_name, e.grade
            FROM Students s
            INNER JOIN Enrollments e ON s.student_id = e.student_id
            INNER JOIN Courses c ON e.course_id = c.course_id";
$resultJoin = $conn->query($sqlJoin);

echo "<h2>Students with Enrolled Courses (JOIN)</h2>";
if ($resultJoin->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student</th><th>Course</th><th>Grade</th></tr>";
    while($row = $resultJoin->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["course_name"]."</td><td>".$row["grade"]."</td></tr>";
    }
    echo "</table>";
}

$conn->close();
?>
