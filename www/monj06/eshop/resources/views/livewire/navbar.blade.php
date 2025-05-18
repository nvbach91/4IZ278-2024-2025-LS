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

        @foreach ($categories as $category)
            <flux:navlist.item href="#">{{ $category->name }}</flux:navlist.item>
        @endforeach

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
