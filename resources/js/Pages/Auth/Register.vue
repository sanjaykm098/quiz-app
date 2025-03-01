<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

// Reactive form data
const form = useForm({
    name: null,
    email: null,
    password: null,
    terms: false,
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
    const url = `${baseUrl}/register`;
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
                                <v-form @submit.prevent="submit">
                                    <v-text-field type="text" variant="outlined" label="Name" v-model="form.name"
                                        :error-messages="errors?.name" prepend-inner-icon="mdi-account"></v-text-field>
                                    <v-text-field type="email" variant="outlined" label="Email" v-model="form.email"
                                        class="mt-4" :error-messages="errors?.email"
                                        prepend-inner-icon="mdi-email"></v-text-field>
                                    <v-text-field type="password" variant="outlined" label="Password" class="mt-4"
                                        v-model="form.password" :error-messages="errors?.password"
                                        prepend-inner-icon="mdi-lock"></v-text-field>

                                    <!-- Accept  Terms and Conditions & Privacy Policy -->
                                    <v-checkbox v-model="form.terms"
                                        label="I accept the terms and conditions and privacy policy"
                                        :error-messages="errors?.terms" class="mt-2"></v-checkbox>

                                    <v-row class="mt-4">
                                        <v-col cols="12" sm="6">
                                            <Link as="button" href="/login" class="w-100">
                                            <v-btn text color="primary" class="w-100">
                                                Login Now
                                            </v-btn>
                                            </Link>
                                        </v-col>
                                        <v-col cols="12" sm="6">
                                            <!-- Submit Button -->
                                            <v-btn type="submit" color="primary" block>
                                                Register
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
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
            </v-container>
        </v-main>
    </v-app>
</template>
