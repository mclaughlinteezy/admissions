@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 10px; border: 1px solid #000;">

    <div class="container card">
        <div class="card-header">
            <h5 class="modal-title" id="proofPaymentLabel">Upload Proof Of Payment: USD10</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('student.application.step.post', 10) }}" enctype="multipart/form-data">
                @csrf

                {{-- Hidden inputs if needed (adjust or remove as appropriate) --}}
                {{-- <input type="hidden" name="applicantid" value="{{ old('applicantid', $application->applicantid ?? '') }}"> --}}
                {{-- <input type="hidden" name="periodid" value="{{ old('periodid', $application->periodid ?? '') }}"> --}}
                {{-- <input type="hidden" name="applicationid" value="{{ old('applicationid', $application->id ?? '') }}"> --}}

                <div class="form-group">
                    <label for="paymentdate">Payment Date</label>
                    <input type="date" name="payment_date" id="paymentdate" class="form-control" value="{{ old('payment_date') }}" required>
                    @error('payment_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="bankfrom">Bank From</label>
                    <select class="form-control" name="bank_from" id="bankfrom" required>
                        <option value="">Select Bank</option>
                        <option value="AGRIBANK" {{ old('bank_from') == 'AGRIBANK' ? 'selected' : '' }}>AGRIBANK</option>
                        <option value="BANCABC" {{ old('bank_from') == 'BANCABC' ? 'selected' : '' }}>BANCABC</option>
                        <option value="CABS" {{ old('bank_from') == 'CABS' ? 'selected' : '' }}>CABS</option>
                        <option value="CBZ" {{ old('bank_from') == 'CBZ' ? 'selected' : '' }}>CBZ</option>
                        <option value="Ecobank" {{ old('bank_from') == 'Ecobank' ? 'selected' : '' }}>Ecobank</option>
                        <option value="FBC" {{ old('bank_from') == 'FBC' ? 'selected' : '' }}>FBC</option>
                        <option value="First Capital" {{ old('bank_from') == 'First Capital' ? 'selected' : '' }}>First Capital</option>
                        <option value="Metropolitan" {{ old('bank_from') == 'Metropolitan' ? 'selected' : '' }}>Metropolitan</option>
                        <option value="NEDBANK FORMERLY MBCA" {{ old('bank_from') == 'NEDBANK FORMERLY MBCA' ? 'selected' : '' }}>NEDBANK FORMERLY MBCA</option>
                        <option value="NMB" {{ old('bank_from') == 'NMB' ? 'selected' : '' }}>NMB</option>
                        <option value="POSB" {{ old('bank_from') == 'POSB' ? 'selected' : '' }}>POSB</option>
                        <option value="RENAISSANCE" {{ old('bank_from') == 'RENAISSANCE' ? 'selected' : '' }}>RENAISSANCE</option>
                        <option value="ROYAL BANK" {{ old('bank_from') == 'ROYAL BANK' ? 'selected' : '' }}>ROYAL BANK</option>
                        <option value="Stanbic" {{ old('bank_from') == 'Stanbic' ? 'selected' : '' }}>Stanbic</option>
                        <option value="Standard Chartered" {{ old('bank_from') == 'Standard Chartered' ? 'selected' : '' }}>Standard Chartered</option>
                        <option value="Steward" {{ old('bank_from') == 'Steward' ? 'selected' : '' }}>Steward</option>
                        <option value="TETRAD" {{ old('bank_from') == 'TETRAD' ? 'selected' : '' }}>TETRAD</option>
                        <option value="ZABG" {{ old('bank_from') == 'ZABG' ? 'selected' : '' }}>ZABG</option>
                        <option value="ZB" {{ old('bank_from') == 'ZB' ? 'selected' : '' }}>ZB</option>
                        <option value="ZBBS" {{ old('bank_from') == 'ZBBS' ? 'selected' : '' }}>ZBBS</option>
                        <option value="Ecocash" {{ old('bank_from') == 'Ecocash' ? 'selected' : '' }}>Ecocash</option>
                    </select>
                    @error('bank_from') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="bankto">To MSU Bank Account</label>
                    <select class="form-control" name="bank_to" id="bankto" required>
                        <option value="">Select Account</option>
                        <option value="BANC ABC NOSTRO-28624026633189" {{ old('bank_to') == 'BANC ABC NOSTRO-28624026633189' ? 'selected' : '' }}>BANC ABC NOSTRO-28624026633189</option>
                        <option value="ECOBANK-USD 5783600005622" {{ old('bank_to') == 'ECOBANK-USD 5783600005622' ? 'selected' : '' }}>ECOBANK-USD 5783600005622</option>
                        <option value="USD CBZ-10720772520202" {{ old('bank_to') == 'USD CBZ-10720772520202' ? 'selected' : '' }}>CBZ USD-10720772520202</option>
                        <option value="USD FBC-2237535960660" {{ old('bank_to') == 'USD FBC-2237535960660' ? 'selected' : '' }}>FBC USD -2237535960660</option>
                        <option value="ZB NOSTRO -4575486039405" {{ old('bank_to') == 'ZB NOSTRO -4575486039405' ? 'selected' : '' }}>ZB NOSTRO -4575486039405</option>
                        <option value="paynow" {{ old('bank_to') == 'paynow' ? 'selected' : '' }}>PAYNOW</option>
                    </select>
                    @error('bank_to') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="reference">Reference</label>
                    <input name="payment_reference" id="reference" type="text" class="form-control" value="{{ old('payment_reference') }}" required>
                    @error('payment_reference') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Amount Paid</label>
                    <input name="amount_paid" id="amount" type="number" class="form-control" value="{{ old('amount_paid') }}" required>
                    @error('amount_paid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="file">Proof of Payment</label>
                    <input name="proof_of_payment" type="file" id="file" accept=".pdf,.jpg,.jpeg,.png" class="form-control" required>
                    @error('proof_of_payment') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <a href="{{ route('student.application.step', 9) }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Submit Payment</button>

            </form>
        </div>
    </div>

</div>
@endsection
