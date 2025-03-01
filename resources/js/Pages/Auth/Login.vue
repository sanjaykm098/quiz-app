<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

// Reactive form data
const form = useForm({
    email: null,
    password: null,
});

const baseUrl = usePage().props.baseUrl;

// Access errors from Inertia props
const errors = computed(() => usePage().props.errors || {});

// Flash messages
const flash = computed(() => usePage().props.flash || {});

// Snackbar states
const errorSnackbar = ref(!!flash.value.error);
const successSnackbar = ref(!!flash.value.success);

const submit = () => {
    const url = `${baseUrl}/login`;
    form.post(url);
};
</script>
<style scoped>
.bg-dark {
    background-color: transparent;
}
</style>
<template>

    <Head>
        <title>Login</title>
    </Head>
    <v-app id="login">
        <v-main class="h-screen">
            <v-container class="h-100">
                <v-row justify="center" class="h-100 d-flex w-100 align-center">
                    <v-col cols="12" sm="8" md="6">
                        <v-card color="dark">
                            <v-card-title>
                                <h2 class="text-center">
                                    Login
                                </h2>
                            </v-card-title>
                            <v-card-text>
                                <v-form @submit.prevent="submit">
                                    <!-- Email Field -->
                                    <v-text-field class="mb-4" v-model="form.email" variant="outlined" label="Email"
                                        :error-messages="errors?.email" prepend-inner-icon="mdi-email" type="email" />
                                    <v-text-field v-model="form.password" variant="outlined" label="Password"
                                        :error-messages="errors?.password" prepend-inner-icon="mdi-lock"
                                        type="password" />

                                    <v-row class="mt-4">
                                        <v-col cols="12" sm="6">
                                            <Link as="button" href="/register" class="w-100">
                                            <v-btn text color="primary" class="w-100">
                                                Register Now
                                            </v-btn>
                                            </Link>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <!-- Submit Button -->
                                            <v-btn type="submit" color="primary" block>
                                                Login
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
            <v-snackbar v-model="successSnackbar" color="success" timeout="3000">
                {{ flash.success }}
                <template v-slot:actions>
                    <v-btn variant="text" @click="successSnackbar = false">Close</v-btn>
                </template>
            </v-snackbar>

            <!-- Error Snackbar -->
            <v-snackbar v-model="errorSnackbar" color="error" timeout="3000">
                {{ flash.error }}
                <template v-slot:actions>
                    <v-btn variant="text" @click="errorSnackbar = false">Close</v-btn>
                </template>
            </v-snackbar>
        </v-main>
    </v-app>
</template>
