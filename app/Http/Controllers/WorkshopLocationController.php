<?php

namespace App\Http\Controllers;

use App\Models\WorkshopLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkshopLocationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        WorkshopLocation::create($validated);

        return redirect()->route('workshops.index')->with('success', 'Lokasi workshop berhasil ditambahkan.');
    }

    public function update(Request $request, WorkshopLocation $location): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $location->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Lokasi workshop berhasil diperbarui.');
    }

    public function destroy(WorkshopLocation $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('workshops.index')->with('success', 'Lokasi workshop berhasil dihapus.');
    }
}
