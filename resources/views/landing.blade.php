<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Division Management Information System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom Brand Color Override Variables */
        :root {
            --brand-primary: #0046E4;
            --brand-primary-hover: #0032A0;
            --brand-primary-light: rgba(0, 70, 228, 0.06);
            --brand-dark: #0A0F1D;
            --card-border: #E6ECF8;
            --text-main: #1E293B;
            --text-muted: #64748B;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: var(--text-main);
            background-color: #F8FAFC !important;
        }

        /* Modernized Navbar */
        .navbar {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.85) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .navbar-brand {
            font-size: 0.95rem;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        /* Dynamic Interaction Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-brand {
            background-color: var(--brand-primary);
            color: #ffffff;
            border: 1px solid var(--brand-primary);
            font-weight: 600;
        }

        .btn-brand:hover,
        .btn-brand:focus {
            background-color: var(--brand-primary-hover);
            color: #ffffff;
            /* border-color: var(--brand-primary-hover); */
            /* transform: translateY(-1px); */
            /* box-shadow: 0 4px 12px rgba(0, 70, 228, 0.2); */
        }

        .btn-outline-brand {
            background-color: transparent;
            color: var(--brand-primary);
            border: 1px solid var(--card-border);
            font-weight: 600;
        }

        .btn-outline-brand:hover,
        .btn-outline-brand:focus {
            background-color: var(--brand-primary-light);
            color: var(--brand-primary-hover);
            border-color: var(--brand-primary);
            /* transform: translateY(-1px); */
        }

        /* Accent classes */
        .text-brand {
            color: var(--brand-primary) !important;
        }

        .bg-brand-light {
            background-color: var(--brand-primary-light) !important;
        }

        /* Bento Grid Style System Cards */
        .system-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1.25rem !important;
            border: 1px solid var(--card-border) !important;
            overflow: hidden;
            background: #ffffff;
        }

        .system-card:hover {
            /* transform: translateY(-6px); */
            /* box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important; */
            /* border-color: rgba(0, 70, 228, 0.3) !important; */
        }

        .feature-icon {
            width: 3.25rem;
            height: 3.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .system-card:hover .feature-icon {
            /* transform: scale(1.05); */
            background-color: var(--brand-primary) !important;
            color: #ffffff !important;
        }

        /* Typography & Layout Spacing Details */
        .section-tag {
            letter-spacing: 0.06em;
            font-size: 0.75rem;
            background-color: var(--brand-primary-light);
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            display: inline-block;
        }

        .card-title {
            letter-spacing: -0.01em;
        }

        p.text-muted {
            color: var(--text-muted) !important;
            line-height: 1.6;
        }

        footer {
            background-color: var(--brand-dark) !important;
        }
    </style>
</head>

<body>

    <!-- Navbar Navigation Section -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-brand d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('v1/images/division_logo_blue.png') }}" alt="Logo"
                    style="width: 38px; height: auto;">
                <div>
                    <span class="d-block text-dark fw-extrabold text-uppercase"
                        style="font-size: 0.8rem; letter-spacing: 0.05em;">Division Management</span>
                    <span class="d-block text-brand font-sans" style="font-size: 0.85rem;">Information System</span>
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    @auth
                        <!-- Logged In View -->
                        <a href="{{ route('logout') }}" class="btn btn-outline-brand px-3"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1.5"></i> Log Out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth

                    @guest
                        <!-- Guest View -->
                        <a href="{{ route('login') }}" class="btn btn-outline-brand px-3">
                            <i class="fas fa-sign-in-alt me-1.5"></i> Log In
                        </a>

                        <a href="/privacy-notice" class="btn btn-brand px-3">
                            Request Account <i class="fas fa-arrow-right ms-1.5"></i>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Systems & Portals Directory Segment -->
    <section id="systems" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5 mx-auto" style="max-width: 620px;">
                <span class="section-tag text-brand fw-bold text-uppercase mb-3">Application Directory</span>
                <h2 class="fw-bold text-dark display-6 mb-3" style="letter-spacing: -0.03em;">Available Information
                    Portals</h2>
                <p class="text-muted fs-6">Select an enterprise portal platform below to access core operational
                    modules, management dashboards, or specialized division profiles.</p>
            </div>

            <div class="row g-4 justify-content-center">
                {{-- System Card 1: HRIS --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">HRIS</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                Human Resource Information System for handling profile registrations, service logs, and
                                authorization tokens securely.
                            </p>
                            <a href="#"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- System Card 2: Document Tracking --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-folder-open"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">Document Tracking</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                Route communications, manage digital assets safely, and track document checkpoint
                                progress in real-time.
                            </p>
                            <a href="/dts"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- System Card 3: DCP Portal --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-desktop"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">DCP Portal</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                DepEd Computerization Program inventory monitor, system unit allocations, and electronic
                                logging frameworks.
                            </p>
                            <a href="#"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- System Card 4: OKD Portal --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">OKD Portal</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                Oplan Kalusugan sa DepEd portal containing targeted physical evaluation statistics,
                                healthcare profiles, and matrix parameters.
                            </p>
                            <a href="#"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- System Card 5: SGOD Workspace --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">SGOD Workspace</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                School Governance and Operations Division operational planning workspace, dynamic
                                indicators, and matrix summaries.
                            </p>
                            <a href="#"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card system-card h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center mb-4">
                                <div class="feature-icon bg-brand-light text-brand me-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="fw-bold text-dark card-title mb-0">Client Satisfactory System</h5>
                            </div>
                            <p class="text-muted small flex-grow-1 mb-4">
                                Client Satisfactory System for visitors with important matters in the office.
                            </p>
                            <a href="#"
                                class="btn btn-outline-brand w-100 py-2.5 mt-auto d-flex align-items-center justify-content-center gap-2">
                                Enter Portal <i class="fas fa-chevron-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sticky Base Global Footer Wrapper -->
    <footer class="text-white py-5">
        <div class="container text-center">
            <p class="small text-white-50 mb-2">&copy; {{ date('Y') }} DRMS Security Portal Platform. All Rights
                Reserved.</p>
            <p class="small text-white-50 opacity-50 mb-0" style="font-size: 0.75rem;">
                Powered securely with Laravel optimization frameworks and interactive interface controllers.
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
