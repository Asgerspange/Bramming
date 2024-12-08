<template>
    <Admin>
        <DataTable 
            v-model:filters="filters" 
            :value="customers" 
            paginator 
            :rows="10" 
            dataKey="id" 
            removableSort 
            filterDisplay="row" 
            :loading="loading"
            :rowsPerPageOptions="[10, 25, 50, 100]"
            :globalFilter="filters['global'].value"
            :globalFilterFields="['id', 'name', 'unilogin_user', 'is_teacher']"
            responsiveLayout="scroll"
        >
            <template #header>
                <div class="vert-align justify-content-end">
                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                </div>
            </template>
            <template #empty> No customers found. </template>
            <template #loading> Loading customers data. Please wait. </template>
            <Column field="id" sortable header="ID" style="min-width: 2rem">
                <template #body="{ data }">
                    {{ data.id }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" style="width: 100px" @input="filterCallback()" class="p-column-filter" placeholder="Search ID" />
                </template>
            </Column>
            <Column field="name" header="Name" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.name }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by name" />
                </template>
            </Column>
            <Column field="unilogin_user" header="Unilogin" style="min-width: 15rem">
                <template #body="{ data }">
                    {{ data.unilogin_user }}
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="text" @input="filterCallback()" class="p-column-filter" placeholder="Search by email" />
                </template>
            </Column>
            <Column field="is_teacher" sortable header="Is Teacher" style="min-width: 2rem">
                <template #body="{ data }">
                    <template v-if="data.is_teacher">
                        <div class="d-flex gap-3">
                            <i class="material-symbols text-green">check_circle</i>
                            <i @click="removeAdmin(data.id)" class="material-symbols text-red cursor-pointer">remove_circle</i>
                        </div>
                    </template>
                    <template v-else>
                        <div class="d-flex gap-3">
                            <i class="material-symbols text-red">cancel</i>
                            <i @click="makeAdmin(data.id)" class="material-symbols text-green cursor-pointer">add_circle</i>
                        </div>
                    </template>
                </template>
            </Column>
        </DataTable>
    </Admin>
</template>

<script setup>
    import Admin from '@/js/Pages/Admin.vue';
    import { ref, onMounted, defineProps } from 'vue';
    import { FilterMatchMode } from 'primevue/api';
    import axios from 'axios';

    const customers = ref([]);
    const filters = ref({
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
        name: { value: null, matchMode: FilterMatchMode.CONTAINS },
        unilogin_user: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    });
    const loading = ref(true);

    const props = defineProps({
        users: { required: true },
    });

    onMounted(() => {
        fetchCustomers();
    });

    const fetchCustomers = () => {
        customers.value = Object.values(props.users); // Convert object to array
        loading.value = false;
    };

    const makeAdmin = (id) => {
        axios.post('/api/admin/make-admin', { id })
            .then(() => {
                let user = customers.value.find(user => user.id === id);
                user.is_admin = true;
            })
            .catch(error => {
                console.error(error);
            });
    };

    const removeAdmin = (id) => {
        axios.post('/api/admin/remove-admin', { id })
            .then(() => {
                let user = customers.value.find(user => user.id === id);
                user.is_admin = false;
            })
            .catch(error => {
                console.error(error);
            });
        };
</script>