<template>
    <div class="container">
        <h1 class="text-center">Elever</h1>
        <div class="row justify-content-end">
            <div class="col-12 col-md-4 mb-3">
                <InputText v-model="search" placeholder="Søg efter en elev" class="search" />
            </div>
        </div>
        <div class="row">
            <template v-for="student in filteredStudents">
                <div class="col-3 col-sm-6">
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
</template>

<script>
    export default {
        data () {
            return {
                students: [],
                search: ''
            }
        },

        mounted() {
            this.getStudents()
        },

        computed: {
            filteredStudents() {
                return this.students.filter(student => student.name.toLowerCase().includes(this.search.toLowerCase()))
            }
        },

        methods: {
            getStudents() {
                this.students = window.laravel.students    
            },

            goTo(student) {
                this.$router.push('/student/' + student.unilogin_user + '/comments')
            }
        }
    }
</script>

<style lang="scss" scoped>
    .card:hover {
        cursor: pointer;
    }

    .search {
        width: 100%;
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