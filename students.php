<?php
include 'db_connect.php';

$sql = "SELECT student_id, name, age, gender, email, dob FROM Students";
$result = $conn->query($sql);

echo "<h2>Students</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Date of Birth</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
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

$conn->close();
?>
