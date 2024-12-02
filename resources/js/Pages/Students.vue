<template>
    <App>
        <div class="app-container">
            <h1 class="title">Blå Bog - Elever</h1>
            <input 
                type="text" 
                v-model="searchQuery" 
                class="search-bar" 
                placeholder="Søg efter en elev..." 
            />
            <div 
                class="students-grid" 
                :class="{ 'centered-grid': filteredStudents.length <= 5 }"
            >
                <div 
                    class="student-card" 
                    v-for="student in filteredStudents" 
                    :key="student.unilogin_user" 
                    @click="goTo(student)"
                >
                    <img 
                        :src="student.image || '/generic.png'" 
                        alt="Profilbillede" 
                        class="student-image" 
                    />
                    <h2 class="student-name">{{ student.name }}</h2>
                </div>
            </div>
        </div>
    </App>
</template>

<script setup>
    import App from '@/js/App.vue';
    import { ref, computed } from 'vue';

    const props = defineProps(['students']);
    const students = props.students;
    const searchQuery = ref('');

    const filteredStudents = computed(() => {
        if (!searchQuery.value) return students;
        return students.filter((student) =>
            student.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });

    const goTo = (student) => {
        window.location.href = '/student/' + student.unilogin_user;
    };
</script>

<style scoped>
    .app-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
    }

    .search-bar {
        width: 100%;
        max-width: 600px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-bar:focus {
        outline: none;
        border-color: #58bc82;
        box-shadow: 0 0 8px rgba(88, 188, 130, 0.5);
    }

    .students-grid {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        width: 100%;
    }

    .students-grid.centered-grid {
        grid-template-columns: repeat(4, 1fr);
        justify-content: center;
    }

    .students-grid.centered-grid .student-card {
        width: 200px;
        margin: 0 auto;
    }

    .student-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .student-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .student-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 1rem;
    }

    .student-name {
        font-size: 1.2rem;
        color: #333;
    }
</style>
