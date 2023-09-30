<template>
    <div>
        <div class="row mt-2">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Register</h4>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="errors.length != 0">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Check Following Errors</strong><hr>
                            <div v-for="(items, index) in errors" :key="index">
                                <p v-for="(err, k) in items" :key="k">{{ err }}</p>
                            </div>
                        </div>
                        
                        
                        <!-- Register Form Start -->
                        <form method="post" @submit.prevent="handleRegister()">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id="name"
                                    maxlength="255"
                                    v-model="form.name"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    maxlength="255"
                                    v-model="form.email"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    minlength="8"
                                    maxlength="255"
                                    v-model="form.password"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password:</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    maxlength="255"
                                    v-model="form.password_confirmation"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                        <!-- Register Form End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const errors = ref([]); 

const handleRegister = async() => { // Handle User Registeration on submit
    errors.value = [];

    try{
        const response = await axios.post('/api/register', form);
       
        if(response.data.success) {
            store.dispatch('setBToken', response.data.token);
            router.push({name: 'Dashboard'});
        } else {
            setCustomError(response.data.message);
        }
    } catch (error) {
        if(error.response.status == 422) {
            errors.value = error.response.data.errors;
        }
        if(error.response.status == 500) {
            setCustomError(error.response.statusText);
        }
        console.error(error);
    }
};

const setCustomError = (message) => { // set custom error object
    errors.value= { custom_error : [ message ] };
}

</script>

<style lang="scss" scoped>

</style>