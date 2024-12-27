

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etudiant_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$etudiants = [];
$etudiants_sql = "SELECT id, name, matricule FROM etudiants";
$etudiants_result = $conn->query($etudiants_sql);

if ($etudiants_result->num_rows > 0) {
    while ($row = $etudiants_result->fetch_assoc()) {
        $etudiants[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $etudiant_id = $_POST['etudiant_id'];
    $Discipline = $_POST['Discipline'];
    $note = $_POST['note'];

    $sql = "INSERT INTO notes (etudiant_id, Discipline, note) VALUES ('$etudiant_id', '$Discipline', '$note')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add note</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="container">
    <h2 class="my-4">Add note</h2>
    <form action="add_grade.php" method="POST">
        <div class="form-group">
            <label for="etudiant_id">etudiant</label>
            <select class="form-control" id="etudiant_id" name="etudiant_id" required>
                <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?php echo $etudiant['id']; ?>"><?php echo $etudiant['name']; ?> (<?php echo $etudiant['matricule']; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Discipline">Discipline</label>
            <input type="text" class="form-control" id="Discipline" name="Discipline" required>
        </div>
        <div class="form-group">
            <label for="note">note</label>
            <input type="number" step="0.01" class="form-control" id="note" name="note" required>
        </div>
        <button type="submit" class="btn btn-primary">Add note</button>
        <a href="home.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

