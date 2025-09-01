<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:manage-wallet');
    }

    public function balance()
    {
        $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();
        return response()->json([
            'data' => [
                'balance' => $wallet->balance,
                'currency' => 'SAR', // أو العملة اللي بتستخدمها
            ]
        ]);
    }

    public function deposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string', // مثلاً: visa, mastercard
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.myfatoorah.token'),
                'Content-Type' => 'application/json',
            ])->post(config('services.myfatoorah.url') . '/v2/InitiatePayment', [
                'InvoiceAmount' => $validated['amount'],
                // 'CurrencyIso' => 'SAR', // أو العملة المناسبة
                'CurrencyIso' => 'EGP',
                'Language' => $request->header('Accept-Language', 'en'),
            ]);

            if ($response->failed()) {
                \Log::error('MyFatoorah payment initiation failed', [
                    'user_id' => Auth::id(),
                    'response' => $response->body(),
                ]);
                return response()->json(['message' => 'Payment initiation failed'], 400);
            }

            $paymentData = $response->json();
            $paymentId = $paymentData['Data']['PaymentId'];

            // إنشاء Transaction مؤقت
            $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();
            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $validated['amount'],
                'type' => 'deposit',
                'status' => 'pending',
                'slug' => Str::slug('deposit-' . $paymentId . '-' . now()->timestamp),
                'is_active' => true,
            ]);

            return response()->json([
                'message' => 'Payment initiated successfully',
                'payment_url' => $paymentData['Data']['PaymentURL'],
                'transaction_id' => $transaction->slug,
            ]);
        } catch (\Exception $e) {
            \Log::error('Deposit failed', [
                'user_id' => Auth::id(),
                'input' => $request->all(),
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Failed to initiate deposit',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_account' => 'required|string', // تفاصيل الحساب البنكي
        ]);

        $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();
        if ($wallet->balance < $validated['amount']) {
            return response()->json(['message' => 'Insufficient wallet balance'], 422);
        }

        try {
            // طلب سحب عبر MyFatoorah (تحتاج API endpoint للسحب)
            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . config('services.myfatoorah.token'),
            //     'Content-Type' => 'application/json',
            // ])->post(config('services.myfatoorah.url') . '/v2/ExecutePayment', [
            //     'PaymentMethodId' => 'bank_transfer', // أو الطريقة المناسبة
            //     'InvoiceAmount' => $validated['amount'],
            //     // 'CurrencyIso' => 'SAR',
            //     'CurrencyIso' => 'EGP',

            //     'CustomerName' => Auth::user()->name,
            //     'BankAccount' => $validated['bank_account'],
            // ]);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.myfatoorah.token'),
                'Content-Type' => 'application/json',
            ])->post(config('services.myfatoorah.url') . '/v2/InitiatePayment', [
                'InvoiceAmount' => $validated['amount'],
                'CurrencyIso' => 'EGP', // هنا غيرتها لـ الجنيه المصري
                'Language' => $request->header('Accept-Language', 'en'),
            ]);


            if ($response->failed()) {
                \Log::error('MyFatoorah withdrawal failed', [
                    'user_id' => Auth::id(),
                    'response' => $response->body(),
                ]);
                return response()->json(['message' => 'Withdrawal request failed'], 400);
            }

            $paymentData = $response->json();
            $paymentId = $paymentData['Data']['PaymentId'];

            return DB::transaction(function () use ($wallet, $validated, $paymentId) {
                $wallet->decrement('balance', $validated['amount']);

                $withdrawal = WithdrawalRequest::create([
                    'user_id' => Auth::id(),
                    'amount' => $validated['amount'],
                    'status' => 'pending',
                    'slug' => Str::slug('withdraw-' . $paymentId . '-' . now()->timestamp),
                    'is_active' => true,
                ]);

                Transaction::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $validated['amount'],
                    'type' => 'withdraw',
                    'status' => 'pending',
                    'slug' => Str::slug('withdraw-' . $paymentId . '-' . now()->timestamp),
                    'is_active' => true,
                ]);

                return response()->json([
                    'message' => 'Withdrawal request created successfully',
                    'data' => $withdrawal,
                ]);
            });
        } catch (\Exception $e) {
            \Log::error('Withdrawal failed', [
                'user_id' => Auth::id(),
                'input' => $request->all(),
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'message' => 'Failed to initiate withdrawal',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        try {
            $data = $request->all();
            if ($data['EventType'] == 1) { // Transaction Success
                $transactionId = $data['Data']['TransactionId'];
                $transaction = Transaction::where('slug', $transactionId)->firstOrFail();
                $transaction->update(['status' => 'completed']);
                
                $wallet = Wallet::find($transaction->wallet_id);
                if ($transaction->type == 'deposit') {
                    $wallet->increment('balance', $transaction->amount);
                } elseif ($transaction->type == 'withdraw') {
                    WithdrawalRequest::where('slug', $transactionId)->update(['status' => 'completed']);
                }
            }
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            \Log::error('Webhook handling failed', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Webhook handling failed'], 500);
        }
    }
}
?>