<template>
    <div v-if="loading" class="loading-modal w-100 h-100 d-flex justify-content-center align-items-center">
        <div :class="['spinner-border', `text-${color}`]" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        loading: {
            type: Boolean,
            required: true
        },
        color: {
            type: String,
            default: 'warning'
        }
    }
}
</script>

<style>
.loading-container {
    position: relative;
}

.loading-modal {
    position: absolute;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.8);
}
</style>
