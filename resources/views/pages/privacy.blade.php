@extends('layouts.auth-centered')

@section('title', 'Privacy Notice')

@section('content')
    <div class="card m-3 bg-white rounded shadow-sm">
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <h4 class="fw-bold text-dark mt-2">Data Privacy Notice</h4>
                <p class="text-muted small">
                    Please review our structural data management rules before creating a profile.
                </p>
            </div>

            <!-- ENCLOSED PRIVACY SCROLL MATRIX -->
            <div class="scrollbox mb-4">
                <h6 class="fw-bold text-dark">1. Collection of System Operational Records</h6>
                <p>To register an institutional profile under the Master Data Repository Framework, we collect explicit
                    identifiers including your full legal identity name, corporate structural email address, and
                    transaction logging parameters.</p>

                <h6 class="fw-bold text-dark">2. Purposes of Processing Data</h6>
                <p>Your institutional information data structures are utilized strictly to maintain operational system
                    integrity, execute automated audit trail verifications, provide systemic email dispatch updates upon
                    account activation, and support authorization logging via the Spatie Security Engine layers.</p>

                <h6 class="fw-bold text-dark">3. Data Retentions & Governance Closures</h6>
                <p>System operational logs are backed up and securely preserved inside localized database containers
                    matching encrypted environments. Information records will not be redistributed, sold, or exposed to
                    third-party tracking metrics without judicial directives.</p>
            </div>

            <form action="{{ route('privacy.accept') }}" method="POST">
                @csrf

                {{-- Bootstrap 5 Form Check Syntax --}}
                <div class="form-check mb-4 text-start">
                    <input type="checkbox" class="form-check-input cursor-pointer" id="agree_terms" name="agree_terms"
                        required>
                    <label class="form-check-label small fw-bold text-dark cursor-pointer" for="agree_terms">
                        I have read, understood, and accept the global data privacy clauses.
                    </label>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <a href="/" class="btn btn-sm w-100 fw-bold text-white shadow-sm"
                            style="background-color: #495057;">
                            Decline
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-sm w-100 fw-bold text-white shadow-sm"
                            style="background-color: #0033A0;">
                            Proceed to Register <i class="fas fa-arrow-right ms-1 small"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* If your layout already handles alignment, you can drop this section */
        body {
            background-color: #f4f6f9;
        }

        .privacy-card {
            border-top: 4px solid #0033A0;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .scrollbox {
            height: 220px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 13px;
            color: #495057;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush
