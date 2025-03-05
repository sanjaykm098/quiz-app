<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AppBar from '../../components/AppBar.vue';

const time = computed(() => usePage().props.quiz.time || 0);
const baseUrl = usePage().props.baseUrl;
const quizType = computed(() => usePage().props.quizType || {});
const category = computed(() => usePage().props.category || {});
const quizResult = computed(() => usePage().props.quizResult || {});
const quiz = computed(() => usePage().props.quiz || {});

const totalScore = computed(() => {
    return quizResult.value.reduce((score, result) => {
        return result.option === result.question.answer ? score + 1 : score;
    }, 0);
});
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
                <v-card class="mx-auto" max-width="500">
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

                <v-card class="mx-auto mt-4" max-width="500" color="primary" dark>
                    <v-card-title class="text-h6 text-center py-4">
                        🎯 Your Total Score: {{ totalScore }} / {{ quizType.no_of_que }}
                    </v-card-title>
                </v-card>

                <div v-if="quizResult">
                    <v-card v-for="(resultObject, index) in quizResult" :key="resultObject.id" class="mx-auto mt-4"
                        max-width="500">
                        <v-card-title class="text-button font-weight-bold text-capitalize py-4">
                            {{ index + 1 }}. {{ resultObject.question.question }}
                        </v-card-title>
                        <v-card-text class="px-6 pb-3 text-center">
                            <v-row>
                                <v-col cols="12" sm="6">
                                    Your Answer: {{ resultObject.option == 'notSelected' ? 'Not Answered' :
                resultObject.option }} <br>
                                    Correct Answer: {{ resultObject.question.answer }}
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-chip
                                        :color="resultObject.option === resultObject.question.answer ? 'success' : 'error'"
                                        class="text-white">
                                        {{ resultObject.option === resultObject.question.answer ? 'Correct' :
                'Incorrect' }}
                                    </v-chip>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
