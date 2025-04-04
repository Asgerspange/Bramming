<template>
    <App>
        <div class="container">
            <h1 class="header">Student</h1>
            <div class="profile-container">
                <div class="profile-card">
                    <div class="card-body">
                        <div class="image-wrapper">
                            <img :src="student?.profile_picture?.picture ?? '/generic.png'" class="profile-image">
                            <label class="edit-button">
                                <span class="material-symbols">edit</span>
                                <input type="file" ref="fileInput" @change="uploadImage">
                            </label>
                        </div>
                        <h5 class="student-name">{{ student.name }}</h5>
                    </div>
                </div>
            </div>
            
            <!-- <div v-if="downloadVisible" class="download-section">
                <a href="/api/download-comments" class="download-button">
                    Download kommentarer
                </a>
            </div> -->
            
            <div class="comments-section">
                <h4 class="section-title">
                    Du mangler at skrive kommentarer til følgende: 
                    <span class="progress-count">(Du har skrevet til {{ totalComments + ' / ' + totalStudents }} elever)</span>
                </h4>
                
                <ul class="student-list">
                    <li v-for="student in paginatedStudents" 
                        :key="student.name" 
                        class="student-item"
                        @click="goTo(student)">
                        <img :src="student.profile_picture?.picture ?? '/generic.png'" class="student-avatar">
                        <span class="student-link">{{ student.name }}</span>
                    </li>
                </ul>
                
                <Paginator 
                    :rows="10" 
                    :totalRecords="students.length" 
                    :first="first" 
                    @page="onPageChange" 
                    layout="PrevPageLink CurrentPageReport NextPageLink"
                    :currentPageReportTemplate="'Showing {first} to {last} of {totalRecords}'" 
                    class="custom-paginator"
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
const fileInput = ref(null);

const paginatedStudents = computed(() => {
    return localStudents.value.slice(first.value, first.value + 10);
});

const onPageChange = (event) => {
    first.value = event.first;
};

const goTo = (student) => {
    window.location.href = '/student/' + student.id;
};

const uploadImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            axios.post('/api/student/image', { 
                image: reader.result 
            })
            .then(response => {
                window.location.reload();
            })
            .catch(error => {
                console.error('Error uploading image:', error);
            });
        };
        reader.readAsDataURL(file);
    }
};
</script>

<style lang="scss" scoped>
// Variables
$primary-color: #4361ee;
$secondary-color: #3a0ca3;
$accent-color: #f72585;
$gradient-start: #4cc9f0;
$gradient-end: #4361ee;
$text-color: #2b2d42;
$light-bg: #ffffff;
$card-bg: #f8f9fa;
$border-color: #e9ecef;
$shadow-color: rgba(0, 0, 0, 0.1);
$shadow-hover: rgba(67, 97, 238, 0.25);
$border-radius-sm: 10px;
$border-radius-lg: 16px;
$spacing-xs: 0.5rem;
$spacing-sm: 1rem;
$spacing-md: 1.5rem;
$spacing-lg: 2rem;
$spacing-xl: 3rem;
$transition-fast: 0.2s;
$transition-med: 0.3s;
$breakpoint-sm: 576px;
$breakpoint-md: 768px;
$breakpoint-lg: 992px;

// Main container
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: $spacing-lg;
    color: $text-color;
}

// Header
.header {
    text-align: center;
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: $spacing-lg;
    color: $primary-color;
    position: relative;
    
    &:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, $gradient-start, $gradient-end);
        border-radius: 2px;
    }
}

// Profile section
.profile-container {
    display: flex;
    justify-content: center;
    margin-bottom: $spacing-lg;
}

.profile-card {
    width: 100%;
    max-width: 500px;
    background-color: $light-bg;
    border-radius: $border-radius-lg;
    overflow: hidden;
    box-shadow: 0 8px 20px $shadow-color;
    transition: transform $transition-med, box-shadow $transition-med;
    
    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px $shadow-hover;
    }
}

.card-body {
    padding: $spacing-md;
}

.image-wrapper {
    position: relative;
    border-radius: $border-radius-sm;
    overflow: hidden;
}

.profile-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    transition: filter $transition-med;
    
    &:hover {
        filter: brightness(1.05);
    }
}

.edit-button {
    position: absolute;
    bottom: $spacing-md;
    right: $spacing-md;
    background: linear-gradient(to right, $accent-color, $secondary-color);
    color: $light-bg;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: transform $transition-fast, box-shadow $transition-fast;
    
    &:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    }
    
    input {
        display: none;
    }
}

.student-name {
    font-size: 2rem;
    font-weight: 600;
    margin-top: $spacing-md;
    text-align: center;
    color: $text-color;
}

// Download section
.download-section {
    margin: $spacing-xl 0;
    text-align: center;
}

.download-button {
    display: inline-block;
    background: linear-gradient(to right, $primary-color, $secondary-color);
    color: $light-bg;
    padding: $spacing-sm $spacing-lg;
    border-radius: $border-radius-sm;
    text-decoration: none;
    font-weight: 600;
    transition: transform $transition-med, box-shadow $transition-med;
    box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
    
    &:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }
}

// Comments section
.comments-section {
    background-color: $card-bg;
    padding: $spacing-lg;
    border-radius: $border-radius-lg;
    box-shadow: 0 5px 15px $shadow-color;
}

.section-title {
    font-size: 1.5rem;
    color: $secondary-color;
    margin-bottom: $spacing-lg;
    font-weight: 600;
    
    .progress-count {
        font-size: 1.1rem;
        color: $accent-color;
        font-weight: 500;
    }
}

// Student list
.student-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.student-item {
    display: flex;
    align-items: center;
    background-color: $light-bg;
    padding: $spacing-md;
    margin-bottom: $spacing-sm;
    border-radius: $border-radius-sm;
    border-left: 4px solid $primary-color;
    box-shadow: 0 2px 5px $shadow-color;
    cursor: pointer;
    transition: transform $transition-fast, box-shadow $transition-fast;
    
    &:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 8px $shadow-hover;
    }
}

.student-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid $primary-color;
}

.student-link {
    margin-left: $spacing-md;
    font-weight: 500;
    color: $text-color;
    transition: color $transition-fast;
    
    &:hover {
        color: $primary-color;
    }
}

// Custom Paginator styling
:deep(.custom-paginator) {
    margin-top: $spacing-lg;
    
    .p-paginator {
        background: transparent;
        
        .p-paginator-element {
            color: $primary-color;
            
            &:hover {
                background-color: rgba($primary-color, 0.1);
            }
            
            &.p-highlight {
                background-color: $primary-color;
                color: $light-bg;
            }
        }
    }
}

// Responsive design
@media (max-width: $breakpoint-md) {
    .profile-card {
        max-width: 100%;
    }
    
    .student-name {
        font-size: 1.75rem;
    }
    
    .section-title {
        font-size: 1.3rem;
        
        .progress-count {
            display: block;
            margin-top: $spacing-xs;
        }
    }
}

@media (max-width: $breakpoint-sm) {
    .container {
        padding: $spacing-md;
    }
    
    .header {
        font-size: 2rem;
    }
    
    .profile-image {
        height: 250px;
    }
    
    .student-item {
        padding: $spacing-sm;
    }
}
</style>