<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white antialiased dark:bg-neutral-950">
    <div class="grid min-h-screen lg:grid-cols-2">
        <div class="relative hidden overflow-hidden lg:flex lg:flex-col bg-neutral-900 p-12 text-white">
            <div aria-hidden="true" class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-950"></div>
                <div class="absolute -top-32 -left-32 size-[480px] rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -bottom-40 -right-32 size-[520px] rounded-full bg-white/[0.03] blur-3xl"></div>
            </div>

            <div class="relative z-10 flex items-center gap-5">
                <x-site-icon class="size-24 fill-current text-white" fallback-class="size-24 fill-current text-white" />
                <span class="text-4xl font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
            </div>

            {{-- Marketing copy hidden for now — restore when the app is complete.
            <div class="relative z-10 mt-auto mb-40 max-w-md">
                <h2 class="text-4xl font-semibold leading-tight tracking-tight">
                    {{ __('A solid starting point for your next app.') }}
                </h2>
                <p class="mt-4 text-sm leading-6 text-neutral-300">
                    {{ __('Authentication, roles, permissions, audit trail, and admin tooling — wired up and ready to extend.') }}
                </p>

                <ul class="mt-8 space-y-3 text-sm text-neutral-300">
                    <li class="flex items-start gap-3">
                        <flux:icon.check-circle class="mt-0.5 size-4 text-neutral-100" />
                        <span>{{ __('Role-based permissions and route-level access control out of the box') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <flux:icon.check-circle class="mt-0.5 size-4 text-neutral-100" />
                        <span>{{ __('Audit log and login event history for every recorded change') }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <flux:icon.check-circle class="mt-0.5 size-4 text-neutral-100" />
                        <span>{{ __('Admin UI for users, roles, settings, and permissions matrix') }}</span>
                    </li>
                </ul>
            </div>
            --}}

        </div>

        <div class="relative flex items-center justify-center bg-slate-200 px-6 py-12 sm:px-12 dark:bg-slate-800">
            <div class="w-full max-w-md space-y-6">
                <div class="flex flex-col items-center gap-4 lg:hidden">
                    <x-site-icon class="size-16 fill-current text-black dark:text-white" fallback-class="size-16 fill-current text-black dark:text-white" />
                    <span class="text-base font-semibold tracking-tight text-zinc-900 dark:text-white">
                        {{ config('app.name', 'Laravel') }}
                    </span>
                </div>

                <div class="rounded-xl bg-white p-8 shadow-sm dark:bg-zinc-900">
                    <div class="space-y-2 text-center">
                        <flux:heading size="xl" level="1">{{ config('app.name', 'Laravel') }}</flux:heading>
                        <flux:subheading>
                            {{ __('Sign in to continue.') }}
                        </flux:subheading>
                    </div>

                    <div class="mt-8 flex flex-col gap-3">
                        @auth
                            <flux:button size="sm" :href="route('dashboard')" variant="primary" wire:navigate>
                                {{ __('Go to Dashboard') }}
                            </flux:button>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <flux:button size="sm" type="submit" class="w-full">
                                    {{ __('Log Out') }}
                                </flux:button>
                            </form>
                        @else
                            <flux:button size="sm" :href="route('login')" variant="primary" wire:navigate>
                                {{ __('Log In') }}
                            </flux:button>

                            @if (Route::has('register'))
                                <flux:button size="sm" :href="route('register')" wire:navigate>
                                    {{ __('Create Account') }}
                                </flux:button>
                            @endif
                        @endauth
                    </div>
                </div>

                @if (Route::has('password.request'))
                    @guest
                        <div class="hidden lg:block text-center text-xs text-zinc-500 lg:text-left dark:text-zinc-400">
                            <flux:link :href="route('password.request')" class="text-xs">{{ __('Reset Your Password') }}</flux:link>.
                        </div>
                    @endguest
                @endif
            </div>

            <x-site-footer class="absolute bottom-6 right-6" />
        </div>
    </div>

    @fluxScripts
</body>
</html>
