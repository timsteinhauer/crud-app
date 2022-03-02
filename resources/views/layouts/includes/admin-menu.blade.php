<!-- Logo -->
<div class="shrink-0 flex items-center">
    <a href="{{ route('admin.dashboard') }}">
        <x-jet-application-mark class="block h-9 w-auto" />
    </a>
</div>

<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-jet-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
        Admin {{ __('Dashboard') }}
    </x-jet-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-jet-nav-link href="{{ route('admin.users') }}" :active="request()->routeIs('admin.users')">
        {{ __('Users') }}
    </x-jet-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-jet-nav-link href="{{ route('admin.customers') }}" :active="request()->routeIs('admin.customers')">
        {{ __('Customers') }}
    </x-jet-nav-link>
</div>
