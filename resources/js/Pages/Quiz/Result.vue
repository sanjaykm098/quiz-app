<script setup>
import { Head, usePage, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted, watch } from 'vue';
import AppBar from '../../components/AppBar.vue';

const time = computed(() => usePage().props.quiz.time || 0);
const baseUrl = usePage().props.baseUrl;
const quizType = computed(() => usePage().props.quizType || {});
const category = computed(() => usePage().props.category || {});
const question = computed(() => usePage().props.question || {});
const quiz = computed(() => usePage().props.quiz || {});
</script>
<template>

    <Head>
        <title>
            {{ quizType.name }} Quiz - {{ category.name }} - Result
        </title>
    </Head>
    <v-app>
        <AppBar />
        <v-main>
            <v-container>
                <v-card>
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
                </v-card>



            </v-container>
        </v-main>
    </v-app>
</template>
