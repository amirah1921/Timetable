<?php
$conn = new mysqli("localhost", "root", "", "timetable");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch subjects and teachers from the database
$subjects_query = "SELECT id, name FROM subjects";
$teachers_query = "SELECT id, name FROM teachers";

$subjects_result = $conn->query($subjects_query);
$teachers_result = $conn->query($teachers_query);

$subjects = array();
$teachers = array();

while ($row = $subjects_result->fetch_assoc()) {
    $subjects[] = $row;
}

while ($row = $teachers_result->fetch_assoc()) {
    $teachers[] = $row;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST["day"];
    $subject_id = $_POST["subject"];
    $teacher_id = $_POST["teacher"];

    // Insert entry into timetable_entries table
    $insert_query = "INSERT INTO timetable_entries (day, subject_id, teacher_id) VALUES ('$day', $subject_id, $teacher_id)";

    if ($conn->query($insert_query) === TRUE) {
        echo "Entry added successfully!";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Timetable</title>
    </head>
    <body>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="day">Day:</label>
            <input type="text" name="day" required><br>

            <label for="subject">Subject:</label>
            <select name="subject" required>
                <?php
                foreach ($subjects as $subject) {
                    echo "<option value='{$subject["id"]}'>{$subject["name"]}</option>";
                }
                ?>
            </select><br>

            <label for="teacher">Teacher:</label>
            <select name="teacher" required>
                <?php
                foreach ($teachers as $teacher) {
                    echo "<option value='{$teacher["id"]}'>{$teacher["name"]}</option>";
                }
                ?>
            </select><br>

            <input type="submit" value="Add Entry">
        </form>
        <!-- Add a link to view_entries.php -->
        <p><a href="view_entry.php">View Timetable Entries</a></p>

    </body>
</html>