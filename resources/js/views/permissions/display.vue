<template>
    <small>
        <span class="badge badge-danger" v-if="perm.level === 1">{{ perm.name }}</span>
        <span class="badge badge-warning" v-else-if="perm.level === 2">{{ perm.name }}</span>
        <span class="badge badge-primary" v-else-if="perm.level === 3">{{ perm.name }}</span>
        <span class="badge badge-success" v-else>{{ perm.name }}</span>
    </small>
</template>

<script>
    export default {
        name: "permission-display",
        props: {
            permission: {}
        },
        data() {
            return {
                perm: this.permission,
            };
        },
    }
</script>

<style scoped>

</style>
