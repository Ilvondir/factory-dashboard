<script setup lang="ts">

</script>

<template>
    <div class="col-12 col-md-4 offset-md-4 mt-5">
        <main class="form-signin w-100 m-auto">
            <form>
                <h1 class="h3 mb-3 fw-normal">Please login</h1>

                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mt-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button class="btn btn-primary w-100 py-2 mt-5" type="submit">Login</button>
                <p class="mt-5 mb-3 text-body-secondary">© Factory Dashboard 2024</p>
            </form>
        </main>
    </div>
</template>
