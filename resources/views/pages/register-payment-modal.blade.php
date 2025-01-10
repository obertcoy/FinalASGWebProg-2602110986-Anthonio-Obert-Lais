@extends('layouts.main')

@section('content')
    <!-- Payment Modal -->
    @if (isset($overpaidAmount))
        <div class="modal fade" id="overpaidModal" tabindex="-1" aria-labelledby="overpaidModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="overpaidModalLabel">Overpayment Notice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Sorry, you have overpaid by <b>${{ number_format($overpaidAmount, 2) }}</b>. Would you like to enter the balance into your wallet?</p>
                        <p>Registration Price: <b>${{ number_format($registrationPrice, 2) }}</b></p>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('user.save_balance') }}">
                            @csrf
                            <input type="hidden" name="overpaidAmount" value="{{ $overpaidAmount }}">
                            <button type="submit" name="save_balance" value="yes" class="btn btn-success">Yes, save balance</button>
                        </form>
                        <a href="{{ route('user.payment') }}" class="btn btn-danger">No, retry payment</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Your regular payment form here if no overpayment -->
    <form method="POST" action="{{ route('user.create') }}">
        @csrf

        <h1 class="my-4 fw-normal text-center" style="font-size: 2rem;">Registration price: <b>{{ session('registration_price') }}</b></h1>

        <div class="form-group mb-3">
            <label for="payment_amount" class="form-label">Payment Amount</label>
            <input type="number" name="payment" id="payment_amount"
                class="form-control @error('payment') is-invalid @enderror" value="{{ old('payment') }}"
                required autofocus />
            @error('payment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="background-color: #007bff; border: none;">
            Pay Now
        </button>
    </form>
@endsection
