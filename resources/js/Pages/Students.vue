<template>
    <App>
        <div class="container">
            <h1 class="text-center">Elever</h1>
        
            <div class="row">
                <template v-for="student in students">
                    <div class="col-3">
                        <div class="card" @click="goTo(student)">
                            <div class="card-body">
                                <img :src="student.image ?? '/generic.png'" class="card-img-top student-image" >
                                <h5 class="student-name">{{ student.name }}</h5>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </App>
</template>

<script setup>
    import App from '@/js/App.vue';
    import { defineProps } from 'vue';

    const props = defineProps(['students']);

    const goTo = (student) => {
        window.location.href = '/student/' + student.unilogin_user;
    }
</script>

<style lang="scss" scoped>
    .card:hover {
        cursor: pointer;
    }

    .student-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .student-name {
        font-size: 1.5rem;
        text-align: center;
    }
</style>