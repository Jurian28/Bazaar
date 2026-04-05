<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class ContractController extends Controller {

    public function index() {
        $companies = Company::where('id', '!=', '1')->get();
        $company = Company::getDefaultCompany();

        return view('contract.index', compact('companies', 'company'));
    }


    public function downloadContract(Company $company) {
        if (auth()?->user()?->company?->id !== 1) abort(403);

        $title ='Business Contract: ' . $company->name;

        return Pdf::view('contract.pdf', ['title' => $title, 'company' => $company])
            ->format('a4')
            ->name($title . '.pdf')
            ->download();
    }


    public function showUploadContract(Company $contractCompany) {
        $company = Company::getDefaultCompany();
        return view('contract.upload', compact('contractCompany', 'company'));
    }

    public function uploadContract(Request $request, Company $company)
    {
        $request->validate([
            'contract' => 'required|file|mimes:pdf|max:10240', // max 10MB
        ]);

        $file = $request->file('contract');
        $filename = 'contract_' . $company->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('contracts', $filename);

        $contract = Contract::create([
            'company_id' => $company->id,
            'path' => $path,
        ]);

        return redirect()->back()->with('success', 'Contract succesvol geüpload!');
    }

    public function signContract(Contract $contract) {
        $contract->update([
            'signed_at' => now(),
        ]);
        return redirect()->back();
    }
}
