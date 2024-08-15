<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Regestir</title>
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
<body>
<?php
require "pages/partials/navbar.php";
?>
<div class="container">
    <h1>Ma'lumotlar</h1>
</div>

<div class="container mt-4">
    <form action="router.php" method="post">
        <table class="table mt-5">
            <thead>
            <tr>
                <th><h5>Name</h5></th>
                <th><h5>Checked</h5></th>
            </tr>
            </thead>
            <tbody>
            <?php $posts = (new Surveys())->getSurveys(); ?>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post) : ?>
                        <tr>
                            <td>
                                <b><?php echo $post['name'] ?></b>
                            </td>
                            <td>
                                <a href="/insert?id=<?php echo $post['id']; ?>" class="btn btn-danger"
                                    title="Shu qatordagi ma'lumotlarni ichiga yo'nalish qo'shadi"><i class="bi bi-pencil-fill"></i>
                                    <b>Variantlarini Ko'rish</b></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>