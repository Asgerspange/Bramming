<template>
    <div class="container">
        <h1 class="text-center">Kommentarer</h1>
        <div class="row">
            <div class="col-12">
                <form @submit.prevent="addComment">
                    <div class="form-group">
                        <label for="comment">Kommentar</label>
                        <textarea class="form-control" id="comment" v-model="comment"></textarea>
                    </div>
                    <button class="btn btn-primary mt-2">Tilføj kommentar</button>
                </form>
            </div>
            <div class="col-12 mt-2">
                <template  v-if="localComment?.comment">
                    <small>Du har skrevet: </small>
                    <div class="card">
                        <div class="card-body d-flex justify-content-between gap-2">
                            <p>{{ localComment?.comment }}</p>
                            <i class="material-symbols cursor-pointer" @click="deleteComment">delete</i>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { ref, defineProps } from 'vue'

    const props = defineProps(['student', 'comment'])
    const student = ref(props.student)
    const localComment = ref(props.comment)
    const comment = ref('')

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

<style>
    .card p {
        margin: 0;
    }
</style>