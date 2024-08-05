<template>
    <div class="container">
        <h1 class="text-center">Elevens kommentarer</h1>
        <div class="row">
            <template v-for="comment in student.commented_on">
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <p>{{ comment.comment }}</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                comment: '',
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