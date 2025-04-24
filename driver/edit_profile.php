<?php
session_start();
include '../include/db.php';

if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['driver_id'];
$query = "SELECT * FROM drivers WHERE id = $id";
$result = mysqli_query($conn, $query);
$driver = mysqli_fetch_assoc($result);

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $experience = $_POST['experience'];
    $license_number = trim($_POST['license_number']);
    $about_me = trim($_POST['about_me']);

    if (empty($error)) {
        $sql = "UPDATE drivers SET address=?, experience=?, license_number=?, about_me=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sissi", $address, $experience, $license_number, $about_me, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: edit_profile.php?updated=1");
        exit();
    }
}

if (isset($_GET['updated'])) {
    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



</head>
<body>
<?php include 'sidebar.php'; ?>

<div class="content bg-white p-4 rounded shadow-sm">
  <h4 class="mb-4">Edit Driver Profile</h4>

  <?php if ($success): ?>
    <div class="alert alert-success show" id="success-alert"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>First Name</label>
      <input type="text" class="form-control" value="<?= $driver['first_name'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label>Last Name</label>
      <input type="text" class="form-control" value="<?= $driver['last_name'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" class="form-control" value="<?= $driver['email'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label>Phone</label>
      <input type="text" class="form-control" value="<?= $driver['phone'] ?>" disabled>
    </div>

    <div class="mb-3">
      <label>Address</label>
      <input type="text" name="address" class="form-control" value="<?= isset($_POST['address']) ? htmlspecialchars($_POST['address']) : $driver['address'] ?? '' ?>">
    </div>

    <div class="mb-3">
      <label>Driving Experience (Years)</label>
      <input type="number" name="experience" class="form-control" min="1" max="50" value="<?= isset($_POST['experience']) ? htmlspecialchars($_POST['experience']) : $driver['experience'] ?? '' ?>">
    </div>

    <div class="mb-3">
      <label>Driver's License Number</label>
      <input type="text" name="license_number" class="form-control" value="<?= isset($_POST['license_number']) ? htmlspecialchars($_POST['license_number']) : $driver['license_number'] ?? '' ?>">
    </div>

    <div class="mb-3">
      <label>About Me</label>
      <textarea name="about_me" class="form-control" rows="3"><?= isset($_POST['about_me']) ? htmlspecialchars($_POST['about_me']) : $driver['about_me'] ?? '' ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
  </form>
</div>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('success-alert');
    if (alert) {
      setTimeout(() => {
        alert.classList.add('fade');
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 500);
      }, 4000);
    }

    if (window.location.search.includes('updated=1')) {
      window.history.replaceState({}, document.title, "edit_profile.php");
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>