<template>
    <div>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
              <div class="container">
                <a class="navbar-brand" href="#">Task Management System</a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavMainId" aria-controls="collapsibleNavMainId"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavMainId">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <router-link active-class="active" tag="li" to="/" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/register" class="nav-link">Register</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link active-class="active" to="/login" class="nav-link">Login</router-link>
                        </li>
                    </ul>
                </div>
          </div>
        </nav>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>
