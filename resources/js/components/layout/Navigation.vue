<script setup>

</script>

<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; position:fixed; height: 100vh">
        <inertia-link href="/"
                      class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-3"><i class="bi-buildings-fill"></i> Factory</span>
        </inertia-link>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">

            <li class="mb-1 nav-item">
                <a class="btn btn-toggle align-items-center rounded text-white fs-5" data-bs-toggle="collapse"
                   data-bs-target="#manufactory-collapse" aria-expanded="true">
                    <i class="bi-gear"></i> Manufactory
                </a>
                <div class="collapse" id="manufactory-collapse" style="padding-left: 15px">
                    <li class="nav-item">
                        <inertia-link href="/test" class="nav-link text-white" aria-current="page">
                            <i class="bi-building"></i> Departments
                        </inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link href="#" class="nav-link text-white" aria-current="page">
                            <i class="bi-journal-bookmark"></i> Positions
                        </inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link href="#" class="nav-link text-white" aria-current="page">
                            <i class="bi-people"></i> Workers
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/" class="nav-link text-white">
                            <i class="bi-box-seam"></i> Materials
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="#" class="nav-link text-white">
                            <i class="bi-file-bar-graph"></i> Products
                        </inertia-link>
                    </li>
                </div>
            </li>


            <hr>


            <li class="mb-1 nav-item">
                <a class="btn btn-toggle align-items-center rounded text-white fs-5" data-bs-toggle="collapse"
                   data-bs-target="#system-collapse" aria-expanded="true">
                    <i class="bi-device-ssd"></i> System
                </a>
                <div class="collapse" id="system-collapse" style="padding-left: 15px">
                    <li class="nav-item">
                        <inertia-link href="#" class="nav-link text-white" aria-current="page">
                            <i class="bi-file-earmark-person"></i> Users
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link href="/" class="nav-link text-white">
                            <i class="bi-list-columns-reverse"></i> Logs
                        </inertia-link>
                    </li>
                </div>
            </li>

        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               id="dropdown-user" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person display-6"></i>
                <strong>User</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown-user">
                <li class="dropdown-item">You are <strong>admin</strong>.</li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</template>
