<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link,useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import Swal from 'sweetalert2';

const props = defineProps({
    courses:{type:Object}
})


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
    </AuthenticatedLayout>
</template>