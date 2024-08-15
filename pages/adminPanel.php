<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    <?php
    require "pages/partials/link.php";
    ?>
    <style>
        .input-group-text-custom {
            background-color: #6c757d; /* Secondary color */
            color: #ffffff;
            border-radius: 0.375rem 0 0 0.375rem;
        }

        .form-control-custom {
            border-radius: 0 0.375rem 0.375rem 0;
        }

        .btn-custom {
            border-radius: 0.375rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-custom:hover {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<div>
<?php
    require 'pages/partials/navbar.php';
?>
</div>
<div class="container">
    <h1>Hello <?= $_SESSION['username'] ?></h1>
</div>

    <div class="container mt-4">
        <form action="/admin" method="post">
            <table class="table mt-5">
                <thead>
                <tr>
                    <th><h5>Username</h5></th>
                    <th><h5>User id</h5></th>
                    <th><h5>Password</h5></th>
                    <th><h5>Checked</h5></th>
                </tr>
                </thead>
                <tbody>
                <?php $posts = (new Surveys())->getUsersInfo(); ?>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post) : ?>
                        <tr>
                            <td>
                                <b><?= $post['username'] ?></b>
                            </td>
                            <td>
                                <b><?= $post['userId'] ?></b>
                            </td>
                            <td>
                                <?= '***********'; ?>
                            </td>
                            <td>
                                <a href="/admin&delete?id=<?php echo $post['id']; ?>" class="btn btn-danger"
                                    title="Shu qatordagi ma'lumotni o'chirib yuboradi!"><i class="bi bi-trash3-fill">
                                    </i>  Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>

            <div class="container mt-4">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text input-group-text-custom">👤</span>
                        <input type="text" class="form-control form-control-custom" placeholder="Enter the Name" name="username"
                               aria-label="Survey" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text input-group-text-custom">🔑</span>
                        <input style="margin-right: 1rem;" type="text" class="form-control form-control-custom" placeholder="Enter the User ID" name="userId"
                               aria-label="Userid" required>

                        <span class="input-group-text input-group-text-custom">🔒</span>
                        <input type="password" class="form-control form-control-custom" placeholder="Enter the Password" name="password"
                               aria-label="Password" required>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-success btn-custom" type="submit"><b>Add</b></button>
                    </div>
                </div>
            </div>

        </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>