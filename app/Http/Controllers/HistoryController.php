<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\RentalBid;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function userSaleHistory(): View {
        $user = auth()->user();
        $company = Company::getDefaultCompany();
        $saleBids = $user->saleBids;

        return view('user.saleHistory', compact('company', 'saleBids'));
    }


    public function userRentalHistory(): View {
        $user = auth()->user();
        $company = Company::getDefaultCompany();
        $rentalBids = $user->rentalBids()->paginate(10);

        return view('user.rentalHistory', compact('company', 'rentalBids'));
    }

    public function sellerSaleHistory(): View {
        $user = auth()->user();
        $company = Company::getDefaultCompany();
        $ads = $user->advertisements()->where('type', 'sale')->paginate(10);

        return view('seller.saleHistory', compact('company', 'ads'));
    }

    public function sellerRentalOverview(): View {
        $user = auth()->user();
        $company = Company::getDefaultCompany();

        $rentalBids = RentalBid::whereHas('advertisement', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(10);




        return view('seller.agenda', compact('company', 'rentalBids'));
    }
}
