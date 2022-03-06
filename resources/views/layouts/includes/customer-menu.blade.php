<!-- Logo -->
<div class="shrink-0 flex items-center">
    <a href="{{ route('customer.dashboard') }}">
        <x-jet-application-mark class="block h-9 w-auto" />
    </a>
</div>

<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-jet-nav-link href="{{ route('customer.dashboard') }}" :active="request()->routeIs('customer.dashboard')">
        {{ __('Dashboard') }}
    </x-jet-nav-link>
</div>

<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-jet-nav-link href="{{ route('customer.users') }}" :active="request()->routeIs('customer.users')">
        {{ __('Users') }}
    </x-jet-nav-link>
</div>
