<?php
$conn = new mysqli("localhost", "root", "", "timetable");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch entries from the timetable_entries table
$entries_query = "SELECT day, subjects.name as subject_name, teachers.name as teacher_name
                  FROM timetable_entries
                  INNER JOIN subjects ON timetable_entries.subject_id = subjects.id
                  INNER JOIN teachers ON timetable_entries.teacher_id = teachers.id";

$entries_result = $conn->query($entries_query);

$entries = array();

while ($row = $entries_result->fetch_assoc()) {
    $entries[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Entries</title>
    </head>
    <body>

        <h2>Timetable Entries</h2>

        <table border="1">
            <tr>
                <th>Day</th>
                <th>Subject</th>
                <th>Teacher</th>
            </tr>
            <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><?php echo $entry["day"]; ?></td>
                    <td><?php echo $entry["subject_name"]; ?></td>
                    <td><?php echo $entry["teacher_name"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </body>
</html>
