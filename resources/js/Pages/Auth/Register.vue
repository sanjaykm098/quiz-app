<script setup>
import { ref } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'

// Reactive form data
const form = ref({
    name: '',
    email: '',
    password: '',
});

// Validation rules
const rules = {
    name: { required },
    email: { required, email },
    password: { required, minLength: minLength(6) },
};
const v$ = useVuelidate(rules, form);
const loading = ref(false);
const snackbar = ref(false);
const snackbarMessage = ref('');

async function register() {
    v$.value.$touch();
    if (v$.value.$invalid) {
        snackbarMessage.value = 'Please fix the errors before submitting.';
        snackbar.value = true;
        return;
    }
    if (!form.value.terms) {
        snackbarMessage.value = 'Please accept the terms and conditions and privacy policy.';
        snackbar.value = true;
        return;
    }
    try {
        loading.value = true;
        await new Promise((resolve) => setTimeout(resolve, 2000));
        snackbarMessage.value = 'Registration successful!';
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
        <title>Register</title>
    </Head>
    <v-app id="register">
        <v-main class="h-screen">
            <v-container class="h-100">
                <v-row justify="center" class="h-100 d-flex w-100 align-center">
                    <v-col cols="12" sm="8" md="7">
                        <v-card color="dark">
                            <v-card-title>
                                <h2 class="text-center">
                                    Register
                                </h2>
                            </v-card-title>
                            <v-card-text>
                                <v-form @submit.prevent="register">
                                    <v-text-field type="text" variant="outlined" label="Name" v-model="form.name"
                                        :error-messages="v$.name.$errors.map(e => e.$message)"
                                        prepend-inner-icon="mdi-account"></v-text-field>
                                    <v-text-field type="email" variant="outlined" label="Email" v-model="form.email"
                                        class="mt-4" :error-messages="v$.email.$errors.map(e => e.$message)"
                                        prepend-inner-icon="mdi-email"></v-text-field>
                                    <v-text-field type="password" variant="outlined" label="Password" class="mt-4"
                                        v-model="form.password"
                                        :error-messages="v$.password.$errors.map(e => e.$message)"
                                        prepend-inner-icon="mdi-lock"></v-text-field>

                                    <!-- Accept  Terms and Conditions & Privacy Policy -->
                                    <v-checkbox v-model="form.terms"
                                        label="I accept the terms and conditions and privacy policy"
                                        class="mt-2"></v-checkbox>
                                    <v-row>
                                        <v-col cols="12" sm="6">
                                            <Link as="button" href="/login" class="w-100">
                                            <v-btn text color="primary" class="w-100">
                                                Login Now
                                            </v-btn>
                                            </Link>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <!-- Submit Button -->
                                            <v-btn type="submit" :loading="loading" color="primary" block>
                                                Register
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <!-- Snackbar for Feedback -->
                <v-snackbar v-model="snackbar" color="primary" timeout="3000">
                    {{ snackbarMessage }}
                </v-snackbar>
            </v-container>
        </v-main>
    </v-app>
</template>
