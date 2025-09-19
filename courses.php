<?php
include 'db_connect.php';

// 1. Show all courses
$sqlAllCourses = "SELECT course_id, course_name, credits, department, semester FROM Courses";
$resultAll = $conn->query($sqlAllCourses);

echo "<h2>All Courses</h2>";
if ($resultAll->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Department</th>
                <th>Semester</th>
            </tr>";
    while($row = $resultAll->fetch_assoc()) {
        echo "<tr>
                <td>".$row["course_id"]."</td>
                <td>".$row["course_name"]."</td>
                <td>".$row["credits"]."</td>
                <td>".$row["department"]."</td>
                <td>".$row["semester"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No courses found.";
}

// 2. LIKE example – search for courses starting with 'C'
$sqlLike = "SELECT * FROM Courses WHERE course_name LIKE 'C%'";
$resultLike = $conn->query($sqlLike);

echo "<h2>Courses starting with 'C'</h2>";
if ($resultLike->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Course Name</th><th>Credits</th></tr>";
    while($row = $resultLike->fetch_assoc()) {
        echo "<tr>
                <td>".$row["course_id"]."</td>
                <td>".$row["course_name"]."</td>
                <td>".$row["credits"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No matching courses.";
}

// 3. Aggregation – total credits by department
$sqlSum = "SELECT department, SUM(credits) AS total_credits FROM Courses GROUP BY department";
$resultSum = $conn->query($sqlSum);

echo "<h2>Total Credits by Department</h2>";
if ($resultSum->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Department</th><th>Total Credits</th></tr>";
    while($row = $resultSum->fetch_assoc()) {
        echo "<tr>
                <td>".$row["department"]."</td>
                <td>".$row["total_credits"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No data.";
}

// 4. Order By – courses sorted by credits (high to low)
$sqlOrder = "SELECT course_name, credits FROM Courses ORDER BY credits DESC";
$resultOrder = $conn->query($sqlOrder);

echo "<h2>Courses Ordered by Credits (High → Low)</h2>";
if ($resultOrder->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Course Name</th><th>Credits</th></tr>";
    while($row = $resultOrder->fetch_assoc()) {
        echo "<tr>
                <td>".$row["course_name"]."</td>
                <td>".$row["credits"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No courses found.";
}

// 5. Subquery – courses with credits greater than the average
$sqlSubquery = "SELECT course_name, credits 
                FROM Courses 
                WHERE credits > (SELECT AVG(credits) FROM Courses)";
$resultSub = $conn->query($sqlSubquery);

echo "<h2>Courses with Credits Above Average</h2>";
if ($resultSub->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Course Name</th><th>Credits</th></tr>";
    while($row = $resultSub->fetch_assoc()) {
        echo "<tr>
                <td>".$row["course_name"]."</td>
                <td>".$row["credits"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No courses above average credits.";
}

// 6. JOIN – list courses with the students enrolled in them
$sqlJoin = "SELECT c.course_name, s.name AS student_name, e.grade
            FROM Courses c
            INNER JOIN Enrollments e ON c.course_id = e.course_id
            INNER JOIN Students s ON e.student_id = s.student_id";
$resultJoin = $conn->query($sqlJoin);

echo "<h2>Courses with Enrolled Students (JOIN)</h2>";
if ($resultJoin->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Course</th><th>Student</th><th>Grade</th></tr>";
    while($row = $resultJoin->fetch_assoc()) {
        echo "<tr>
                <td>".$row["course_name"]."</td>
                <td>".$row["student_name"]."</td>
                <td>".$row["grade"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No enrollments found.";
}

$conn->close();
?>
