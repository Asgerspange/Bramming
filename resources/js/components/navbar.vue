<template>
    <nav class="d-flex justify-content-center gap-4">
        <template v-for="route in routes">
            <a class="route-link" :href="route.path">{{ route.name }}</a>
        </template>
        <a href="/logout" class="route-link">Logout</a>
    </nav>
</template>

<script>
    export default {
        data () {
            return {
                routes: [
                    { name: 'Elever', path: '/students' },
                    // { name: 'Profil', path: '/profile' },
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