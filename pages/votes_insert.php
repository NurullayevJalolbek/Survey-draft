<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Votes Insert</title>
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

        .btn-back {
            background-color: #dc3545;
            border-color: #dc3545;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.375rem;
        }

        .btn-back:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        .btn-add {
            background-color: #28a745;
            border-color: #28a745;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.375rem;
            margin-top: 0.5rem;
        }

        .btn-add:hover {
            background-color: #218838;
            border-color: #218838;
        }
    </style>
</head>

<body>
    <?php
        require 'pages/partials/navbar.php';
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
            $_SESSION['id'] = (int)$_GET['id'];
            $posts = (new Surveys())->getSurveyInsert($_SESSION['id']);
            $surveyName = (new Surveys())->getSurveyName($_SESSION['id']);
        }
    ?>
    <div class="container mt-4">
        <h1><?= $surveyName['name']; ?></h1>
    </div>

    <div class="container mt-4">
        <form action="/insert" method="post">
            <table class="table mt-5">
                <thead>
                <tr>
                    <th><h5>Name</h5></th>
                    <th style="color: blue"><h5>Edit</h5></th>
                    <th style="color: red"><h5>Delete</h5></th>
                </tr>
                </thead>
                <tbody>
                    <?php $editId = $_GET['editId'] ?? false; ?>
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post) : ?>
                                <tr>
                                    <td>
                                        <?php if ($editId == $post['id']): ?>
                                            <input type="hidden" name="editId" value="<?= $post['id']; ?>">
                                            <input type="text" name="editName" value="<?= $post['name']; ?>" style="margin-bottom: 0.5rem;" required>
                                            <br>
                                            <button type="submit" class="btn btn-success"><b>Save</b></button>
                                            <a href="/insert?id=<?= $_SESSION['id']; ?>" class="btn btn-secondary"><b>Cancel</b></a>
                                        <?php else: ?>
                                            <b><?= $post['name']; ?></b>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/insert?id=<?= $_SESSION['id']; ?>&editId=<?= $post['id']; ?>" class="btn btn-primary" style="margin-bottom: 0.5rem;">
                                            <i class="bi bi-pencil-square"></i> <b>Edit</b>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="/votes&delete?id=<?= $post['id']; ?>" class="btn btn-danger">
                                            <i class="bi bi-trash3-fill"></i> <b>Delete</b>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </tbody>
            </table>
        </form>

        <form action="/add&votes" method="post">

            <div class="container mt-4">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text input-group-text-custom">📋</span>
                        <input type="text" class="form-control form-control-custom" placeholder="Enter the name" name="survey_insert"
                               aria-label="Survey" <?php if (!$editId): ?> required <?php endif; ?> >
                    </div>
                    <div class="d-grid">
                        <a href="/votes" class="btn btn-back">
                            <b>Back</b>
                        </a>
                        <button class="btn btn-add" type="submit"><b>Add</b></button>
                    </div>
                </div>
            </div>

        </form>

    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
