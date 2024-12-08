<template>
    <App>
        <div class="container">
            <button class="toggle-btn" @click="toggleDownloadVisibility">
                {{ isDownloadVisible ? 'Skjul kommentarer' : 'Vis kommentarer' }}
            </button>
      
            <div v-if="isDownloadVisible" class="download-section">
                <h2>Eleverne kan hente deres kommentarer</h2>
            </div>
            <div v-else class="download-section">
                <h2>Eleverne kan ikke hente deres kommentarer</h2>
            </div>
        </div>
    </App>
</template>
  
<script setup>
    import App from '@/js/App.vue';
    import { ref, defineProps } from 'vue';
    import axios from 'axios';
    
    const props = defineProps(['downloadVisible']);
    const isDownloadVisible = ref(props.downloadVisible);
    
    const toggleDownloadVisibility = () => {
        isDownloadVisible.value = !isDownloadVisible.value;

        axios.post('/api/download-visibility', {
            visibility: isDownloadVisible.value,
        });
    };
</script>
  
<style scoped>
    .container {
        padding: 20px;
        text-align: center;
    }

    .toggle-btn {
        background-color: #58bc82;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .toggle-btn:hover {
        background-color: #46a86c;
    }

    .download-section {
        margin-top: 20px;
        padding: 20px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: left;
    }
</style>
  