<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <style>

    </style>
</head>
<body>

<div class="login-card">
    <h3 class="text-center">Member Login</h3>
    <form>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" placeholder="Enter your email">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="register.php">Register</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
