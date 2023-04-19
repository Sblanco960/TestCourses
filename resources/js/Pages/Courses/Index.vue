<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { nextTick,ref } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    courses:{type:Object}
})

const title = ref(null)
const modal = ref(false)
const dataCourses = ref(null)
const selectOption = ref('')
const startDate = ref(null)
const endDate = ref(null)

const form = useForm({
    id:'',
    name_course:'',
    schedule:'',
    start_date:'',
    end_date:'',    
})

const deleteCourse = (id,name) => {

    const alert = Swal.mixin({
        buttonsStyling:true
    });

    alert.fire({
        title:'Seguro desea eliminar'+name+' ? ',
        icon:'question',showCancelButton:true,
        confirmButtonText:'<i class="fa fa-solid fa-checked"></i> Si, eliminar',
        cancelButtonText:'<i class="fa fa-solid fa-ban"></i> Cancelar',
    }).then(resp=>{
        if (resp.isConfirmed) {
            form.delete(route('courses.destroy',id));
        }
    })


}

const openModal = () => {
    
    modal.value = true;

    title.value = 'Consultar Cursos'

}

const closeModal = () => {
    modal.value = false;
}

const searchData  = () =>{

    axios.post('searchData',{
        startDate:startDate.value,
        endDate:endDate.value,
        selectOption:selectOption.value
    })

    .then(resp=>{
        
    })

}


</script>

<template>
    <Head title="Cursos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cursos</h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid v-screem place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('courses.create')" :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'">
                        <i class="fa fa-solid fa-plus-circle"></i> Agregar
                    </Link>
                </div>

                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="openModal">
                        <i class="fa-solid fa-search"></i> Consultar
                    </PrimaryButton>                    
                </div>

            </div>

            <div class="bg-white grid v-screem place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-4">#</th>
                            <th class="px-4 py-4">Curso</th>
                            <th class="px-4 py-4">Horario</th>
                            <th class="px-4 py-4">Dia de Inicio</th>
                            <th class="px-4 py-4">Dia Final</th>
                            <th class="px-4 py-4"></th>
                            <th class="px-4 py-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="course,i in courses" :key="course.id">
                            <td class="border border-gray-400 px-4 py-4">{{ i+1 }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ course.name_course }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ course.schedule }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ course.start_date }}</td>
                            <td class="border border-gray-400 px-4 py-4">{{ course.end_date }}</td>
                            <td class="border border-gray-400 px-4 py-4">
                                <Link :href="route('courses.edit',course.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'">
                                    <i class="fa-solid fa-edit"></i>
                                </Link>
                            </td>
                            <td class="border border-gray-400 px-4 py-4">
                                <DangerButton @click="deleteCourse(course.id,course.name_course)">
                                    <i class="fa-solid fa-trash"></i>
                                </DangerButton>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-9000">{{ title }}</h2>
            <div class="p-3 mt-6 ">
                <div class="card">
                    <div class="card-body">
                                        
                        <div class="row">
                            <InputLabel value="Seleccionar Fecha Inicial de Consulta"></InputLabel>
                            <TextInput type="date" v-model="startDate"></TextInput>    
                        </div>

                        <br><br>
                        
                        <div class="row">                                    
                            <InputLabel for="endDate" value="Seleccionar Fecha Final de Consulta"></InputLabel>
                            <TextInput type="date" v-model="endDate"></TextInput>
                        </div>

                        <br><br>

                        <div class="row">
                            <InputLabel for="option1" value="Consultar el top de los 2 cursos con mas estudiantes asignados segun el rango de fechas seleccionado:"></InputLabel>
                            <input type="radio" v-model="selectOption" :value="2"/> &nbsp;    
                        </div>

                        <br><br>
                        
                        <div class="row">
                            <InputLabel for="option1" value="Consultar el top de los 3 cursos con mas estudiantes asignados segun el rango de fechas seleccionado:"></InputLabel>
                            <input type="radio" v-model="selectOption" :value="3"/> &nbsp;    
                        </div>

                    </div>  

                </div>
                
            </div>

            <div class="p-3 mt-6 " v-if="startDate != null  && endDate != null && selectOption != ''">
                <PrimaryButton :disabled="form.processing" @click="searchData">
                    <i class="fa-solid fa-search"></i> Consultar
                </PrimaryButton>
            </div>
        </Modal>

    </AuthenticatedLayout>
</template>