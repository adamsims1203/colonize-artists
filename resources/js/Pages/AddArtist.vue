<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';

/** 
 * schema constant for validating an object with three properties: name, spotify_id, and bio
  */
const schema = yup.object({
    // name property validations
    name: yup.string().matches(/^[A-Za-z ]*$/, 'Please enter valid name') // only allow alphabets and spaces
        .max(40, 'Name must be less than 40 characters') // maximum length of 40 characters
        .required('Name is required'), // name is required field

    // spotify_id property validations
    spotify_id: yup.string()
        .length(22, 'Spotify ID must be 22 characters long') // length must be 22 characters
        .required('Spotify ID is required'), // spotify_id is required field

    // bio property validations
    bio: yup.string().required('Bio is required')  // bio is required field
});

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Artist
                <div v-if="status">
                    <span v-if="status.code == 200" class="text-sm text-green-500">Success</span>
                    <span v-if="status.code == 404 || status.code == 409" class="text-sm text-red-500">Error: {{
                        status.message
                    }}</span>
                </div>
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Add Artist</h1>
                        <p class="mt-2 text-sm text-gray-700">Add a new artist to your roster.</p>
                    </div>
                </div>
                <div class="mt-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col px-8 py-4">
                        <Form class="space-y-8 divide-y divide-gray-200" @submit="submit" :validation-schema="schema">
                            <div class="space-y-8 divide-y divide-gray-200">
                                <div>
                                    <div class="grid grid-cols-1 mt-2 gap-y-6 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Artist
                                                Name</label>
                                            <div class="mt-1">
                                                <Field type="text" name="name" id="name" autocomplete="name"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                                <ErrorMessage class="text-red-500" name="name" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="spotify_id"
                                                class="block text-sm font-medium text-gray-700">Spotify ID</label>
                                            <div class="mt-1">
                                                <Field type="text" name="spotify_id" id="spotify_id"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                                <ErrorMessage class="text-red-500" name="spotify_id" />
                                            </div>
                                        </div>

                                        <div class="sm:col-span-6">
                                            <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                                            <div class="mt-1">
                                                <Field as="textarea" name="bio" id="bio"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    rows="5"></Field>
                                                <ErrorMessage class="text-red-500" name="bio" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-5">
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                                </div>
                            </div>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                spotify_id: '',
                bio: ''
            },
            status: null
        }
    },

    methods: {
        submit(values) {
            // reset status
            this.status = null;

            // make a POST request to /api/artists/add with values as request body
            axios
                .post("/api/artists/add", values)
                .then(({ data }) => {
                    this.status = data;
                })
                .catch(error => {
                    this.status = error.response.data;
                });
        }
    }
}
</script>
