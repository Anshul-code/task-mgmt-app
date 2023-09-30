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
                <div class="row">
                    <div class="col-lg-3 mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select
                            class="form-select"
                            name="status"
                            id="status"
                            v-model="filters.status"
                            @change="getTasksData()"
                        >
                            <option value="">ALL</option>
                            <option value="incomplete">Incomplete</option>
                            <option value="under-process">Under Process</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <label for="type" class="form-label">Type:</label>
                        <select
                            class="form-select"
                            name="type"
                            id="type"
                            v-model="filters.type"
                            @change="getTasksData()"
                        >
                            <option value="all">ALL My Tasks</option>
                            <option value="assigned-to-me">Assigned To Me</option>
                            <option value="created-by-me">Created By Me</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th style="width: 35%;">Title</th>
                                <th>Created By</th>
                                <th>Assigned To</th>
                                <th>Status</th>
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
                                    {{ assignees(item.users) }}
                                </td>
                                <td class="text-capitalize">
                                    {{ item.status.replace('-', ' ') }}
                                </td>
                                <td>
                                    <router-link :to="{ name: 'EditTask', params: { id: item.id } }" role="button" class="btn btn-success ms-1" :data-id="item.id">Edit</router-link>
                                    <button type="button" class="btn btn-danger ms-1" :data-id="item.id" @click="deleteTask(item.id)">Delete</button>
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
import { ref, onMounted, reactive, computed } from 'vue';
import { useStore } from 'vuex';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { useToast } from 'vue-toastification'

const store = useStore();
const toast = useToast();
const taskData = ref({});
const filters = reactive({
    type: 'all',
    per_page: 10,
    status: ''
});

const axiosConfig = {
    headers : {
        'Authorization': `Bearer ${store.getters.getBToken}`
    }
};

onMounted(() => {
    getTasksData();
});

const assignees = (items) => {
    if(items) {
        return items.map(function(v) {
            return v.name;
        }).join(',')
    }
    
    return '';
};

const getTasksData = async(page = 1) => { // Get Users list from api
    const params = new URLSearchParams(filters).toString(); 
    try{
        const response = await axios.get(`/api/tasks/index?page=${page}&${params}`, axiosConfig);
       
        if(response) {
            if(response.data.success) {
                taskData.value = response.data.data;
            }
        }
    } catch (error) {
        console.error(error);
    }
};

const deleteTask = async(id) => {
    if(confirm('Are you sure you want to delete this task ?')) {
        try{
            const response = await axios.delete(`/api/tasks/delete/${id}`, axiosConfig);
            console.log(response);
            if(response) {
                if(response.data.success) {
                    toast.success(response.data.message, {timeout: 4000});
                    getTasksData(1);
                } else {
                    toast.error(response.data.message, {timeout: 4000});
                }
            }
        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style lang="css" scoped>
.text-capitalize{
    text-transform:capitalize;
}
</style>