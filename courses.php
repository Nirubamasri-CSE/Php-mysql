<?php
include 'db_connect.php';

$sql = "SELECT * FROM Courses";
$result = $conn->query($sql);

echo "<h2>Courses</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Course Name</th><th>Credits</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["course_id"]."</td><td>".$row["course_name"]."</td><td>".$row["credits"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No courses found.";
}

$conn->close();
?>
