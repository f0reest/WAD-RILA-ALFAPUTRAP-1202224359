<?php

namespace App\Http\Controllers;

use App\Models\WorkshopContact;
use App\Models\WorkshopLocation;
use App\Models\WorkshopPartner;
use App\Models\WorkshopServiceType;
use App\Models\WorkshopSubscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class WorkshopSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $partners = WorkshopPartner::orderBy('name')->get();
        $locations = WorkshopLocation::with('partner')->orderBy('name')->get();
        $contacts = WorkshopContact::with('partner')->orderBy('name')->get();
        $serviceTypes = WorkshopServiceType::orderBy('name')->get();

        $query = WorkshopSubscription::with(['partner', 'location', 'contact', 'serviceType'])
            ->orderByDesc('created_at');

        if ($search = trim((string) $request->input('search', ''))) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('subscription_code', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('partner', fn ($partnerQuery) => $partnerQuery->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('location', fn ($locationQuery) => $locationQuery->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('serviceType', fn ($serviceTypeQuery) => $serviceTypeQuery->where('name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $subscriptions = $query->paginate(10)->appends($request->query());

        return view('workshops.index', compact(
            'partners',
            'locations',
            'contacts',
            'serviceTypes',
            'subscriptions'
        ));
    }

    public function exportExcel()
    {
        $subscriptions = WorkshopSubscription::with(['partner', 'location', 'serviceType'])
            ->orderByDesc('created_at')
            ->get();

        $rows = $subscriptions->map(function ($subscription) {
            return [
                'Code' => $subscription->subscription_code,
                'Partner' => $subscription->partner?->name ?? '-',
                'Location' => $subscription->location?->name ?? '-',
                'Service' => $subscription->serviceType?->name ?? '-',
                'Status' => ucfirst($subscription->status),
                'Monthly Fee' => $subscription->monthly_fee,
                'Starts At' => $subscription->starts_at?->format('Y-m-d'),
                'Ends At' => $subscription->ends_at?->format('Y-m-d'),
                'Notes' => $subscription->notes ?? '-',
            ];
        });

        return Excel::download(new class($rows) implements \Maatwebsite\Excel\Concerns\FromCollection {
            public function __construct(protected $rows) {}

            public function collection()
            {
                return collect($this->rows)->map(fn ($row) => collect($row));
            }
        }, 'workshop-subscriptions-' . now()->format('YmdHis') . '.xlsx');
    }

    public function exportPdf()
    {
        $subscriptions = WorkshopSubscription::with(['partner', 'location', 'serviceType'])
            ->orderByDesc('created_at')
            ->get();

        $pdf = Pdf::loadView('exports.workshop-subscriptions', [
            'subscriptions' => $subscriptions,
            'generatedAt' => now()->format('d M Y H:i'),
        ]);

        return $pdf->download('workshop-subscriptions-' . now()->format('YmdHis') . '.pdf');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('subscription', [
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'location_id' => [
                'required',
                Rule::exists('workshop_locations', 'id')
                    ->where(fn ($query) => $query->where('partner_id', $request->input('partner_id'))),
            ],
            'contact_id' => [
                'nullable',
                Rule::exists('workshop_contacts', 'id')
                    ->where(fn ($query) => $query->where('partner_id', $request->input('partner_id'))),
            ],
            'service_type_id' => ['required', 'exists:workshop_service_types,id'],
            'subscription_code' => ['required', 'string', 'max:100', 'unique:workshop_subscriptions,subscription_code'],
            'status' => ['required', 'in:active,pending,expired,paused'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        WorkshopSubscription::create($validated);

        return redirect()
            ->to(route('workshops.index') . '#subscriptions-table')
            ->with('success', 'Subscription workshop berhasil ditambahkan secara manual.');
    }

    public function update(Request $request, WorkshopSubscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'partner_id' => ['required', 'exists:workshop_partners,id'],
            'location_id' => [
                'required',
                Rule::exists('workshop_locations', 'id')
                    ->where(fn ($query) => $query->where('partner_id', $request->input('partner_id'))),
            ],
            'contact_id' => [
                'nullable',
                Rule::exists('workshop_contacts', 'id')
                    ->where(fn ($query) => $query->where('partner_id', $request->input('partner_id'))),
            ],
            'service_type_id' => ['required', 'exists:workshop_service_types,id'],
            'subscription_code' => ['required', 'string', 'max:100', 'unique:workshop_subscriptions,subscription_code,' . $subscription->id],
            'status' => ['required', 'in:active,pending,expired,paused'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $subscription->update($validated);

        return redirect()->route('workshops.index')->with('success', 'Subscription workshop berhasil diperbarui.');
    }

    public function destroy(WorkshopSubscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('workshops.index')->with('success', 'Subscription workshop berhasil dihapus.');
    }
}
