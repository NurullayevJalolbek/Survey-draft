<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        .form-control-textarea-custom {
            border-radius: 0.375rem;
            min-height: 120px; /* Minimum height for textarea */
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
        <h1>So'rov qo'shish</h1>
    </div>
    <div class="container mt-4">
        <form action="/home" method="post">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th><h5>Name</h5></th>
                        <th style="text-align: center"><h5>Description</h5></th>
                        <th><h5>Expired</h5></th>
                        <th><h5>Checked</h5></th>
                    </tr>
                </thead>
                <tbody>
                <?php $posts = (new Surveys())->getSurveys(); ?>
                    <?php $editId = $_GET['editId'] ?? NULL; ?>
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <?php if ($editId == $post['id']): ?>
                                            <input type="hidden" name="editId" value="<?= $post['id']; ?>">
                                            <input type="text" name="editName" value="<?= $post['name']; ?>" style="margin-bottom: 0.5rem;" required>
                                            <button type="submit" class="btn btn-success"><b>Save</b></button>
                                            <a href="/home" class="btn btn-secondary"><b>Cancel</b></a>
                                        <?php else: ?>
                                            <b><?= $post['name']; ?></b>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $post['desc']; ?></td>
                                    <td><?= $post['expired_at']; ?></td>
                                    <td>
                                        <a href="/home?editId=<?= $post['id']; ?>" class="btn btn-primary btn-spacing" style="margin-bottom: 0.5rem;">
                                            <i class="bi bi-pencil-square"></i> <b>Edit</b>
                                        </a>
                                        <a href="/home&delete?id=<?= $post['id']; ?>" class="btn btn-danger">
                                            <i class="bi bi-trash3-fill"></i> <b>Delete</b>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </tbody>
            </table>

        </form>

        <form method="post" action="/add">
            <div class="container mt-4">
                <div class="mb-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text input-group-text-custom">✏️</span>
                        <input type="text" class="form-control form-control-custom" placeholder="Enter the name" name="surveys"
                               <?php if (!$editId): ?>required <?php endif; ?>>
                    </div>
                    <div class="input-group mb-3 w-100">
                        <span class="input-group-text input-group-text-custom">⏱</span>
                        <input type="datetime-local" class="form-control" name="expired_at" placeholder="Enter the expiration date"
                               <?php if (!$editId): ?>required <?php endif; ?>>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text input-group-text-custom">📝</span>
                        <textarea class="form-control form-control-textarea-custom" placeholder="Enter the description" name="desc"
                                  <?php if (!$editId): ?>required <?php endif; ?>></textarea>
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