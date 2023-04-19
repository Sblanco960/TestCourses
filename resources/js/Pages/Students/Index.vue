<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
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

const formPage = useForm({});

const onPageClick = (event)=>{
    formPage.get(route('students.index',{page:event}))
}

const openModal = (op,student,name,last_name,age,email,courses)=>{
        
    modal.value = true;
    nextTick(()=>nameInput.value.focus);
    operation.value =op;

    if (op == 1) {
        title.value = 'Crear Estudiante';
    }else{
        id.value = student.id;
        title.value = 'Editar Estudiante';
        form.id = student.id;
        form.name = name;
        form.last_name = last_name;
        form.age = age;
        form.email = email;
        form.courses = []
        courses.map((course)=>form.courses.push(course.id));        

    }

}


const closeModal = () => {
    modal.value = false;
    form.reset();
}

const save = () => {
    if (operation.value == 1) {
        form.courses = JSON.stringify(form.courses)
        console.log('form',form)
        form.post(route('students.store'),{
            onSuccess: () => {ok('Estudiante creado con extio')}
        })
    }else{
        form.courses = JSON.stringify(form.courses)
        console.log('id.value',id.value)
        form.put(route('students.update',id.value),{
            onSuccess:()=>{ok('Estudiante Actualizado')}
        })
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'})
}

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
            form.delete(route('students.destroy',id),{
                onSuccess:()=>{ok('Estudiante Eliminado')}
            })
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
                    <PrimaryButton @click="openModal(1)">
                        <i class="fa fa-solid fa-plus-circle"></i> Agregar
                    </PrimaryButton>
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
                        <tr v-for="student,i in students" :key="student.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.name }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.last_name }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.age }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ student.email }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <ul v-for="course in student.courses">
                                    <li>{{ course.name_course }}</li>
                                </ul>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <PrimaryButton @click="openModal(2,student,student.name,student.last_name,student.age,student.email,student.courses)">
                                    <i class="fa-solid fa-edit"></i>
                                </PrimaryButton>
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
                    :current="students.currentPage" :total="students.total"
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
                <InputError :message="form.errors.name" class="mt-2"></InputError>

                <InputLabel for="last_name" value="Apellido Estudiante:"></InputLabel>
                <TextInput id="last_name" ref="nameInput" v-model="form.last_name"></TextInput>
                <InputError :message="form.errors.last_name" class="mt-2"></InputError>

                <InputLabel for="age" value="Edad Estudiante:"></InputLabel>
                <TextInput id="age" type="number" ref="nameInput" v-model="form.age"></TextInput>            
                <InputError :message="form.errors.age" class="mt-2"></InputError>

                <InputLabel for="email" value="Correo Estudiante:"></InputLabel>
                <TextInput id="email" type="email" ref="nameInput" v-model="form.email"></TextInput>
                <InputError :message="form.errors.email" class="mt-2"></InputError>
                
                <ul v-for="course in courses" :key="course.id">
                    <li>
                        <input type="checkbox" :value="course.id" v-model="form.courses"> &nbsp; <b>{{ course.name_course }}</b>
                    </li>
                </ul>

            </div>

            <div class="p-3 mt-6 ">
                <PrimaryButton :disabled="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i> Guardar
                </PrimaryButton>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>