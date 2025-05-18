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
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
            class="max-lg:hidden dark:hidden" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="max-lg:hidden! hidden dark:flex" />
        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:dropdown class="max-lg:hidden">
                <flux:navbar.item icon:trailing="chevron-down">Vše</flux:navbar.item>
                <flux:navmenu>
                    <flux:navmenu.item href="#">Marketing site</flux:navmenu.item>
                    <flux:navmenu.item href="#">Android app</flux:navmenu.item>
                    <flux:navmenu.item href="#">Brand guidelines</flux:navmenu.item>
                </flux:navmenu>
            </flux:dropdown>
            @yield('navbar')
        </flux:navbar>
        <flux:spacer />
        <flux:navbar class="me-4">
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle"
                aria-label="Toggle dark mode" />
            <flux:navbar.item icon="magnifying-glass" href="#" label="Search" />
            <flux:navbar.item class="max-lg:hidden" icon="cog-6-tooth" href="#" label="Settings" />
            <flux:navbar.item class="max-lg:hidden" icon="information-circle" href="#" label="Help" />
        </flux:navbar>
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>
    <flux:sidebar stashable sticky
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
            class="px-2 dark:hidden" />
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="px-2 hidden dark:flex" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="#" current>Home</flux:navlist.item>
            <flux:navlist.item icon="inbox" badge="12" href="#">Inbox</flux:navlist.item>
            <flux:navlist.item icon="document-text" href="#">Documents</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="#">Calendar</flux:navlist.item>
            <flux:navlist.group expandable heading="Favorites" class="max-lg:hidden">
                <flux:navlist.item href="#">Marketing site</flux:navlist.item>
                <flux:navlist.item href="#">Android app</flux:navlist.item>
                <flux:navlist.item href="#">Brand guidelines</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>
        <flux:spacer />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>
    <flux:main container>
        <!-- Product Detail Section -->
        <div class="bg-white rounded-xl shadow-lg p-4 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div>
                    <div class="mb-4 aspect-w-3 aspect-h-2 rounded-lg overflow-hidden bg-neutral-100">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" id="main-product-image"
                            class="w-full h-full object-cover" />
                    </div>

                    <div class="grid grid-cols-4 gap-4">
                        <button
                            class="product-thumbnail aspect-square rounded overflow-hidden ${index === 0 ? 'ring-2 ring-primary-500' : ''}"
                            data-image="${image}" data-index="${index}">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover" />
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <livewire:product-detail-info :product="$product" />
            </div>

            <!-- Product Tabs -->
            <div class="mb-12">
                <div class="border-b border-neutral-200">
                    <nav class="flex -mb-px">
                        <button class="tab-button py-4 px-6 border-b-2 border-primary-500 font-medium text-primary-600"
                            data-tab="details">
                            Product Details
                        </button>
                    </nav>
                </div>

                <div class="bg-white rounded-b-xl shadow-lg p-6">
                    <!-- Product Details Tab -->
                    <div id="tab-details" class="tab-content">
                        <h2 class="text-xl font-semibold mb-4">About this product</h2>
                        <div class="space-y-4 text-neutral-700">
                            <p>{{ $product->description }}</p>
                            <p>Experience the ultimate ride with the {{ $product->name }}. Designed for
                                {{ $product->name }} enthusiasts who demand the best in performance and
                                reliability.</p>
                            <p>Our team of engineers has crafted this {{ $product->name }} with meticulous
                                attention to detail, ensuring every component works together seamlessly to provide an
                                exceptional riding experience.</p>

                            <h3 class="text-lg font-semibold mt-6">Key Features</h3>
                            <ul class="list-disc list-inside space-y-2">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                ${relatedProducts.map(relatedProduct => `
                <div>
                    ${createProductCard(relatedProduct)}
                </div>
                `).join('')}
            </div>
        </section>-->
    </flux:main>
    @fluxScripts
</body>

</html>
