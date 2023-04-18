<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue'
import VueTalwindPagination from '@ocrv/vue-tailwind-pagination';
import { nextTick,ref } from 'vue';



const modal = ref(false)
const nameInput = ref(null)
const title = ref(null)
const operation = ref(null)
const id = ref('')


const props = defineProps({
    students:{type:Object},
    courses:{type:Object},
})




console.log('props',props)

const form = useForm({
    id:'',
    name:'',
    last_name:'',
    age:'',
    email:'',    
    courses:[],
})

const deleteStudent = (id,name) => {

    const alert = Swal.mixin({
        buttonsStyling:true
    });

    alert.fire({
        title:'Seguro desea eliminar'+''+name+' ? ',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="fa fa-solid fa-checked"></i> Si, eliminar',
        cancelButtonText:'<i class="fa fa-solid fa-ban"></i> Cancelar',
    }).then(resp=>{
        if (resp.isConfirmed) {
            form.delete(route('students.destroy',id));
        }
    })

}

</script>

<template>
    <Head title="Cursos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estudiantes</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screem place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('students.create')" :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa fa-solid fa-plus-circle"></i> Agregar
                    </Link>
                </div>
            </div>

            <div class="bg-white grid v-screem place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Apellido</th>
                            <th class="px-4 py-4">Edad</th>
                            <th class="px-4 py-4">Email</th>
                            <th class="px-4 py-4">Cursos</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="student,i in students.data" :key="student.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.last_name }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.age }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.email }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <li>{{ student.courses }}</li>
                                <!-- <ul v-for="course in student.courses">
                                    <li>{{ student.courses }}</li>
                                </ul> -->
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <Link :href="route('students.edit',student.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteStudent(student.id,student.name)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            
            <div class="bg-white grid v-screem place-items-center">
                <VueTalwindPagination
                    :current="students.curretPage" :total="students.total"
                    :per-page="students.perPage"
                    @page-changed="onPageClick($event)"
                ></VueTalwindPagination>
            </div>

        </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-9000">{{ title }}</h2>
            <div class="p-3 mt-6 ">
                <InputLabel for="name" value="Nombre Estudiante:"></InputLabel>
                <TextInput id="name" ref="nameInput" v-model="form.name"></TextInput>

                <InputLabel for="last_name" value="Apellido Estudiante:"></InputLabel>
                <TextInput id="last_name" ref="nameInput" v-model="form.last_name"></TextInput>

                <InputLabel for="age" value="Edad Estudiante:"></InputLabel>
                <TextInput id="age" ref="nameInput" v-model="form.age"></TextInput>            

                <InputLabel for="email" value="Correo Estudiante:"></InputLabel>
                <TextInput id="email" ref="nameInput" v-model="form.email"></TextInput>

                <InputLabel for="email" value="Correo Estudiante:"></InputLabel>
                <ul v-for="course in courses" :key="course.id">
                    <li>
                        <input type="checkbox" v-model="form.checkbox"> &nbsp; <b>{{ course.name_course }}</b>
                    </li>
                </ul>

            </div>
        </Modal>

    </AuthenticatedLayout>
</template>