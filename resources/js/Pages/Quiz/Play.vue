<script setup>
import { Head, usePage, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted, watch } from 'vue';
import AppBar from '../../components/AppBar.vue';

const page = usePage();
const time = computed(() => page.props.quiz.time || 0);
const baseUrl = page.props.baseUrl;
const quizType = computed(() => page.props.quizType || {});
const category = computed(() => page.props.category || {});
const question = computed(() => page.props.question || {});
const nextQuestionRoute = computed(() => page.props.nextQuestionRoute || null);

// Extract the question number from the URL
const currentQuestion = computed(() => {
    const match = page.url.match(/\/question\/(\d+)$/);
    return match ? Number(match[1]) : 1;
});

const totalQuestions = computed(() => quizType.value?.no_of_que || 1);

let timeLeft = ref(time.value);
let intervalId = null;

const startTimer = () => {
    if (intervalId) clearInterval(intervalId);
    timeLeft.value = time.value;

    intervalId = setInterval(() => {
        if (timeLeft.value > 0) {
            timeLeft.value--;
        } else {
            clearInterval(intervalId);
            submit();
        }
    }, 1000);
};

onMounted(() => {
    startTimer();
});

onUnmounted(() => {
    if (intervalId) clearInterval(intervalId);
});

watch(question, () => {
    startTimer();
});

const form = useForm({
    selectedAnswer: 'notSelected',
});

const submit = () => {
    form.put(nextQuestionRoute.value);
};
</script>

<template>

    <Head>
        <title>Play Quiz</title>
    </Head>
    <v-app>
        <AppBar :disabled="true" />
        <v-main>
            <v-container>
                <v-card>
                    <v-card-title class="text-h5 font-weight-bold text-center py-4">
                        {{ category.name }} Quiz
                    </v-card-title>
                    <v-card-text class="px-6 pb-4 text-center">
                        <v-form @submit.prevent="submit">
                            <h3 class="text-h6 font-weight-medium mb-2">
                                Current Question {{ currentQuestion }} | Questions Left {{ totalQuestions -
            currentQuestion }}
                                <br>
                                Time: {{ timeLeft }} seconds left
                            </h3>
                            <p class="mt-3 text-body-1">
                                {{ question.question }}

                                <v-radio-group v-model="form.selectedAnswer" row>
                                    <v-radio v-for="option in question.options" :key="option" :label="option"
                                        :value="option"></v-radio>
                                    <v-radio :key="null" :label="null" value="notSelected" v-model="form.selectedAnswer"
                                        id="nullAnswer" class="d-none">
                                    </v-radio>
                                </v-radio-group>
                            </p>

                            <v-card-actions class="justify-center pb-4">
                                <v-btn type="submit" color="primary" block>
                                    {{ currentQuestion === totalQuestions ? 'Submit Quiz' : 'Next Question' }}
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
