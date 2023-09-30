<template>
    <div>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="variant == 'error' && errors.length != 0">
            <strong>Check Following Errors</strong><hr>
            <div v-for="(items, index) in errors" :key="index">
                <p v-for="(err, k) in items" :key="k">{{ err }}</p>
            </div>
        </div>
        <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="variant == 'success' && errors.length != 0">
            <strong>Success !</strong><hr>
            {{ message }}
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    errors: {
        required: false, 
        type: [Object,Array]
    },
    variant: {
        default: 'error',
    },
    message: {
        required: false, 
        type: String
    },
});
</script>

<style lang="scss" scoped>

</style>