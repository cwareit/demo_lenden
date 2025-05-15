<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stakeholder;
use App\Models\Transaction;
use App\Models\Notification;

class StakeholderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of stakeholders along with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Current authenticated user ID
        $userId = auth()->id();

        // Count the number of notifications that the current user has not read
        $unreadCount = Notification::whereDoesntHave('readers', function ($query) use ($userId) {
            $query->where('readerId', $userId);
        })->count();

        $stakeholders = Stakeholder::orderBy('id', 'desc')->get();
        $stakeholderCount = Stakeholder::count();

        // Initialize variables for sum of transaction amounts
        $totalTaken = 0;
        $totalGiven = 0;

        foreach ($stakeholders as $stakeholder) {
            $total = Transaction::where('stakeholderId', $stakeholder->id)->sum('amount');
            $stakeholder->total = $total;

            // Update totalTaken or totalGiven based on the transaction amount
            if ($stakeholder->total > 0) {
                $totalTaken += $stakeholder->total;
            } elseif ($stakeholder->total < 0) {
                $totalGiven += $stakeholder->total;
            }
        }

        return view('stakeholders.stakeholders', [
            'stakeholders' => $stakeholders,
            'totalGiven' => $totalGiven,
            'totalTaken' => $totalTaken,
            'stakeholderCount' => $stakeholderCount,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Show the form for creating a new stakeholder.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('stakeholders.newStakeholder');
    }

    /**
     * Store a newly created stakeholder in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
        ]);

        $newStakeholder = new Stakeholder;
        $newStakeholder->name = $request->name;
        $newStakeholder->address = $request->address;
        $newStakeholder->contact = $request->contact;
        $newStakeholder->save();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले नयाँ सरोकारवाला " . $request->name . ' थप गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('stakeholders')
            ->with('pass', 'नयाँ सरोकारवाला '.$request->name.' थप गरिएको छ ।');
    }

    /**
     * Display the details of a specific stakeholder.
     *
     * @param string $stakeholderId
     * @return \Illuminate\View\View
     */
    public function show(string $stakeholderId)
    {
        $currentStakeholder = Stakeholder::find($stakeholderId);

        $transactions = $currentStakeholder->transactions()->orderBy('created_at')->get();
        $cumulativeSum = 0;

        foreach ($transactions as $transaction) {
            $cumulativeSum += $transaction->amount;
            $transaction->cumulative_sum = round($cumulativeSum, 2);
        }

        return view('stakeholders.details', [
            'currentStakeholder' => $currentStakeholder,
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for editing the specified stakeholder.
     *
     * @param string $stakeholderId
     * @return \Illuminate\View\View
     */
    public function edit(string $stakeholderId)
    {
        $currentStakeholder = Stakeholder::find($stakeholderId);

        return view('stakeholders.editStakeholder', [
            'currentStakeholder' => $currentStakeholder
        ]);
    }

    /**
     * Update the specified stakeholder's details in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $stakeholderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $stakeholderId)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required',
        ]);

        $currentStakeholder = Stakeholder::find($stakeholderId);

        $currentStakeholder->name = $request->name;
        $currentStakeholder->address = $request->address;
        $currentStakeholder->contact = $request->contact;
        $currentStakeholder->update();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले " . $currentStakeholder->name . ' का विवरणहरु सम्पादन गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('details', [
                'stakeholderId' => $stakeholderId
            ])
            ->with('pass', $currentStakeholder->name . ' का व्यक्तिगत विवरणहरु सम्पादन गरिएको छ ।');
    }

    /**
     * Remove the specified stakeholder from the database along with their transactions.
     *
     * @param string $stakeholderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $stakeholderId)
    {
        $currentStakeholder = Stakeholder::find($stakeholderId);
        $currentStakeholder->transactions()->delete();
        $currentStakeholder->delete();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले " . $currentStakeholder->name . ' का सम्पूर्ण कारोवारहरु साथै व्यक्तिगत विवरणहरु समेत डिलिट गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('stakeholders')
            ->with('pass', $currentStakeholder->name . ' का सम्पूर्ण कारोवारहरु साथै व्यक्तिगत विवरणहरु समेत डिलिट गरिएको छ ।');
    }
}
