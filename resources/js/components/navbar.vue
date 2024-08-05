<template>
    <nav class="d-flex justify-content-center gap-4">
        <template v-for="route in routes">
            <router-link class="route-link" :to="route.path">{{ route.name }}</router-link>
        </template>
        <a href="/logout" class="route-link">Logout</a>
    </nav>
</template>

<script>
    export default {
        data () {
            return {
                routes: [
                    { name: 'Students', path: '/students' },
                    { name: 'Profile', path: '/profile' },
                ]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .route-link {
        color: #333;
        text-decoration: none;
    }
    .route-link:hover {
        color: #007bff;
    }
    .route-link.active {
        color: #007bff;
    }
</style>