<template>
    <Admin>
        <div class="container">
            <div class="row">
                <div class="col-6">
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
    
                <div class="col-6">
                    <h3>Slet ALLE elever og kommentarer (Til nyt skoleår, sletter ikke lærere)</h3>
                    <button class="remove-btn" @click="deleteStudents">
                        Slet elever
                    </button>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script setup>
    import Admin from '@/js/Pages/Admin.vue';
    import { ref, defineProps } from 'vue';
    import axios from 'axios';
    
    const props = defineProps(['downloadVisible']);
    const isDownloadVisible = ref(props.downloadVisible);
    
    const toggleDownloadVisibility = () => {
        let visibility = isDownloadVisible.value ? 0 : 1;
        
        axios.post('/api/download-visibility', {
            visibility
        })
        .then(response => {
            isDownloadVisible.value = !isDownloadVisible.value;
        })
    };

    const deleteStudents = () => {
        confirm('Er du sikker på at du vil slette alle elever og kommentarer?') &&
        axios.post('/api/delete-students')
        .then(response => {
            alert('Alle elever og kommentarer er slettet');
        })
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

    .remove-btn {
        background-color: rgb(145, 22, 22);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .remove-btn:hover {
        background-color: rgb(255, 0, 0);
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
  