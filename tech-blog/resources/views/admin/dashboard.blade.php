<x-app-layout>
    <x-slot name="header">
        <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2" dir="ltr">// ADMIN PANEL</p>
        <h2 class="text-4xl font-black tracking-tighter uppercase">لوحة الإدارة</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0 mb-12">
            <div class="border-4 border-black bg-black text-white p-8">
                <p class="font-mono text-xs tracking-widest uppercase opacity-50 mb-2" dir="ltr">TOTAL USERS</p>
                <p class="text-6xl font-black">{{ $stats['users_count'] }}</p>
            </div>
            <div class="border-4 border-black border-r-0 lg:border-r-4 p-8 bg-white">
                <p class="font-mono text-xs tracking-widest uppercase text-gray-400 mb-2" dir="ltr">TOTAL POSTS</p>
                <p class="text-6xl font-black">{{ $stats['posts_count'] }}</p>
            </div>
        </div>

        <!-- Users Table -->
        <div class="border-4 border-black brutal-shadow">
            <div class="border-b-4 border-black bg-black text-white p-6">
                <h3 class="text-xl font-black uppercase tracking-tight">إدارة المستخدمين</h3>
            </div>
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest text-gray-400">الاسم</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest text-gray-400" dir="ltr">EMAIL</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest text-gray-400" dir="ltr">STATUS</th>
                        <th class="px-6 py-4 font-mono text-xs uppercase tracking-widest text-gray-400 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400" dir="ltr">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs uppercase tracking-widest border-4 border-black px-3 py-1 {{ $user->is_active ? '' : 'bg-black text-white' }}">
                                {{ $user->is_active ? 'ACTIVE' : 'BLOCKED' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="font-mono text-xs uppercase tracking-widest border-4 border-black px-4 py-1 hover:bg-black hover:text-white transition-colors">
                                    {{ $user->is_active ? 'حظر' : 'تفعيل' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t-2 border-black">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>