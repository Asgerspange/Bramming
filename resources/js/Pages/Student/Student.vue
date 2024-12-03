<template>
    <App>
        <div class="container student-layout">
            <div class="student-info">
                <div class="card">
                    <div class="card-body">
                        <img 
                        :src="student?.image ?? '/generic.png'" 
                        class="card-img-top student-image" 
                        />
                        <h5 class="student-name">{{ student?.name }}</h5>
                    </div>
                </div>
            </div>
            <div class="comments-section">
                <Comments :student="student" :comment="comment" />
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
    .student-layout {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
    }

    .student-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .comments-section {
        flex: 2;
    }

    .student-image {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 1rem;
    }

    .student-name {
        font-size: 2rem;
        text-align: center;
        font-weight: bold;
        color: #333;
    }

    .comments-section {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
