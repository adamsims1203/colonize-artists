<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">Artists</h1>
                        <p class="mt-2 text-sm text-gray-700">Here's some of your favourite artists.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <a href="/dashboard/add" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add Artist</a>
                    </div>
                </div>
                <div class="mt-4 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Artist Name</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Followers</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Spotify</th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                    <span class="sr-only">View</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="artist in artists" :key="artist.id">
                                                <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{ artist.name }}</td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ artist.followers }}</td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{  artist.spotify_id }}</td>
                                                <td class="relative py-4 pl-3 pr-4 text-sm font-bold text-right whitespace-nowrap sm:pr-6">
                                                    <a :href="'/view/' + artist.id" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, {{  artist.name }}</span></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                artists: []
            }
        },

        methods: {
            fetchArtists() {
                return axios.get("/api/artists").then(({data}) => {
                    this.artists = data
                })
            }
        },

        mounted() {
            this.fetchArtists()
        }
    }

</script>
