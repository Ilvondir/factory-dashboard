<script setup>

</script>

<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; position:fixed; height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Factory</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <inertia-link href="#" class="nav-link active" aria-current="page">
                    Workers
                </inertia-link>
            </li>
            <li>
                <inertia-link href="/" class="nav-link text-white">
                    Materials
                </inertia-link>
            </li>
            <li>
                <inertia-link href="#" class="nav-link text-white">
                    Products
                </inertia-link>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>User</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" style="">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</template>
