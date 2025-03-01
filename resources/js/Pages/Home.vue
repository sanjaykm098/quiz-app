<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppBar from '../components/AppBar.vue';
const categorizes = computed(() => usePage().props.categorizes || []);
const baseUrl = usePage().props.baseUrl;
</script>

<template>

    <Head>
        <title>Home Page</title>
    </Head>
    <v-app id="login">
        <AppBar></AppBar>
        <v-main class="h-screen">
            <v-container class="h-100">
                <v-row gutters="1">
                    <v-col v-for="category in categorizes" :key="category.id" class="col-auto">
                        <Link :href="baseUrl + '/category/' + category.uuid">
                        <v-btn class="w-100">
                            {{ category.name }}
                        </v-btn>
                        </Link>
                    </v-col>
                    <v-responsive width="100%"></v-responsive>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
