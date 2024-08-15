<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
        <a class="navbar-brand" href="/admin">
            <h2 class="mb-0">Admin Panel</h2>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home"><h4 class="mb-0">So'rovnomalar </h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/votes"><h4 class="mb-0">Variantlar</h4></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/channels"><h4 class="mb-0"> Kanallarfdh</h4></a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="me-3"><?= $_SESSION['username']; ?></span>
                <a href="/logout" class="text-danger d-flex align-items-center text-decoration-none">
                    <i class="bi bi-box-arrow-right me-2"></i> Log out
                </a>
            </div>
        </div>
    </div>
</nav>