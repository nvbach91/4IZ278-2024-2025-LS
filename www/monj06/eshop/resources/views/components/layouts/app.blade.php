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

    <flux:main container>
        <!-- Filters and sorting -->
        <div class="flex flex-col md:flex-row gap-4 mb-8">
            <div class="md:w-1/4 lg:w-1/5">
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="font-semibold text-lg mb-4">Filters</h2>

                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-2">Price Range</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="price-1"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="price-1">Under $100</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="price-2"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="price-2">$100 - $500</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="price-3"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="price-3">$500 - $1000</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="price-4"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="price-4">$1000 - $2000</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="price-5"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="price-5">$2000+</label>
                            </div>
                        </div>
                    </div>

                    <!-- Availability Filter -->
                    <div class="mb-6">
                        <h3 class="font-medium mb-2">Availability</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="in-stock"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="in-stock">In Stock</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="on-sale"
                                    class="rounded text-primary-500 focus:ring-primary-500 mr-2">
                                <label for="on-sale">On Sale</label>
                            </div>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <button id="apply-filters"
                        class="w-full py-2 bg-primary-500 text-white rounded hover:bg-primary-600 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>

            <div class="md:w-3/4 lg:w-4/5">
                <!-- Sorting options -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <label for="sort-by" class="mr-2">Sort by:</label>
                        <select id="sort-by"
                            class="rounded border-neutral-300 focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            <option value="default">Featured</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="name-asc">Name: A to Z</option>
                            <option value="name-desc">Name: Z to A</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @yield('content')
                </div>
            </div>
        </div>
        {{ $products->links() }}
    </flux:main>
    @fluxScripts
</body>

</html>
