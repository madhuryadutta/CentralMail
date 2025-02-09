@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Add SMTP Server</h2>

    <form action="{{ route('smtp.store') }}" method="POST" class="bg-white p-6 shadow-md rounded-lg">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Name</label>
                <input type="text" name="name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Host</label>
                <input type="text" name="host" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Port</label>
                <input type="number" name="port" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Encryption</label>
                <select name="encryption" class="w-full border p-2 rounded">
                    <option value="tls">TLS</option>
                    <option value="ssl">SSL</option>
                </select>
            </div>
            <div>
                <label class="block font-medium">Username</label>
                <input type="text" name="username" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Mail From Address</label>
                <input type="email" name="mail_from_address" class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Daily Limit</label>
                <input type="number" name="daily_limit" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Monthly Limit</label>
                <input type="number" name="monthly_limit" class="w-full border p-2 rounded" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>
@endsection
