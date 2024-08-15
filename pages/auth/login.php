<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <?php require "pages/partials/link.php"; ?>
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h2 class="card-title">Login</h2>
                        <p class="text-muted">Please enter your credentials</p>
                    </div>
                    <form action="/login" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="username" placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Enter password" required>
                        </div>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?= $_SESSION['error']; ?>
                            </div>
                        <?php endif; ?>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg mt-4">Sign in</button>
                        </div>
                    </form>
                    <hr class="my-4">
                    <div class="text-center">
                        <p class="small text-muted">Don't have an account? <a href="/register" class="text-decoration-none">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+VkVGr1pvlYdU+9J8mkY53+Agkp6a" crossorigin="anonymous"></script>
</body>
</html>
