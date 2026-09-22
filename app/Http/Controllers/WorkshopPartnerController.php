<?php

namespace App\Http\Controllers;

use App\Models\WorkshopPartner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkshopPartnerController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:workshop_partners,code'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        WorkshopPartner::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Partner workshop berhasil ditambahkan.');
    }

    public function update(Request $request, WorkshopPartner $partner): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:workshop_partners,code,' . $partner->id],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $partner->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Partner workshop berhasil diperbarui.');
    }

    public function destroy(WorkshopPartner $partner): RedirectResponse
    {
        $partner->delete();

        return redirect()->route('workshops.index')->with('success', 'Partner workshop berhasil dihapus.');
    }
}
