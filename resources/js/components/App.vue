<template>
    <div>
        <Navbar />
        <div class="container pt-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
</script>

<style lang="scss" scoped>

</style>