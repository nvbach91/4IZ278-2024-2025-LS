<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- Profile Info -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">Profile Information</h2>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="shrink-0">
                        <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-1.jpg"
                            alt="Neil image">
                    </div>
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Jméno</h5>
                </div>

                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button class="w-full">Profil</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button class="w-full">Objednávky</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button class="w-full">Adresy</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button variant="danger" class="w-full">Odhlásit</flux:button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Info</h2>

        </div>
    </div>
</div>
