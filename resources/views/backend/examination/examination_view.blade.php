@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Examination Details</h4>
                        <div class="page-title-right">
                            <a href="{{ url()->previous() }}" class="btn btn-dark btn-rounded waves-effect waves-light">
                                <i class="fas fa-arrow-left"> Back</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-4 border-bottom pb-3">
                                <div class="col-md-3">
                                    <h6 class="text-muted">Patient Name</h6>
                                    <p class="fw-bold">{{ $examination->customer?->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted">Date of Exam</h6>
                                    <p class="fw-bold">{{ date('d-m-Y', strtotime($examination->date)) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted">Examined By (Doctor)</h6>
                                    <p class="fw-bold">{{ $examination->doctor_name ?: ($examination->creator?->name ?? 'N/A') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="text-muted">Location</h6>
                                    <p class="fw-bold">{{ $examination->location?->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#history" role="tab">
                                        <span class="d-none d-sm-block">History</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#vitals" role="tab">
                                        <span class="d-none d-sm-block">Vitals</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#ocular" role="tab">
                                        <span class="d-none d-sm-block">Ocular Exam</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#sle" role="tab">
                                        <span class="d-none d-sm-block">Slit Lamp (SLE)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#plan" role="tab">
                                        <span class="d-none d-sm-block">Plan & Assessment</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <!-- History Tab -->
                                <div class="tab-pane active" id="history" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-primary small fw-bold">Chief Complaint</h6>
                                            <p class="p-2 border rounded bg-light">{{ $examination->chief_complaint ?: 'None recorded' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-primary small fw-bold">History of Present Illness (HPI)</h6>
                                            <p class="p-2 border rounded bg-light">{{ $examination->hpi ?: 'None recorded' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-primary small fw-bold">Past Ocular History & Meds</h6>
                                            <p class="p-2 border rounded bg-light">{{ $examination->past_ocular_history ?: 'None recorded' }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <h6 class="text-primary small fw-bold">Family & Social History</h6>
                                            <p class="p-2 border rounded bg-light">{{ $examination->social_history ?: 'None recorded' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vitals Tab -->
                                <div class="tab-pane" id="vitals" role="tabpanel">
                                    <div class="row text-center">
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">Temp (°C)</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->body_temperature ?: '--' }}</p>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">Pulse (BPM)</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->pulse_rate ?: '--' }}</p>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">SpO2 (%)</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->oxygen_saturation ?: '--' }}</p>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">BP (mmHg)</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->blood_pressure ?: '--' }}</p>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">Respiration</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->respiration_rate ?: '--' }}</p>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <h6 class="text-muted small">Glucose</h6>
                                            <p class="fs-5 fw-bold">{{ $examination->blood_glucose ?: '--' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ocular Exam Tab -->
                                <div class="tab-pane" id="ocular" role="tabpanel">
                                    <h6 class="mb-3 text-primary fw-bold">Visual Acuity ({{ $examination->va_chart_used ?: 'N/A' }})</h6>
                                    <div class="row mb-4">
                                        <div class="col-md-6 border-end">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-info text-center">
                                                    <tr><th colspan="2">Right Eye (OD)</th></tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>Unaided</td><td class="text-center fw-bold">{{ $examination->va_od_unaided ?: '--' }}</td></tr>
                                                    <tr><td>Aided</td><td class="text-center fw-bold">{{ $examination->va_od_aided ?: '--' }}</td></tr>
                                                    <tr><td>Pinhole</td><td class="text-center fw-bold">{{ $examination->va_od_pinhole ?: '--' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-sm table-bordered">
                                                <thead class="table-info text-center">
                                                    <tr><th colspan="2">Left Eye (OS)</th></tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td>Unaided</td><td class="text-center fw-bold">{{ $examination->va_os_unaided ?: '--' }}</td></tr>
                                                    <tr><td>Aided</td><td class="text-center fw-bold">{{ $examination->va_os_aided ?: '--' }}</td></tr>
                                                    <tr><td>Pinhole</td><td class="text-center fw-bold">{{ $examination->va_os_pinhole ?: '--' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <h6 class="mb-3 text-primary fw-bold pt-3">Intraocular Pressure (IOP)</h6>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="small text-muted mb-1">Tonometer Type: {{ $examination->tonometer_type ?: 'Not specified' }}</p>
                                            <div class="d-flex gap-5 fs-5">
                                                <div>OD: <span class="fw-bold">{{ $examination->iop_od ?: '--' }}</span> mmHg</div>
                                                <div>OS: <span class="fw-bold">{{ $examination->iop_os ?: '--' }}</span> mmHg</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SLE Tab -->
                                <div class="tab-pane" id="sle" role="tabpanel">
                                    <div class="row">
                                        @php
                                            $sle_fields = [
                                                'lids_lashes' => 'Lids and Lashes',
                                                'conjunctiva' => 'Conjunctiva',
                                                'sclera' => 'Sclera',
                                                'cornea' => 'Cornea',
                                                'anterior_chamber' => 'Anterior Chamber',
                                                'iris' => 'Iris',
                                                'lens' => 'Lens'
                                            ];
                                        @endphp
                                        <div class="col-md-6 border-end">
                                            <h6 class="mb-3 text-primary fw-bold">Right Eye (OD)</h6>
                                            <table class="table table-sm">
                                                @foreach($sle_fields as $field => $label)
                                                    @php $val = 'sle_od_' . $field; @endphp
                                                    <tr><td class="text-muted small" style="width: 40%">{{ $label }}</td><td class="fw-bold">{{ $examination->$val ?: '--' }}</td></tr>
                                                @endforeach
                                                <tr><td class="text-muted small">Pupil (Size/Shape/Reaction)</td><td class="fw-bold">{{ $examination->sle_od_pupil_size ?: '--' }} mm / {{ $examination->sle_od_pupil_shape ?: '--' }} / {{ $examination->sle_od_pupil_reaction ?: '--' }}</td></tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-3 text-primary fw-bold">Left Eye (OS)</h6>
                                            <table class="table table-sm">
                                                @foreach($sle_fields as $field => $label)
                                                    @php $val = 'sle_os_' . $field; @endphp
                                                    <tr><td class="text-muted small" style="width: 40%">{{ $label }}</td><td class="fw-bold">{{ $examination->$val ?: '--' }}</td></tr>
                                                @endforeach
                                                <tr><td class="text-muted small">Pupil (Size/Shape/Reaction)</td><td class="fw-bold">{{ $examination->sle_os_pupil_size ?: '--' }} mm / {{ $examination->sle_os_pupil_shape ?: '--' }} / {{ $examination->sle_os_pupil_reaction ?: '--' }}</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Plan Tab -->
                                <div class="tab-pane" id="plan" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <h6 class="text-primary small fw-bold">Investigations / Procedures</h6>
                                            <p class="p-3 border rounded bg-light">{{ $examination->investigations ?: 'None recorded' }}</p>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <h6 class="text-primary small fw-bold">Differential Diagnosis</h6>
                                            <p class="p-3 border rounded bg-light">{{ $examination->differential_diagnosis ?: 'None recorded' }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h6 class="text-primary small fw-bold">Plan of Management</h6>
                                            <p class="p-3 border rounded bg-light" style="min-height: 100px">{{ $examination->management_plan ?: 'None recorded' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
