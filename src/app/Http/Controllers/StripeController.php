<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StripeController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        Gate::authorize('stripeAccountIdNull', $user);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $account = $stripe->accounts->create([
            'type' => 'express',
            'country' => 'JP',
            'business_type' => 'individual',
            'email' => Auth::user()->email,
            'business_profile' => [
                'mcc' => '7278',
                'url' => 'https://b058-14-133-79-100.ngrok-free.app',
                'product_description' => 'フリマ用出品者アカウント'
            ],
        ]);
        $link = $stripe->accountLinks->create([
            'account' => $account->id,
            'type' => 'account_onboarding',
            'return_url' => config('app.return_url') . 'stripe/' . $account->id,
            'refresh_url' => config('app.return_url'),
            'collect' => 'eventually_due',
        ]);
        return redirect($link->url);
    }

    public function update(Request $request)
    {
        $accountId = $request->route('account_id');
        User::find(Auth::user()->id)->update(['stripe_account_id' => $accountId]);
        return redirect('sell');
    }
}
