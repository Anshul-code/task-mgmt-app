<template>
    <div>
        <h3>Dashboard</h3>
        <div class="card">
            <div class="card-header">
                <strong class="title float-start">
                    All Tasks
                </strong>
                <router-link to="/tasks/create" class="btn btn-primary float-end">Create Task</router-link>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Created By</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in taskData.data" :key="index">
                                <td>
                                    {{ item.id }}
                                </td>
                                <td>
                                    {{ item.title }}
                                </td>
                                <td>
                                    {{ item.created_by?.name }}
                                </td>
                                <td>
                                    <router-link to="/dashboard" role="button" class="btn btn-success ms-1" :data-id="item.id">Edit</router-link>
                                    <button type="button" class="btn btn-danger ms-1" :data-id="item.id">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <Bootstrap5Pagination
                        :data="taskData"
                        @pagination-change-page="getTasksData"
                        align="right"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';
import { useStore } from 'vuex';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const store = useStore();
const taskData = ref({});
const filters = reactive({
    type: 'all'
});

const axiosConfig = {
    headers : {
        'Authorization': `Bearer ${store.getters.getBToken}`
    }
};

onMounted(() => {
    getTasksData();
});

const getTasksData = async(page = 1) => { // Get Users list from api
    try{
        const response = await axios.post(`/api/tasks/index?page=${page}`, filters, axiosConfig);
       console.log(response.data.data);
        if(response) {
            if(response.data.success) {
                taskData.value = response.data.data;
            }
        }
    } catch (error) {
        console.error(error);
    }
};
</script>

<style lang="scss" scoped>

</style>