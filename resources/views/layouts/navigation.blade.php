<nav x-data="{ open: false, notifOpen: false }" class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-900/90 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <div class="flex items-center gap-10">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800/80 shadow-lg shadow-black/20">
                            <x-application-logo class="block h-7 w-auto fill-current text-indigo-400" />
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold tracking-wide text-slate-100">TaskFlow</p>
                            <p class="text-xs text-slate-400">Employee Management System</p>
                        </div>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:gap-2">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('manager.dashboard') || request()->routeIs('admin.dashboard') || request()->routeIs('employee.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @auth
                        @if(auth()->user()->role === 'employee')
                            <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                                {{ __('My Tasks') }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->role === 'manager')
                            <x-nav-link :href="route('manager.tasks.index')" :active="request()->routeIs('manager.tasks.*')">
                                {{ __('Manage Tasks') }}
                            </x-nav-link>

                            <x-nav-link :href="route('manager.employees.index')" :active="request()->routeIs('manager.employees.*')">
                                {{ __('Manage Employees') }}
                            </x-nav-link>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.managers.index')" :active="request()->routeIs('admin.managers.*')">
                                {{ __('Admin: Managers') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                @auth
                    @php
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                        $recentNotifications = auth()->user()->notifications()->latest()->take(5)->get();

                        $role = ucfirst(auth()->user()->role);
                        $roleColors = [
                            'Admin' => 'bg-rose-500/15 text-rose-300 border-rose-500/20',
                            'Manager' => 'bg-amber-500/15 text-amber-300 border-amber-500/20',
                            'Employee' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/20',
                        ];
                    @endphp

                    <span class="hidden rounded-full border px-3 py-1 text-xs font-semibold tracking-wide {{ $roleColors[$role] ?? 'bg-slate-700 text-slate-200 border-slate-600' }} lg:inline-flex">
                        {{ $role }}
                    </span>

                    <!-- Notification Bell + Dropdown -->
                    <div class="relative" @click.away="notifOpen = false">
                        <button @click="notifOpen = !notifOpen"
                           class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-700 bg-slate-800/80 text-slate-300 transition hover:border-slate-600 hover:bg-slate-800 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a4 4 0 0 0-4 4v1.17c0 .53-.21 1.04-.59 1.41L6.7 9.29A2 2 0 0 0 6 10.71V14l-1.8 3.6A1 1 0 0 0 5.1 19h13.8a1 1 0 0 0 .9-1.4L18 14v-3.29a2 2 0 0 0-.7-1.42l-.71-.7A2 2 0 0 1 16 7.17V6a4 4 0 0 0-4-4Zm0 20a3 3 0 0 0 2.82-2H9.18A3 3 0 0 0 12 22Z"/>
                            </svg>

                            @if($unreadCount > 0)
                                <span class="absolute -right-1 -top-1 inline-flex min-h-[1.25rem] min-w-[1.25rem] items-center justify-center rounded-full bg-rose-500 px-1 text-[10px] font-bold text-white shadow-md shadow-rose-500/30">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <div x-show="notifOpen"
                             x-transition
                             class="absolute right-0 mt-3 w-96 overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl shadow-black/40"
                             style="display: none;">
                            <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-100">Notifications</p>
                                    <p class="text-xs text-slate-400">
                                        {{ $unreadCount }} unread
                                    </p>
                                </div>

                                <a href="{{ route('notifications.index') }}"
                                   class="text-xs font-semibold text-indigo-300 transition hover:text-white">
                                    View all
                                </a>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                @forelse($recentNotifications as $notification)
                                    @php
                                        $type = $notification->data['type'] ?? 'default';
                                        $title = $notification->data['title'] ?? 'Untitled';

                                        $badgeClasses = match ($type) {
                                            'task_awaiting_review' => 'bg-purple-200 text-purple-800',
                                            'task_overdue' => 'bg-red-200 text-red-800',
                                            'task_done', 'task_completed' => 'bg-emerald-200 text-emerald-800',
                                            default => 'bg-blue-200 text-blue-800',
                                        };

                                        $label = match ($type) {
                                            'task_awaiting_review' => 'Review',
                                            'task_overdue' => 'Overdue',
                                            'task_done', 'task_completed' => 'Completed',
                                            default => 'Update',
                                        };

                                        $message = match ($type) {
                                            'task_awaiting_review' => "Task {$title} is awaiting review.",
                                            'task_overdue' => "Task {$title} is overdue.",
                                            'task_done', 'task_completed' => "Task {$title} has been completed.",
                                            default => "You have a new notification.",
                                        };
                                    @endphp

                                    <a href="{{ route('notifications.index') }}"
                                       class="block border-b border-slate-800 px-4 py-3 transition hover:bg-slate-800/70">
                                        <div class="mb-2 flex items-center gap-2">
                                            <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $badgeClasses }}">
                                                {{ $label }}
                                            </span>

                                            @if(is_null($notification->read_at))
                                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-slate-100 line-clamp-2">
                                            {{ $message }}
                                        </p>
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </a>
                                @empty
                                    <div class="px-4 py-8 text-center">
                                        <p class="text-sm font-semibold text-slate-200">No notifications yet</p>
                                        <p class="mt-1 text-xs text-slate-400">Updates will appear here.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-3 rounded-2xl border border-slate-700 bg-slate-800/80 px-3 py-2 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:bg-slate-800 hover:text-white focus:outline-none">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-sm font-bold text-white shadow-md shadow-blue-900/30">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>

                                <div class="hidden text-left md:block">
                                    <div class="text-sm font-semibold text-blue-100">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-blue-300">{{ Auth::user()->email }}</div>
                                </div>

                                <svg class="h-4 w-4 fill-current text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-blue-800">
                                <p class="text-sm font-semibold text-blue-100">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-blue-300">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-800 p-2 text-slate-300 transition hover:bg-slate-700 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-800 bg-slate-900 sm:hidden">
        <div class="space-y-1 px-4 pb-3 pt-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
                @if(auth()->user()->role === 'employee')
                    <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                        {{ __('My Tasks') }}
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->role === 'manager')
                    <x-responsive-nav-link :href="route('manager.tasks.index')" :active="request()->routeIs('manager.tasks.*')">
                        {{ __('Manage Tasks') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('manager.employees.index')" :active="request()->routeIs('manager.employees.*')">
                        {{ __('Manage Employees') }}
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.managers.index')" :active="request()->routeIs('admin.managers.*')">
                        {{ __('Admin: Managers') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        @auth
            <div class="border-t border-slate-800 px-4 py-4">
                <div class="mb-3">
                    <div class="text-sm font-semibold text-slate-100">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile Settings') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('notifications.index')">
                        {{ __('Notifications') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>