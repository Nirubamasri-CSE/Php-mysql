<?php
include 'db_connect.php';

$sql = "SELECT 
            s.name AS student_name, 
            c.course_name, 
            e.grade, 
            e.enrollment_date
        FROM Students s
        INNER JOIN Enrollments e ON s.student_id = e.student_id
        INNER JOIN Courses c ON e.course_id = c.course_id";

$result = $conn->query($sql);

echo "<h2>Enrollments</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Enrollment Date</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["student_name"]."</td>
                <td>".$row["course_name"]."</td>
                <td>".$row["grade"]."</td>
                <td>".$row["enrollment_date"]."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No enrollments found.";
}

$conn->close();
?>
