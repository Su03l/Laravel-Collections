<x-app-layout>
    <div class="max-w-6xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        <h1 class="text-5xl font-black border-b-8 border-black inline-block pb-2 mb-10">لوحة تحكم الإدارة</h1>

        @if(session('success'))
            <div class="border-4 border-black bg-white p-4 mb-8 font-bold text-xl">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="border-4 border-black p-8 bg-black text-white shadow-[12px_12px_0px_0px_rgba(200,200,200,1)]">
                <h3 class="text-2xl font-bold mb-2">إجمالي المستخدمين</h3>
                <p class="text-6xl font-black">{{ $stats['users_count'] }}</p>
            </div>
            <div class="border-4 border-black p-8 bg-white text-black shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
                <h3 class="text-2xl font-bold mb-2">إجمالي المقالات</h3>
                <p class="text-6xl font-black">{{ $stats['posts_count'] }}</p>
            </div>
        </div>

        <h2 class="text-3xl font-black mb-6 border-l-8 border-black pl-4">إدارة المستخدمين</h2>

        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)] mb-12">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="border-b-4 border-black text-xl">
                        <th class="py-4 font-black">الاسم</th>
                        <th class="py-4 font-black">اليوزرنيم</th>
                        <th class="py-4 font-black">عدد المقالات</th>
                        <th class="py-4 font-black">الحالة</th>
                        <th class="py-4 font-black text-center">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b-2 border-dashed border-black hover:bg-gray-50">
                            <td class="py-4 font-bold">{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td class="py-4 font-medium">{{ '@'.$user->username }}</td>
                            <td class="py-4 font-bold">{{ $user->posts()->count() }}</td>
                            <td class="py-4">
                                @if($user->is_active)
                                    <span class="bg-black text-white px-3 py-1 font-bold text-sm">نشط</span>
                                @else
                                    <span class="bg-white border-2 border-black text-black px-3 py-1 font-bold text-sm">محظور</span>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من تغيير حالة هذا المستخدم؟');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="border-2 border-black px-4 py-1 font-bold hover:bg-black hover:text-white transition-colors">
                                        {{ $user->is_active ? 'حظر 🚫' : 'تفعيل ✅' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-8 font-bold">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
