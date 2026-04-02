{{-- resources/views/super-admin/users/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('super-admin.users.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email
                                        Verified</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Bergabung</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td class="px-6 py-4 text-sm">{{ $users->firstItem() + $index }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($user->role == 'super_admin')
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Super
                                                    Admin</span>
                                            @elseif($user->role == 'admin')
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Admin</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Kasir</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if ($user->email_verified_at)
                                                <span class="text-green-600">Verified</span>
                                            @else
                                                <span class="text-yellow-600">Unverified</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="{{ route('super-admin.users.edit', $user->id) }}"
                                                class="text-blue-600 hover:text-blue-900">Edit</a>

                                            @if ($user->id != auth()->id())
                                                <form action="{{ route('super-admin.users.destroy', $user->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Yakin hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
