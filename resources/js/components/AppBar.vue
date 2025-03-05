<script setup>
import { usePage, Link } from "@inertiajs/vue3";

const homeUrl = usePage().props.homeUrl;
const backUrl = usePage().props.backUrl;
const profile_routes = usePage().props.profile_routes;
const logoutUrl = profile_routes.logout;
const dashboard = profile_routes.dashboard;
const all_results = profile_routes.all_results;
const isBackUrl = usePage().props.isBackUrl;
const user = usePage().props.user;

// Define props
const props = defineProps({
    disabled: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <v-app-bar app dark>
        <!-- Back Button -->
        <Link v-if="isBackUrl && !props.disabled" as="button" :href="backUrl">
        <v-btn icon>
            <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        </Link>

        <!-- Title -->
        <v-toolbar-title class="text-center flex-grow-1">
            <template v-if="props.disabled">
                <span class="font-weight-black">Quiz App</span>
            </template>
            <Link v-else :href="homeUrl">
            <v-btn text>
                <span class="font-weight-black">Quiz App</span>
            </v-btn>
            </Link>
        </v-toolbar-title>

        <!-- User Profile -->
        <v-menu activator="parent" location="bottom end" min-width="250" v-if="!props.disabled">
            <template v-slot:activator="{ props }">
                <v-btn icon v-bind="props">
                    <v-avatar size="40">
                        <v-img :src="`https://eu.ui-avatars.com/api/?name=${user.name}&size=250`" />
                    </v-avatar>
                </v-btn>
            </template>
            <v-list class="pa-3">
                <v-list-item class="d-flex align-center">
                    <v-avatar size="50" class="mr-3">
                        <v-img :src="`https://eu.ui-avatars.com/api/?name=${user.name}&size=250`" />
                    </v-avatar>
                    <div>
                        <v-list-item-title class="font-weight-bold text-subtitle-1 mt-2">
                            {{ user.name }}
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-body-2 mb-2 mt-1">
                            {{ user.email }}
                        </v-list-item-subtitle>
                    </div>
                </v-list-item>
                <v-divider class="my-2" />
                <v-list-item @click="$inertia.get(dashboard)" class="d-flex align-center">
                    <template v-slot:prepend>
                        <v-avatar>
                            <v-icon color="white">
                                mdi-view-dashboard
                            </v-icon>
                        </v-avatar>
                    </template>
                    <v-list-item-title>
                        Dashboard
                    </v-list-item-title>
                </v-list-item>
                <v-list-item @click="$inertia.get(all_results)" class="d-flex align-center">
                    <template v-slot:prepend>
                        <v-avatar>
                            <v-icon color="white">
                                mdi-format-list-bulleted
                            </v-icon>
                        </v-avatar>
                    </template>
                    <v-list-item-title>
                        All Results
                    </v-list-item-title>
                </v-list-item>
                <v-list-item @click="$inertia.post(logoutUrl)" class="d-flex align-center">
                    <template v-slot:prepend>
                        <v-avatar>
                            <v-icon color="white">
                                mdi-logout
                            </v-icon>
                        </v-avatar>
                    </template>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>
