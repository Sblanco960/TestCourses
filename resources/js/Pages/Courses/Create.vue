<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    id:'',
    name_course:'',
    schedule:'',
    start_date:'',
    end_date:'',    
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Curso</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="form.post(route('courses.store'))" class="mt-6 space-y-6 max-w-xl">

                        <InputLabel form="name_course" value="Curso"></InputLabel>
                        <TextInput  id="name_course" v-model="form.name_course" autofocus required type="text" class="mt-1block w-full"></TextInput>
                        <InputError :mesage="form.errors.name_course" class="mt-2"></InputError>

                        <InputLabel form="schedule" value="Horario"></InputLabel>
                        <TextInput  id="schedule" v-model="form.schedule" autofocus required type="time" class="mt-1block w-full"></TextInput>
                        <InputError :mesage="form.errors.schedule" class="mt-2"></InputError>

                        <InputLabel form="start_date" value="Dia de inicio"></InputLabel>
                        <TextInput  id="start_date" v-model="form.start_date" autofocus required type="date" class="mt-1block w-full"></TextInput>
                        <InputError :mesage="form.errors.start_date" class="mt-2"></InputError>

                        <InputLabel form="end_date" value="Dia Final"></InputLabel>
                        <TextInput  id="end_date" v-model="form.end_date" autofocus required type="date" class="mt-1block w-full"></TextInput>
                        <InputError :mesage="form.errors.end_date" class="mt-2"></InputError>

                        <PrimaryButton :disabled="form.processing">
                            <i class="fa-solid fa-save"></i> Guardar
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
