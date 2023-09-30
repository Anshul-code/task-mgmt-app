<template>
    <div>
        <div class="row mt-2">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Login</h4>


                        <!-- Login Form Start -->
                        <form method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" name="password" id="password" maxlength="255">
                            </div>

                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                        <!-- Login Form End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const alert = ref({
    variant: 'success',
    show: true,
    timeout: 4000,
    message: ''
});

</script>

<style lang="scss" scoped>

</style>