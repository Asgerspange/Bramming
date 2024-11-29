<template>
    <div class="container">
        <h1 class="text-center">Kommentarer</h1>
        <div class="row">
            <div class="col-12" v-if="!isSelf()">
                <form @submit.prevent="addComment">
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <textarea class="form-control" id="comment" v-model="comment"></textarea>
                    </div>
                    <button class="btn btn-primary mt-2">Tilføj kommentar</button>
                </form>
            </div>
            <template v-for="comment in student.comments">
                <div class="col-12 mt-2">
                    <div class="card">
                        <div class="card-body d-flex gap-2">
                            <p>{{ comment.comment }}</p>
                            <small>{{ comment.author.name }} - {{ comment.author.unilogin_user }}</small>
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
                student: '',
                self: ''
            }
        },

        mounted () {
            this.getStudent()
        },

        methods: {
            getStudent() {
                this.self = window.laravel.student
                this.student = window.laravel.students.find(student => student.unilogin_user === this.$route.params.uniLogin)
            },

            isSelf() {
                return this.self.unilogin_user === this.student.unilogin_user
            },

            addComment() {
                axios.post('/api/addComment', {
                    comment: this.comment,
                    student_id: this.student.id
                }).then((response) => {
                    if (!response.status === 208) {
                        window.location.reload()
                    }
                    this.$toast.add({severity: 'error', summary: 'Fejl', detail: 'Du har allerede skrevet en kommentar til denne elev', life: 3000})
                })
            }
        }
    }
</script>