<?php
include 'db_connect.php';

// 1. All Enrollments
$sqlAllEnrollments = "SELECT s.name AS student_name, c.course_name, e.grade, e.enrollment_date
                      FROM Students s
                      INNER JOIN Enrollments e ON s.student_id = e.student_id
                      INNER JOIN Courses c ON e.course_id = c.course_id";
$resultAll = $conn->query($sqlAllEnrollments);

echo "<h2>All Enrollments</h2>";
if ($resultAll->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student</th><th>Course</th><th>Grade</th><th>Date</th></tr>";
    while($row = $resultAll->fetch_assoc()) {
        echo "<tr>
                <td>".$row["student_name"]."</td>
                <td>".$row["course_name"]."</td>
                <td>".$row["grade"]."</td>
                <td>".$row["enrollment_date"]."</td>
              </tr>";
    }
    echo "</table>";
}

// 2. LIKE – enrollments where grade starts with 'A'
$sqlLike = "SELECT * FROM Enrollments WHERE grade LIKE 'A%'";
$resultLike = $conn->query($sqlLike);

echo "<h2>Enrollments with Grade starting 'A'</h2>";
if ($resultLike->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student ID</th><th>Course ID</th><th>Grade</th></tr>";
    while($row = $resultLike->fetch_assoc()) {
        echo "<tr>
                <td>".$row["student_id"]."</td>
                <td>".$row["course_id"]."</td>
                <td>".$row["grade"]."</td>
              </tr>";
    }
    echo "</table>";
}

// 3. SUM + GROUP BY – number of students per course
$sqlGroup = "SELECT c.course_name, COUNT(e.student_id) AS total_students
             FROM Enrollments e
             INNER JOIN Courses c ON e.course_id = c.course_id
             GROUP BY c.course_name";
$resultGroup = $conn->query($sqlGroup);

echo "<h2>Total Students per Course</h2>";
if ($resultGroup->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Course</th><th>Total Students</th></tr>";
    while($row = $resultGroup->fetch_assoc()) {
        echo "<tr><td>".$row["course_name"]."</td><td>".$row["total_students"]."</td></tr>";
    }
    echo "</table>";
}

// 4. ORDER BY – enrollments sorted by grade
$sqlOrder = "SELECT s.name, c.course_name, e.grade
             FROM Enrollments e
             INNER JOIN Students s ON e.student_id = s.student_id
             INNER JOIN Courses c ON e.course_id = c.course_id
             ORDER BY e.grade ASC";
$resultOrder = $conn->query($sqlOrder);

echo "<h2>Enrollments Ordered by Grade</h2>";
if ($resultOrder->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student</th><th>Course</th><th>Grade</th></tr>";
    while($row = $resultOrder->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["course_name"]."</td><td>".$row["grade"]."</td></tr>";
    }
    echo "</table>";
}

// 5. SUBQUERY – students who scored above average grade in each course
$sqlSub = "SELECT s.name, c.course_name, e.grade
           FROM Enrollments e
           INNER JOIN Students s ON e.student_id = s.student_id
           INNER JOIN Courses c ON e.course_id = c.course_id
           WHERE 
             (CASE e.grade 
                WHEN 'A' THEN 4
                WHEN 'B' THEN 3
                WHEN 'C' THEN 2
                WHEN 'D' THEN 1
                ELSE 0 END) >
             (SELECT AVG(
                CASE grade 
                  WHEN 'A' THEN 4
                  WHEN 'B' THEN 3
                  WHEN 'C' THEN 2
                  WHEN 'D' THEN 1
                  ELSE 0 END
              ) FROM Enrollments WHERE course_id = e.course_id)";

$resultSub = $conn->query($sqlSub);

echo "<h2>Students Scoring Above Average in Their Course</h2>";
if ($resultSub->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student</th><th>Course</th><th>Grade</th></tr>";
    while($row = $resultSub->fetch_assoc()) {
        echo "<tr><td>".$row["name"]."</td><td>".$row["course_name"]."</td><td>".$row["grade"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No students found above average.";
}

// 6. JOIN – redundant here (already joined above), but showing course + student
$sqlJoin = "SELECT s.name AS student_name, c.course_name
            FROM Enrollments e
            INNER JOIN Students s ON e.student_id = s.student_id
            INNER JOIN Courses c ON e.course_id = c.course_id";
$resultJoin = $conn->query($sqlJoin);

echo "<h2>Enrollments</h2>"; //join example
if ($resultJoin->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>Student</th><th>Course</th></tr>";
    while($row = $resultJoin->fetch_assoc()) {
        echo "<tr><td>".$row["student_name"]."</td><td>".$row["course_name"]."</td></tr>";
    }
    echo "</table>";
}

$conn->close();
?>
