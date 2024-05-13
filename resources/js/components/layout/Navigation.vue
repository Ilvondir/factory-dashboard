<script setup>

</script>

<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; position:fixed; height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4"><i class="bi-buildings-fill"></i> Factory</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
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
                    <i class="bi-gear"></i> Materials
                </inertia-link>
            </li>
            <li>
                <inertia-link href="#" class="nav-link text-white">
                    <i class="bi-file-bar-graph"></i> Products
                </inertia-link>
            </li>
            <hr>
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
        </ul>
        <hr>
        <inertia-link href="#" class="d-flex align-items-center text-white text-decoration-none"
                      data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi-person display-6"></i> <strong>User</strong>, logout
        </inertia-link>
    </div>
</template>
