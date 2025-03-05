<script setup>
import { usePage, Link, Head } from '@inertiajs/vue3';
import AppBar from '../../components/AppBar.vue';
import { computed } from "vue";

const baseUrl = usePage().props.baseUrl;
const quizType = computed(() => usePage().props.quizType || {});
const category = computed(() => usePage().props.category || {});
</script>

<template>

    <Head>
        <title>Start Quiz - {{ quizType.name }}</title>
    </Head>

    <v-app>
        <AppBar :disabled="true" />
        <v-main class="d-flex align-center justify-center">
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" sm="8" md="6" lg="4">
                        <v-card class="mx-auto" elevation="6" rounded="lg">
                            <v-card-title class="text-h5 font-weight-bold text-center py-4">
                                {{ category.name }} Quiz
                            </v-card-title>

                            <v-card-text class="px-6 pb-4 text-center">
                                <h3 class="text-h6 font-weight-medium mb-2">
                                    {{ quizType.name }}
                                </h3>
                                <b class="text-body-2">
                                    ⏳ Time: {{ quizType.time }} mins | ❓ Questions: {{ quizType.no_of_que }}
                                </b>
                                <p class="mt-3 text-body-1">
                                    {{ quizType.description }}
                                </p>
                            </v-card-text>

                            <v-card-actions class="justify-center pb-4">
                                <Link as="button" method="post"
                                    :href="`${baseUrl}/category/${category.uuid}/quiz/${quizType.level}`">
                                <v-btn color="primary" class="w-75" size="large">
                                    Start Quiz
                                </v-btn>
                                </Link>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
