
<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>
<!-- Updated Vue Component -->
<template>
<Head title="Welcome" />
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full px-6" style="padding: 0;">
            <!-- Header -->
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3 custom-header px-4 lg:px-6" style="padding-top: 0;">
                <div class="flex lg:justify-center lg:col-start-2">
                    <svg class="h-12 w-auto custom-svg" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- SVG Path Here -->
                    </svg>
                </div>
                <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="rounded-md px-3 py-2 custom-link">
                        Dashboard
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="rounded-md px-3 py-2 custom-link">
                            Log in
                        </Link>
                        <Link v-if="canRegister" :href="route('register')" class="rounded-md px-3 py-2 custom-link">
                            Register
                        </Link>
                    </template>
                </nav>
            </header>
            
            <!-- Hero Section -->
            <section class="hero-section text-center">
                <div class="container">
                    <h1 class="display-4">Welcome to Our Website</h1>
                    <p class="lead">Discover our features and enjoy your visit.</p>
                    <a href="http://localhost:5173/#/" class="btn btn-primary btn-lg">Learn More</a>
                </div>
            </section>
            
            <!-- Features Section -->
            <section id="features" class="py-5">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card feature-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Feature One</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card feature-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Feature Two</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card feature-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Feature Three</h5>
                                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Footer -->
            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </footer>
        </div>
    </div>
</div>
</template>


