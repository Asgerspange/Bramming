<template>
    <App>
        <div class="container">
            <h1 class="text-center">Student</h1>
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div class="image-wrapper">
                                <img :src="student?.profile_picture?.picture ?? '/generic.png'" class="card-img-top student-image">
                                <label class="edit-icon">
                                    <span class="material-symbols">edit</span>
                                    <input type="file" ref="fileInput" @change="uploadImage">
                                </label>
                            </div>
                            <h5 class="student-name text-center">{{ student.name }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <template v-if="downloadVisible">
                <div class="mt-4 text-center">
                    <a href="/api/download-comments" class="btn btn-primary">Download kommentarer</a>
                </div>
            </template>
            <div class="mt-4">
                <h4>Du mangler at skrive kommentarer til følgende: (Du har skrevet til {{ totalComments + ' / ' + totalStudents }} elever)</h4>
                <ul class="list-group">
                    <li v-for="student in paginatedStudents" :key="student.name" class="list-group-item d-flex align-items-center gap-2">
                        <img :src="student.profile_picture?.picture ?? '/generic.png'" class="profile-pic">
                        <span @click="goTo(student)" class="student-link">{{ student.name }}</span>
                    </li>
                </ul>
                <Paginator 
                    :rows="10" 
                    :totalRecords="students.length" 
                    :first="first" 
                    @page="onPageChange" 
                    layout="PrevPageLink CurrentPageReport NextPageLink"
                    :currentPageReportTemplate="'Showing {first} to {last} of {totalRecords}'" 
                />
            </div>
        </div>
    </App>
</template>

<script setup>
import App from '@/js/App.vue';
import { ref, defineProps, computed } from 'vue';
import axios from 'axios';

const props = defineProps(['student', 'students', 'totalStudents', 'totalComments', 'downloadVisible']);
const localStudents = ref(props.students);
const first = ref(0);

const paginatedStudents = computed(() => {
    return localStudents.value.slice(first.value, first.value + 10);
});

const onPageChange = (event) => {
    first.value = event.first;
};

const goTo = (student) => {
    window.location.href = '/student/' + student.unilogin_user;
};

const fileInput = ref(null);

const uploadImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            axios.post('/api/student/image', { image: reader.result })
                .then(response => {
                    window.location.reload();
                })
                .catch(error => console.error('Error uploading image:', error));
        };
        reader.readAsDataURL(file);
    }
};
</script>

<style lang="scss" scoped>
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.card-body {
    padding: 20px;
    position: relative;
}

.image-wrapper {
    position: relative;
}

.student-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.edit-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    border-radius: 50%;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.edit-icon:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.edit-icon input {
    display: none;
}

.student-name {
    font-size: 2rem;
    font-weight: 600;
    margin-top: 15px;
    color: #333;
}

/* Additional styles from original */
h4 {
    margin-bottom: 20px;
    font-size: 1.5rem;
    color: #555;
}.list-group {
        background-color: #f9f9f9;
        border: none;
    }

    .list-group-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f4f4f4;
    }

    .profile-pic {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    .student-link {
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        margin-left: 10px;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .student-link:hover {
        color: #44a16c;
        text-decoration: underline;
    }

    .mt-4 {
        margin-top: 30px;
    }



    
</style>
