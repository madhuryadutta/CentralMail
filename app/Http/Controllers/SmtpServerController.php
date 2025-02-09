<?php

namespace App\Http\Controllers;

use App\Models\SmtpServer;
use Illuminate\Http\Request;

class SmtpServerController extends Controller
{
    public function index()
    {
        $smtpServers = SmtpServer::orderBy('id', 'desc')->paginate(10);

        return view('smtp.index', compact('smtpServers'));
    }

    public function create()
    {
        return view('smtp.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'encryption' => 'required|string|in:tls,ssl',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'daily_limit' => 'required|integer|min:0',
            'mail_from_address' => 'nullable|email|max:255', // Nullable field
            'monthly_limit' => 'required|integer|min:0',
        ]);

        SmtpServer::create($validated);

        return redirect()->route('smtp.index')->with('success', 'SMTP Server added successfully');
    }

    public function edit(SmtpServer $smtp)
    {
        return view('smtp.edit', compact('smtp'));
    }

    public function update(Request $request, SmtpServer $smtp)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer',
            'encryption' => 'required|string|in:tls,ssl',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'mail_from_address' => 'nullable|email|max:255', // Nullable field
            'daily_limit' => 'required|integer|min:0',
            'monthly_limit' => 'required|integer|min:0',
            // 'is_active' => 'boolean',
        ]);

        $smtp->update($validated);

        return redirect()->route('smtp.index')->with('success', 'SMTP Server updated successfully');
    }

    public function toggleStatus($id)
    {
        $server = SmtpServer::findOrFail($id);
        $server->is_active = ! $server->is_active;
        $server->save();

        return redirect()->route('smtp.index')->with('success', 'SMTP server status updated.');
    }

    // public function destroy(SmtpServer $smtp)
    // {
    //     $smtp->delete();
    //     return redirect()->route('smtp.index')->with('success', 'SMTP Server deleted');
    // }
}
