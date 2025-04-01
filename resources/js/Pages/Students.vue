<template>
    <App>
        <div class="memorial">
            <h1 class="memorial__title">En tanke, en tak - et evigt minde</h1>
            <div class="memorial__search">
                <input
                type="text" 
                v-model="searchQuery" 
                class="memorial__search-input" 
                placeholder="Søg efter en elev..." 
                />
            </div>
            <div
            class="memorial__grid"
            :class="{ 'memorial__grid--centered': paginatedStudents.length <= 5 }"
            >
            <div
            v-for="student in paginatedStudents"
            :key="student.unilogin_user"
            @click="goTo(student)"
            class="memorial__card"
            >
            <div class="memorial__card-image">
                <img
                :src="student.profile_picture?.picture || '/generic.png'"
                alt="Profilbillede"
                />
            </div>
            <h2 class="memorial__card-name">{{ student.name }}</h2>
        </div>
    </div>
    <Paginator
    :rows="rowsPerPage"
    :totalRecords="filteredStudents.length"
    @page="onPageChange"
    class="memorial__paginator"
    />
</div>
</App>
</template>

<script setup>
import App from '@/js/App.vue';
import { ref, computed } from 'vue';
import Paginator from 'primevue/paginator';

const props = defineProps(['students']);
const students = props.students;
const searchQuery = ref('');
const currentPage = ref(0);
import { onMounted, onUnmounted } from 'vue';

const rowsPerPage = ref(6);

const updateRowsPerPage = () => {
    if (window.innerWidth >= 992) {
        rowsPerPage.value = 10; // PC resolution
    } else {
        rowsPerPage.value = 6; // Mobile resolution
    }
};

onMounted(() => {
    updateRowsPerPage();
    window.addEventListener('resize', updateRowsPerPage);
});

onUnmounted(() => {
    window.removeEventListener('resize', updateRowsPerPage);
});

