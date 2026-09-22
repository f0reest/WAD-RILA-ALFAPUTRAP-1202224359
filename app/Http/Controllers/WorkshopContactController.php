<?php

namespace App\Http\Controllers;

use App\Models\WorkshopContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkshopContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
        ]);

        WorkshopContact::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Kontak workshop berhasil ditambahkan.');
    }

    public function update(Request $request, WorkshopContact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
        ]);

        $contact->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Kontak workshop berhasil diperbarui.');
    }

    public function destroy(WorkshopContact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('workshops.index')->with('success', 'Kontak workshop berhasil dihapus.');
    }
}
