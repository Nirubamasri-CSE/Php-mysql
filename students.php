<?php
include 'db_connect.php';

$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

echo "<h2>Students</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Name</th><th>Age</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["student_id"]."</td><td>".$row["name"]."</td><td>".$row["age"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "No students found.";
}

$conn->close();
?>
