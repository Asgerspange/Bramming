<template>
    <App>
        <div class="student">
            <div class="student__layout">
                <div class="student__info">
                    <div class="student__card">
                        <div class="student__image-container">
                            <img 
                            :src="student?.profile_picture?.picture ?? '/generic.png'" 
                            class="student__image" 
                            alt="Student profile" 
                            />
                        </div>
                        <h2 class="student__name">{{ student?.name }}</h2>
                    </div>
                </div>
                <div class="student__comments">
                    <Comments :student="student" :comment="comment" />
                </div>
            </div>
        </div>
    </App>
</template>

<script setup>
import App from '@/js/App.vue';
import { defineProps } from 'vue';
import Comments from './Comments.vue';

const props = defineProps(['student', 'comment']);
</script>

<style lang="scss" scoped>
// SCSS Variables
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

.student {
    max-width: $breakpoint-xl;
    margin: 0 auto;
    padding: $spacing-md;
    
    &__layout {
        display: flex;
        gap: $spacing-lg;
        margin-top: $spacing-lg;
        
        @media (max-width: $breakpoint-md) {
            flex-direction: column;
            align-items: center;
        }
    }
    
    &__info {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    &__card {
        width: 100%;
        background-color: $card-bg;
        border-radius: $border-radius-lg;
        box-shadow: 0 10px 20px $shadow-color;
        padding: $spacing-md;
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
        }
    }
    
    &__image-container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-bottom: $spacing-md;
    }
    
    &__image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid $light-bg;
        box-shadow: 0 5px 15px rgba($primary-color, 0.2);
        
        @media (min-width: $breakpoint-md) {
            width: 250px;
            height: 250px;
        }
    }
    
    &__name {
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        margin: 0;
        background: linear-gradient(135deg, $gradient-start, $accent-color);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        
        &::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, $gradient-start, $gradient-end);
            border-radius: 2px;
        }
    }
    
    &__comments {
        flex: 2;
        background-color: $card-bg;
        border-radius: $border-radius-lg;
        box-shadow: 0 10px 20px $shadow-color;
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
        }
    }
}
</style>