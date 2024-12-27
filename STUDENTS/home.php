<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

$matricule = "";
$student = null;
$grades = [];
if (isset($_POST['matricule'])) {
    $matricule = $_POST['matricule'];
    $student_sql = "SELECT * FROM etudiants WHERE matricule = '$matricule'";
    $student_result = $conn->query($student_sql);

    if ($student_result->num_rows > 0) {
        $student = $student_result->fetch_assoc();
        $student_id = $student['id'];
        $grades_sql = "SELECT * FROM notes WHERE  matricule = '$matricule' ";
        $grades_result = $conn->query($grades_sql);

        if ($grades_result->num_rows > 0) {
            while($row = $grades_result->fetch_assoc()) {
                $grades[] = $row;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="Site de consultation des notes semestrielles ">
    <meta name="author" content="Idriss Mi+">
    <title>RELEVE| EPI-Niger</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="header">
    <img src="img/epiniger.png" alt="" width="75px" height="75px" >
        <nav class="navbar">
            <a href="about.php"  class="">A Propos</a>
            
        </nav>
    </header>
    
<div class="container container-md container-sm">
    <h2 class="my-4">Entrez un N° de Matricule</h2>
    <form action="home.php" method="POST">
        <div class="input-group mb-3 col-md-12 ">
            <input type="text" class="form-control" placeholder="N° Matricule ex: L000/1" name="matricule" value="<?php echo $matricule; ?>">
                    <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </div>

    </form>
    <?php if ($student): ?>
        <h3>Resultats trouvés</h3>
        <div class="row">
            <div class="col-md-5">
                <p  id="str"><strong >ID: </strong><?php echo $student['id']; ?></p>

                <p  id="str"><strong >Matricule: </strong><?php echo $student['matricule']; ?></p>

                <p  id="str"><strong >Nom: </strong><?php echo $student['nom']; ?></p>

                <p  id="str"><strong >Prenom: </strong><?php echo $student['prenom']; ?></p>

                <p  id="str"><strong >Ajouté le: </strong><?php echo $student['add_at']; ?></p>
            </div>
        </div>
  <!---
        <table class="table table-bordered table-hovered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matricule</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Ajouté le</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $student['id']; ?></td>
                    <td><?php echo $student['matricule']; ?></td>
                    <td><?php echo $student['nom']; ?></td>
                    <td><?php echo $student['prenom']; ?></td>
                    <td><?php echo $student['add_at']; ?></td>
                </tr>
            </tbody>
        </table>
    ---->
        <h3>Relevés</h3>
        <table class="table table-bordered table-hovered">
            <thead>
                <tr>
                    <th>Matiere</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $note): ?>
                    <tr>
                        <td><?php echo $note['matiere']; ?></td>
                        <td><?php echo $note['note']; ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($grades)): ?>
                    <tr>
                        <td colspan="2">Notes non disponible</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php elseif ($matricule): ?>
        <div class="alert alert-danger">Aucun etudiants correspondant a ce numero de matricule  <?php echo $matricule; ?>
    </div>
    <?php endif; ?>
  <!---
    <a href="add_student.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Etudiant</a>
    <a href="add_grade.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Note</a>
    --->
</div>

     <footer>
     <p id="foot">Epi-Niger &copy; 2024 Made with ♥ by <a href="http://www.idriss-a.netlify.app"> Idrisx Abba.</a></p>
     </footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>