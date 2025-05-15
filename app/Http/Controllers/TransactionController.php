<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stakeholder;
use App\Models\Transaction;
use App\Models\Notification;
use Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the form for creating a new transaction.
     *
     * @param string $stakeholderId
     * @return \Illuminate\View\View
     */
    public function create(string $stakeholderId)
    {
        $currentStakeholder = Stakeholder::find($stakeholderId);
        return view('transactions.newTransaction', [
            'currentStakeholder' => $currentStakeholder
        ]);
    }

    /**
     * Store a newly created transaction in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'inOut' => 'required',
            'amount' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/'
        ]);

        $newTransaction = new Transaction;
        $newTransaction->stakeholderId = $request->stakeholderId;
        $newTransaction->date = $request->date;
        $newTransaction->inOut = $request->inOut;
        $newTransaction->amount = $request->amount;

        $fromTo = "बाट";
        $action = "लिनुभयो";
        $item = 'रकम';

        if ($request->inOut == 'दिएको') {
            $newTransaction->amount = $request->amount * (-1);
            $fromTo = "लाई";
            $action = "दिनुभयो";
        }

        if ($request->remarks !== null) {
            $item = $request->remarks;
        }

        $newTransaction->remarks = $request->remarks;
        $newTransaction->user = Auth::user()->name;
        $newTransaction->save();

        $currentStakeholder = Stakeholder::find($request->stakeholderId);

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले " . $currentStakeholder->name . ' ' . $fromTo . ' रु. ' . $request->amount . ' बराबरको ' . $item . ' ' . $action . ' ।';
        $newNotification->save();

        return redirect()
            ->route('details', [
                'stakeholderId' => $request->stakeholderId
            ])
            ->with('pass', $currentStakeholder->name .' सँग नयाँ कारोवार थप गरिएको छ ।');
    }

    /**
     * Display the form for editing the specified transaction.
     *
     * @param string $transactionId
     * @return \Illuminate\View\View
     */
    public function edit(string $transactionId)
    {
        $currentTransaction = Transaction::with('stakeholder')->find($transactionId);
        return view('transactions.editTransaction', [
            'currentTransaction' => $currentTransaction
        ]);
    }

    /**
     * Update the specified transaction in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $transactionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $transactionId)
    {
        $request->validate([
            'date' => 'required',
            'inOut' => 'required',
            'amount' => 'required|regex:/^\d{1,13}(\.\d{1,2})?$/'
        ]);

        $currentTransaction = Transaction::with('stakeholder')->find($transactionId);

        $currentTransaction->date = $request->date;
        $currentTransaction->inOut = $request->inOut;
        $currentTransaction->amount = $request->amount;

        if ($request->inOut == 'दिएको') {
            $currentTransaction->amount = $request->amount * (-1);
        }

        $currentTransaction->remarks = $request->remarks;
        $currentTransaction->save();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले  " . $currentTransaction->stakeholder->name . '  को कारोवार सम्पादन गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('details', [
                'stakeholderId' => $currentTransaction->stakeholder->id
            ])
            ->with('pass', $currentTransaction->stakeholder->name .' सँगको कारोवार सम्पादन गरिएको छ ।');
    }

    /**
     * Remove the specified transaction from the database.
     *
     * @param string $transactionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $transactionId)
    {
        $currentTransaction = Transaction::with('stakeholder')->find($transactionId);
        $currentTransaction->delete();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले  " . $currentTransaction->stakeholder->name . '  को कारोवार डिलिट गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('details', [
                'stakeholderId' => $currentTransaction->stakeholder->id
            ])
            ->with('pass', $currentTransaction->stakeholder->name .' सँगको कारोवार डिलिट गरिएको छ ।');
    }

    /**
     * Remove all transactions of a specific stakeholder from the database.
     *
     * @param string $stakeholderId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyTransactions($stakeholderId)
    {
        $currentStakeholder = Stakeholder::find($stakeholderId);
        $currentStakeholder->transactions()->delete();

        $newNotification = new Notification;
        $newNotification->notification = auth()->user()->name . " ले  " . $currentStakeholder->name . '  का सम्पूर्ण कारोवारहरु डिलिट गर्नुभयो ।';
        $newNotification->save();

        return redirect()
            ->route('details', [
                'stakeholderId' => $stakeholderId
            ])
            ->with('pass', $currentStakeholder->name . ' का सम्पूर्ण कारोवारहरु डिलिट गरिएको छ ।');
    }
}
