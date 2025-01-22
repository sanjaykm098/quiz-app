<script setup>
import { ref } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'

// Reactive form data
const form = ref({
    email: '',
    password: '',
});

// Validation rules
const rules = {
    email: { required, email },
    password: { required, minLength: minLength(6) },
};

// Initialize Vuelidate
const v$ = useVuelidate(rules, form);

// State variables
const loading = ref(false);
const snackbar = ref(false);
const snackbarMessage = ref('');

// Login function
async function login() {
    // Run validation
    v$.value.$touch();
    if (v$.value.$invalid) {
        snackbarMessage.value = 'Please fix the errors before submitting.';
        snackbar.value = true;
        return;
    }
    try {
        loading.value = true;
        // Simulate API request
        await new Promise((resolve) => setTimeout(resolve, 2000));
        snackbarMessage.value = 'Login successful!';
        snackbar.value = true;
    } catch (error) {
        snackbarMessage.value = 'An error occurred. Please try again.';
        snackbar.value = true;
    } finally {
        loading.value = false;
    }
}
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
                                <v-form @submit.prevent="login">
                                    <!-- Email Field -->
                                    <v-text-field class="mb-4" v-model="form.email" variant="outlined" label="Email"
                                        :error-messages="v$.email.$errors.map(e => e.$message)"
                                        prepend-inner-icon="mdi-email" type="email"></v-text-field>

                                    <!-- Password Field -->
                                    <v-text-field v-model="form.password" variant="outlined" label="Password"
                                        :error-messages="v$.password.$errors.map(e => e.$message)"
                                        prepend-inner-icon="mdi-lock" type="password"></v-text-field>

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
                                            <v-btn type="submit" :loading="loading" color="primary" block>
                                                Login
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <!-- Snackbar for Feedback -->
                <v-snackbar v-model="snackbar" timeout="3000" color="primary">
                    {{ snackbarMessage }}
                </v-snackbar>
            </v-container>
        </v-main>
    </v-app>
</template>
