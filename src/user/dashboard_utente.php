<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profilo</title>
  <link rel="stylesheet" href="../src/template/pages/homepagestyle.css">
</head>
<body>
    <h1>Benvenuto <?= htmlspecialchars($_SESSION['user']['Username']) ?></h1>
    <a href="logout.php" style="color:#eaf7ff;">Logout</a>
    <a href="profilo.php" style="color:#eaf7ff;">Profilo</a>
    <a href="index.php">Homepage</a>
</body>
</html>
