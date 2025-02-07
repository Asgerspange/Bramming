<template>
    <App>
        <div class=" row justify-content-center gap-4">
            <div class="d-flex gap-4 justify-content-center">
                <div class="d-flex gap-2">
                    <button v-for="tab in tabs" :key="tab.name" @click="changeTab(tab.name)" :class="{ 'bg-blue-500 text-blue': activeTab === tab.name }" class="px-4 py-2 rounded-md border border-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        {{ tab.label }}
                    </button>
                </div>
            </div>
            <slot />
        </div>
    </App>
</template>
<script setup>
    import App from '@/js/App.vue';
    import { ref } from 'vue';

    const activeTab = ref('users');
    const tabs = [
        { name: 'users', label: 'Brugere' },
        { name: 'actions', label: 'Actions' },
    ];

    const changeTab = (tab) => {
        window.location.href = `/admin/${tab}`;
    };
</script>
