<template>
    <div>
        <navbar></navbar>
        <slot />
    </div>
</template>

<script>
    import navbar from './components/navbar.vue'

    export default {
        components: {
            navbar
        }
    }
</script>