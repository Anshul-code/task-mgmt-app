<template>
    <div>

        <div class="row mt-2">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Task</h4>
                        
                        <Alert :errors="errors"/>
                        
                        <!-- Create Task Form Start -->
                        <form method="post" @submit.prevent="handleSubmit()">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="title"
                                    id="title"
                                    maxlength="255"
                                    v-model="form.title"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Description:</label>
                                <textarea
                                    class="form-control"
                                    name="description"
                                    id="description"
                                    rows="5"
                                    maxlength="65000"
                                    v-model="form.description"
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select
                                    class="form-select"
                                    name="status"
                                    id="status"
                                    v-model="form.status"
                                    required
                                >
                                    <option value="">-- SELECT --</option>
                                    <option value="incomplete">Incomplete</option>
                                    <option value="under-process">Under Process</option>
                                    <option value="completed">Completed</option>
                                </select>

                            </div>

                            <div class="mb-3">
                                <label for="assinees" class="form-label">Assign To:</label>
                                <select
                                    multiple
                                    class="form-select"
                                    name="assinees[]"
                                    id="assinees"
                                    v-model="form.assinees"
                                    required
                                >
                                    <option :value="item.id" v-for="(item, index) in existingUsers" :key="index">
                                        {{ item.name }} {{ $store?.getters.getUser?.id == item.id ? '(Me)' : '' }}
                                    </option>
                                </select>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        <!-- Create Task Form End -->

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import Alert from '../../components/Alert.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const form = reactive({
    title: '',
    description: '',
    status: '',
    assinees: []
});

const existingUsers = ref([]);
const errors = ref([]); 
const router = useRouter();
const store = useStore();
const axiosConfig = {
    headers : {
        'Authorization': `Bearer ${store.getters.getBToken}`
    }
};

onMounted(() => {
    getExistingUsers();
});

const getExistingUsers = async() => { // Get Users list from api
    try{
        const response = await axios.get('/api/users/list', axiosConfig);
       
        if(response) {
            if(response.data.success) {
                existingUsers.value = response.data.data;
            } else {
                setCustomError(response.data.message);
            }
        }
    } catch (error) {
        console.error(error);
        
        if(error.response) {
            if(error.response.status == 422) {
                errors.value = error.response.data.errors;
            }
            if(error.response.status == 500) {
                setCustomError(error.response.statusText);
            }
        }
    }
};

const handleSubmit = async() => { // Handle Task Form Submit 
    errors.value = [];

    try{
        const response = await axios.post('/api/tasks/store', form, axiosConfig);
       
        if(response) {
            if(response.data.success) {
                toast.success(response.data.message, {timeout: 4000});

                // redirect to dashboard
                router.push({name: 'Dashboard'});
            } else {
                setCustomError(response.data.message);
            }
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
};
</script>

<style lang="css" scoped>

</style>