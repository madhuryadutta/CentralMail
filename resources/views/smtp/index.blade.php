@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">SMTP Server Management</h2>

    <div class="mb-4">
        <a href="{{ route('smtp.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            + Add New SMTP Server
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Host</th>
                    <th class="px-4 py-2">Port</th>
                    <th class="px-4 py-2">From Address</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($smtpServers as $server)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $server->name }}</td>
                    <td class="px-4 py-2">{{ $server->host }}</td>
                    <td class="px-4 py-2">{{ $server->port }}</td>
                    <td class="px-4 py-2">{{ $server->mail_from_address ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded
                            {{ $server->is_active ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }}">
                            {{ $server->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex space-x-2">
                        <a href="{{ route('smtp.edit', $server->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('smtp.toggle', $server->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-red-600 hover:underline">
                                {{ $server->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
