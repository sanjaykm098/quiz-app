<script setup>
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import AppBar from "../../components/AppBar.vue";

const quizResults = computed(() => usePage().props.quizResults);
</script>

<template>

    <Head>
        <title>All Results</title>
    </Head>

    <v-app app dark>
        <AppBar />

        <v-main>
            <v-container fluid>
                <h2 class="text-h5 mb-4">All Results</h2>

                <v-row dense>
                    <v-col v-for="result in quizResults" :key="result.id" cols="12">
                        <v-card flat rounded="lg" class="pa-3">
                            <v-card-title class="text-h6 font-weight-medium">
                                {{ result.category.name }}
                            </v-card-title>

                            <v-card-subtitle class="text-caption">
                                {{ new Date(result.created_at).toLocaleDateString() }}
                            </v-card-subtitle>

                            <v-card-text>
                                <div class="">
                                    <span class="text-caption">Score: {{ result.score }}%</span>
                                    <v-progress-linear :model-value="result.score" color="primary" height="8"
                                        rounded></v-progress-linear>

                                </div>

                                <div class="mt-2 text-caption">
                                    <strong>{{ result.no_of_questions }}</strong> Questions Answered
                                    <p>
                                        <strong>{{ result.correct }}</strong> Correct Answers
                                        <strong>{{ result.wrong }}</strong> Wrong Answers
                                    </p>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
