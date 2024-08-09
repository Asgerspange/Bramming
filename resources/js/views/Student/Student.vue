<template>
    <div class="container">
        <h1 class="text-center">Student</h1>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <img :src="student.image ?? '/generic.png'" class="card-img-top student-image">
                        <h5 class="student-name text-center">{{ student.name }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center gap-2">
            <router-link :to="'/student/' + student.unilogin_user + '/comments'" class="btn btn-primary">Kommentarer</router-link>
            <router-link :to="'/student/' + student.unilogin_user + '/commented'" class="btn btn-primary">Elevens kommentarer</router-link>
        </div>
        <router-view></router-view>
    </div>
    <Toast position="top-right" />
</template>

<script>
    export default {
        data() {
            return {
                student: ''
            }
        },

        mounted() {
            this.getStudent()
        },

        methods: {
            getStudent() {
                this.student = window.laravel.students.find(student => student.unilogin_user === this.$route.params.uniLogin)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .student-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .student-name {
        font-size:3rem;
    }
</style>../../router