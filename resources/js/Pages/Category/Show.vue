<template>

    <Head>
        <title>
            Quiz of {{ category.name }}
        </title>
    </Head>
    <v-app>

        <AppBar></AppBar>
        <v-main>
            <v-container>
                <v-row>
                    <v-col cols="12" v-for="type in quizType" :key="type.level">
                        <Link as="button" :href="baseUrl + '/category/' + category.uuid + '/quiz/' + type.level"
                            class="w-100">
                        <v-card class="mx-auto" :subtitle="'Time: ' + type.time + ' | Question: ' + type.no_of_que"
                            width="400">
                            <template v-slot:title>
                                <span class="font-weight-black text-capitalize">
                                    {{ type.name }} - {{ type.difficulty }}
                                </span>
                            </template>

                            <v-card-text class="bg-surface-light pt-4">
                                {{ type.description }}
                            </v-card-text>
                        </v-card>
                        </Link>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { usePage, Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import AppBar from "../../components/AppBar.vue";

const category = computed(() => usePage().props.category || []);
const baseUrl = usePage().props.baseUrl;
const quizType = computed(() => usePage().props.quizType || [])
</script>
