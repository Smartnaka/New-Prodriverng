<?php
session_start();
require '../include/db.php';
require_once '../include/config.php';


$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    // Validate email
    if (!$email) {
        $error_message = "Invalid email format.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id, password FROM drivers WHERE email = ?");
        if (!$stmt) {
            die("Database error: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION['driver_id'] = $row['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "Invalid email or password.";
        }
        $stmt->close();
    }

    // Display any errors
    if (!empty($error_message)) {
        $_SESSION['error_message'] = $error_message;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8') . '</div>';
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pro-Drivers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
      <style>
        body { background-color: #f8f9fa; }
        .button1 {
            background-color: #1C98ED;
            border: none;
            color: white;
            padding: 12px;
            font-size: 17px;
            width: 100%;
            border-radius: 12px;
            cursor: pointer;
        }
        .special-header {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            background: linear-gradient(90deg, #007bff, #00c6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            border-bottom: 3px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
            text-align: center;
        }
        .input-group-text {
            background-color: #e9ecef;
            border-right: 0;
            padding-left: 12px;
        }
        .form-control {
            font-size: 16px;
            padding: 10px 12px;
        }
        .input-group i {
            margin-right: 10px;
        }
        @media (max-width: 576px) {
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .row {
        width: 100%;
    }
}
    </style>
</head>
<body>
<div id="alert-container"></div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="special-header">Driver Login</h2>
            <form id="loginForm" method="post">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <label for="email" class="input-group-text"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <label for="password" class="input-group-text"><i class="fas fa-lock"></i> Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" name="login" class="btn button1">Login</button>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <p class="text-muted">Don't remember your password? <a href="forgot-password.php" class="text-decoration-none fw-bold">Forgot Password</a></p>
                        <p class="text-muted">Don't have an account? <a href="register.php" class="text-decoration-none fw-bold">Create an account</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  // Auto-hide alerts after 4 seconds
  setTimeout(function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      alert.classList.add('fade');
      alert.classList.remove('show');
      setTimeout(() => alert.remove(), 500); // remove after fade-out
    });
  }, 4000); // time in ms
</script>

<script src="../javascript/jquery.min.js"></script>
</body>
</html>