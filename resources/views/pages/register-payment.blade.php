@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-light text-center">
                    <h4>Payment</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.process-payment') }}">
                        @csrf

                        <h1 class="my-4 fw-normal text-center" style="font-size: 2rem;">Registration price:
                            <b>{{ number_format($registrationPrice, 2) }}</b>
                        </h1>

                        <div class="form-group mb-3">
                            <label for="payment_amount" class="form-label">Payment Amount</label>
                            <input type="number" name="payment" id="payment_amount"
                                class="form-control @error('payment') is-invalid @enderror" value="{{ old('payment') }}"
                                required autofocus />
                            @error('payment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="overpaid" value="0">

                        <button type="submit" class="btn btn-primary w-100"
                            style="background-color: #007bff; border: none;">
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>


        @if ($overpaidAmount > 0)
            <div class="modal fade" id="overpaidModal" tabindex="-1" aria-labelledby="overpaidModalLabel">

                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="overpaidModalLabel">Overpayment Notice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Sorry, you have overpaid by <b>${{ number_format($overpaidAmount, 2) }}</b>. Would you like
                                to enter the balance into your wallet?</p>
                            <p>Registration Price: <b>${{ number_format($registrationPrice, 2) }}</b></p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('user.process-payment') }}">
                                @csrf
                                <input type="hidden" name="payment" id="payment_amount" value="{{ $payment }}" />

                                <input type="hidden" name="overpaid" value="1" id="overpaidInput">
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #007bff; border: none;">
                                    Yes, save
                                    balance</button>
                            </form>
                            <button type="button" class="btn btn-danger" id="retryPaymentButton"
                                style="background-color: #dc3545; border: none;">
                                No, retry payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            @if ($overpaidAmount > 0)
                $('#overpaidModal').modal('show');
            @endif

            const overpaidInput = document.getElementById('overpaidInput');

            $('#retryPaymentButton').click(function() {
                overpaidInput.value = '0';

                $('#overpaidModal').modal('hide');
            });
        });
    </script>
@endsection
