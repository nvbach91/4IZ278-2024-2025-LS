<?php
$current_page = basename($_SERVER['PHP_SELF']);
define('BASE_URL', '/4IZ278/DU/du06/');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    @vite('resources/css/app.css')
    <title>Shop Homepage - Start Bootstrap Template</title>
    @fluxAppearance
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <main>
        <!-- Hero section -->
        <section class="relative bg-neutral-900 text-white">
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://images.pexels.com/photos/100582/pexels-photo-100582.jpeg');">
                <div class="absolute inset-0 bg-gradient-to-r from-neutral-900/90 to-neutral-900/50"></div>
            </div>

            <div class="container mx-auto px-4 py-20 md:py-32 relative">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight reveal-on-scroll">
                        Adventure Awaits <br />With Every Ride
                    </h1>
                    <p class="text-lg md:text-xl mb-8 text-neutral-200 max-w-lg reveal-on-scroll"
                        style="animation-delay: 0.2s;">
                        Discover premium bikes and gear that will elevate your cycling experience. From mountain trails
                        to city streets, we've got you covered.
                    </p>
                    <div class="flex flex-wrap gap-4 reveal-on-scroll" style="animation-delay: 0.4s;">
                        <a href="" data-navlink
                            class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                            Shop Now
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-12 text-center">Featured Products</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @yield('content')
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('products.index') }}" data-navlink
                        class="inline-flex items-center bg-primary-500 hover:bg-primary-600 px-6 py-3 rounded-lg font-medium transition-colors">
                        View All Products
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </main>
    <!-- footer LiveWire component -->
    <livewire:footer />

    <!--
    <div
        class="bg-[url(https://www.magazin.cyklistickey.cz/assets/img/upload/clanek_nahled/8X9A0018.png)] p-100 bg-center">

    </div>
    <div class="flex max-md:flex-col items-start">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Products</h2>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                


            </div>
        </div>
    </div>-->
    @fluxScripts
</body>


</html>
