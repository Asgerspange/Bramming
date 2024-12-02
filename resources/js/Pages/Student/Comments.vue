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
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { ref, defineProps } from 'vue'

    const props = defineProps(['student', 'self'])
    const student = ref(props.student)
    const comment = ref('')

    const isSelf = () => {
        return props.self.unilogin_user === student.value.unilogin_user
    }

    const addComment = () => {
        axios.post('/api/addComment', {
            comment: comment.value,
            student_id: student.value.id
        }).then((response) => {
            if (!response.status === 208) {
                window.location.reload()
                return;
            }
            alert('Du har allerede skrevet en kommentar til denne elev')
        })
    }
</script>

<style>
    .card p {
        margin: 0;
    }
</style>