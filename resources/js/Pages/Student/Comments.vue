<template>
    <div class="comments">
        <h2 class="comments__title">Kommentarer</h2>
        
        <form @submit.prevent="addComment" class="comments__form">
            <div class="comments__form-group">
                <label for="comment" class="comments__label">Kommentar</label>
                <textarea 
                id="comment" 
                v-model="comment" 
                class="comments__textarea"
                placeholder="Skriv din kommentar her..."
                ></textarea>
            </div>
            <button type="submit" class="comments__button">
                Tilføj kommentar
            </button>
        </form>
        
        <div class="comments__existing" v-if="localComment?.comment">
            <div class="comments__subheading">Du har skrevet:</div>
            <div class="comments__card">
                <p class="comments__text">{{ localComment?.comment }}</p>
                <button class="comments__delete" @click="deleteComment">
                    <span class="material-symbols">delete</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, defineProps, watch, onMounted } from 'vue'
import { useStore } from '@/js/store.js'

const props = defineProps(['student', 'comment'])
const student = ref(props.student)
const localComment = ref(props.comment)
const comment = ref('')

watch(() => comment.value, (newVal) => {
    useStore().setMessage({ [student.value.unilogin_user]: newVal })
})

onMounted(() => {
    if (!localComment?.value?.comment) {
        comment.value = useStore().getMessage(student.value.unilogin_user)
    }
})

const addComment = () => {
    if (localComment?.value?.comment) {
        alert('Du har allerede skrevet en kommentar til denne elev')
        return;
    }
    axios.post('/api/addComment', {
        comment: comment.value,
        student_id: student.value.id
    }).then((response) => {
        window.location.reload()
    })
}

const deleteComment = () => {
    axios.post('/api/deleteComment', {
        student_id: student.value.id
    }).then(() => {
        localComment.value = ''
    })
}
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
$transition-fast: 0.2s;
$transition-med: 0.3s;

.comments {
    padding: $spacing-md;
    
    &__title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: $spacing-md;
        text-align: center;
        color: $text-color;
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
    
    &__form {
        margin-top: $spacing-lg;
        margin-bottom: $spacing-lg;
    }
    
    &__form-group {
        margin-bottom: $spacing-md;
    }
    
    &__label {
        display: block;
        margin-bottom: $spacing-xs;
        font-weight: 600;
        color: $text-color;
    }
    
    &__textarea {
        width: 100%;
        min-height: 120px;
        padding: $spacing-sm;
        border: 2px solid rgba($border-color, 0.7);
        border-radius: $border-radius-sm;
        background-color: $light-bg;
        transition: all $transition-fast;
        resize: vertical;
        font-family: inherit;
        
        &:focus {
            outline: none;
            border-color: $primary-color;
            box-shadow: 0 0 0 3px rgba($primary-color, 0.15);
        }
        
        &::placeholder {
            color: lighten($text-color, 40%);
        }
    }
    
    &__button {
        padding: $spacing-sm $spacing-lg;
        background: linear-gradient(135deg, $primary-color, $secondary-color);
        color: white;
        border: none;
        border-radius: $border-radius-sm;
        font-weight: 600;
        cursor: pointer;
        transition: all $transition-fast;
        
        &:hover {
            box-shadow: 0 4px 8px rgba($primary-color, 0.3);
            transform: translateY(-2px);
        }
        
        &:active {
            transform: translateY(0);
        }
    }
    
    &__existing {
        margin-top: $spacing-lg;
    }
    
    &__subheading {
        font-size: 0.9rem;
        color: lighten($text-color, 20%);
        margin-bottom: $spacing-xs;
    }
    
    &__card {
        background-color: $light-bg;
        border-radius: $border-radius-sm;
        box-shadow: 0 2px 8px $shadow-color;
        padding: $spacing-md;
        border: 1px solid rgba($border-color, 0.5);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: $spacing-sm;
    }
    
    &__text {
        margin: 0;
        flex: 1;
        line-height: 1.5;
    }
    
    &__delete {
        background: none;
        border: none;
        color: lighten($text-color, 30%);
        cursor: pointer;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all $transition-fast;
        
        &:hover {
            color: $accent-color;
            background-color: rgba($accent-color, 0.1);
        }
    }
}
</style>