const filteredStudents = computed(() => {
    if (!searchQuery.value) return students;
    return students.filter((student) =>
    student.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const paginatedStudents = computed(() => {
    const start = currentPage.value * rowsPerPage.value;
    return filteredStudents.value.slice(start, start + rowsPerPage.value);
});

const onPageChange = (event) => {
    currentPage.value = event.page;
};

const goTo = (student) => {
    window.location.href = '/student/' + student.id;
};
</script>

<style lang="scss">
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
    $breakpoint-sm: 576px;
    $breakpoint-md: 768px;
    $breakpoint-lg: 992px;
    $breakpoint-xl: 1200px;
    $transition-fast: 0.2s;
    $transition-med: 0.3s;
    body {
        background: linear-gradient(to bottom, rgba($gradient-start, 0.05), rgba($light-bg, 0.8));
        min-height: 100vh;
        height: 100%;
    }
    .memorial {
        max-width: $breakpoint-xl;
        margin: 0 auto;
        padding: $spacing-sm;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        
        &__title {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            font-weight: 700;
            margin-bottom: $spacing-md;
            text-align: center;
            background: linear-gradient(135deg, $gradient-start, $accent-color);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba($gradient-start, 0.2);
            position: relative;
            
            &::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 4px;
                background: linear-gradient(90deg, $gradient-start, $gradient-end);
                border-radius: 2px;
            }
        }
        
        &__search {
            width: 100%;
            max-width: 600px;
            margin-bottom: $spacing-lg;
            position: relative;
            
            &::before {
                content: '🔍';
                position: absolute;
                left: $spacing-sm;
                top: 50%;
                transform: translateY(-50%);
                font-size: 1rem;
                z-index: 1;
                pointer-events: none;
            }
            
            &-input {
                width: 100%;
                padding: $spacing-sm $spacing-sm $spacing-sm $spacing-lg;
                font-size: 1rem;
                border: 2px solid rgba($border-color, 0.7);
                border-radius: $border-radius-lg;
                box-shadow: 0 4px 12px rgba($primary-color, 0.1);
                transition: all $transition-med ease;
                background-color: rgba($light-bg, 0.8);
                backdrop-filter: blur(8px);
                
                &:focus {
                    outline: none;
                    border-color: $primary-color;
                    box-shadow: 0 0 0 4px rgba($primary-color, 0.15), 0 8px 16px rgba($primary-color, 0.1);
                    background-color: $light-bg;
                }
                
                &::placeholder {
                    color: lighten($text-color, 40%);
                    transition: color $transition-fast;
                }
                
                &:focus::placeholder {
                    color: lighten($text-color, 30%);
                }
            }
        }
        
        &__grid {
            display: grid;
            gap: $spacing-md;
            width: 100%;
            grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile by default */
            grid-template-rows: repeat(3, auto); /* 3 rows on mobile */
            
            @media (min-width: $breakpoint-sm) {
                grid-template-columns: repeat(3, 1fr); /* 3 columns on small devices */
            }
            
            @media (min-width: $breakpoint-md) {
                grid-template-columns: repeat(4, 1fr); /* 4 columns on medium devices */
            }
            
            @media (min-width: $breakpoint-lg) {
                grid-template-columns: repeat(5, 1fr); /* 5 columns on large devices */
            }
            
            &--centered {
                @media (min-width: $breakpoint-md) {
                    grid-template-columns: repeat(auto-fit, 220px);
                    justify-content: center;
                }
            }
        }
        
        &__card {
            background-color: $card-bg;
            border-radius: $border-radius-lg;
            box-shadow: 0 10px 20px $shadow-color;
            text-align: center;
            padding: $spacing-md;
            transition: all $transition-med;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid rgba($border-color, 0.5);
            position: relative;
            overflow: hidden;
            
            &::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                background: linear-gradient(90deg, $gradient-start, $gradient-end);
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.4s ease;
            }
            
            &:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 15px 30px $shadow-hover;
                border-color: rgba($primary-color, 0.2);
                
                &::before {
                    transform: scaleX(1);
                }
            }
            
            &-image {
                width: 85%;
                aspect-ratio: 1;
                border-radius: 50%;
                overflow: hidden;
                margin-bottom: $spacing-md;
                position: relative;
                border: 4px solid $light-bg;
                box-shadow: 0 5px 15px rgba($primary-color, 0.2);
                
                &::after {
                    content: '';
                    position: absolute;
                    inset: 0;
                    border-radius: 50%;
                    box-shadow: inset 0 0 10px rgba($accent-color, 0.2);
                    opacity: 0;
                    transition: opacity $transition-med;
                }
                
                img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.5s ease;
                }
            }
            
            &:hover &-image::after {
                opacity: 1;
            }
            
            &:hover &-image img {
                transform: scale(1.05);
            }
            
            &-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: $text-color;
                margin: 0;
                position: relative;
                padding: $spacing-xs $spacing-sm;
                background: linear-gradient(to right, rgba($light-bg, 0), rgba($primary-color, 0.05), rgba($light-bg, 0));
                border-radius: $border-radius-sm;
                transition: all $transition-fast;
                
                @media (min-width: $breakpoint-md) {
                    font-size: 1.2rem;
                }
            }
            
            &:hover &-name {
                color: $primary-color;
                letter-spacing: 0.02em;
            }
        }
        
        &__paginator {
            margin-top: $spacing-xl;
            
            :deep(.p-paginator) {
                border-radius: $border-radius-lg;
                padding: $spacing-sm;
                background: linear-gradient(to right, rgba($gradient-start, 0.05), rgba($gradient-end, 0.1), rgba($gradient-start, 0.05));
                backdrop-filter: blur(10px);
                box-shadow: 0 4px 15px rgba($primary-color, 0.1);
                border: 1px solid rgba($primary-color, 0.1);
                
                .p-paginator-element {
                    border-radius: $border-radius-sm;
                    transition: all $transition-fast;
                    
                    &:hover {
                        background-color: rgba($primary-color, 0.1);
                        transform: translateY(-2px);
                    }
                    
                    &:focus {
                        box-shadow: 0 0 0 3px rgba($primary-color, 0.25);
                        outline: none;
                    }
                    
                    &.p-highlight {
                        background: linear-gradient(135deg, $primary-color, $secondary-color);
                        color: white;
                        box-shadow: 0 4px 8px rgba($primary-color, 0.3);
                    }
                }
            }
        }
    }
</style>