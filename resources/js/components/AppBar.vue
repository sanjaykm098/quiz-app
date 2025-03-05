<script setup>
import { usePage, Link } from "@inertiajs/vue3";
const homeUrl = usePage().props.homeUrl;
const backUrl = usePage().props.backUrl;
const logoutUrl = usePage().props.logoutUrl;
const isBackUrl = usePage().props.isBackUrl;
</script>
<template>
    <v-app-bar app dark>
        <Link as="button" :href="backUrl" v-if="isBackUrl">
        <v-btn icon>
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        </Link>
        <v-toolbar-title>
            <Link :href="homeUrl">
            <v-btn text>
                <span class="font-weight-black">Quiz App</span>
            </v-btn>
            </Link>
        </v-toolbar-title>
        <Link method="post" :href="logoutUrl" as="button">
        <v-btn icon>
            <v-icon>mdi-logout</v-icon>
        </v-btn>
        </Link>
    </v-app-bar>
</template>
