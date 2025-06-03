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
                        <button class="product-thumbnail aspect-square rounded overflow-hidden" data-image="${image}"
                            data-index="${index}">
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
                            <p>{{ $product->name }}{{ $product->description }}</p>
                            <p>{{ $product->description }}</p>
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
                
            </div>
        </section>-->
    </flux:main>
    @fluxScripts
</body>

</html>
