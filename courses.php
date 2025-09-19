<?php
include 'db_connect.php';

$sql = "SELECT course_id, course_name, credits, department, semester FROM Courses";
$result = $conn->query($sql);

echo "<h2>Courses</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Department</th>
                <th>Semester</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
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

$conn->close();
?>
