<x-layouts.study title="Profile Settings">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Profile Settings</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manage your account and preferences</p>
        </div>

        {{-- Profile Avatar Card --}}
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/20">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-bold backdrop-blur">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                    <p class="text-indigo-200 text-sm">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-white/15 text-white/90">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ ucfirst($user->role ?? 'student') }}
                        </span>
                        <span class="text-[11px] text-indigo-200">Member since {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Information --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900">Profile Information</h3>
                <p class="text-xs text-gray-400 mt-0.5">Update your name and email address</p>
            </div>
            <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Save Changes
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                              class="text-sm text-emerald-600 font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Saved
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-900">Update Password</h3>
                <p class="text-xs text-gray-400 mt-0.5">Use a strong, unique password to keep your account secure</p>
            </div>
            <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Current Password</label>
                    <input id="current_password" name="current_password" type="password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">New Password</label>
                    <input id="password" name="password" type="password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                    @error('password', 'updatePassword')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-2">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 hover:-translate-y-0.5 transition-all">
                        Update Password
                    </button>
                    @if (session('status') === 'password-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                              class="text-sm text-emerald-600 font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Updated
                        </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden" x-data="{ showDelete: false }">
            <div class="px-6 py-4 border-b border-red-50">
                <h3 class="text-sm font-bold text-red-600">Danger Zone</h3>
                <p class="text-xs text-gray-400 mt-0.5">Permanently delete your account and all data</p>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Once your account is deleted, all resources and data will be permanently removed. This action cannot be undone.</p>
                <button @click="showDelete = true" class="px-5 py-2.5 bg-red-50 text-red-600 text-sm font-semibold rounded-xl border border-red-200 hover:bg-red-100 transition-all">
                    Delete Account
                </button>

                {{-- Delete Confirmation Modal --}}
                <div x-show="showDelete" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                    <div @click.away="showDelete = false" class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                        <div class="p-6">
                            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Delete Account</h3>
                            <p class="text-sm text-gray-500 mt-1">This action is permanent. Enter your password to confirm.</p>
                            <form method="post" action="{{ route('profile.destroy') }}" class="mt-4 space-y-4">
                                @csrf
                                @method('delete')
                                <input name="password" type="password" placeholder="Enter your password"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition">
                                @error('password', 'userDeletion')
                                    <p class="text-xs text-red-500">{{ $message }}</p>
                                @enderror
                                <div class="flex items-center gap-3">
                                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-xl hover:bg-red-700 transition-all">
                                        Delete Permanently
                                    </button>
                                    <button type="button" @click="showDelete = false" class="px-5 py-2.5 text-gray-600 text-sm font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.study>
