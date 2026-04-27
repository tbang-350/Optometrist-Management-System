@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">All Ophthalmology Examinations</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <button type="button" class="btn btn-dark btn-rounded waves-effect waves-light" 
                                    style="float:right" data-bs-toggle="modal" data-bs-target="#addExaminationModal">
                                <i class="fas fa-plus-circle"> Add Examination</i>
                            </button>

                            <br><br><br>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Date</th>
                                        <th>Patient Name</th>
                                        <th>Doctor</th>
                                        <th>Chief Complaint</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($examinations as $key => $item)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>
                                            <td> {{ $item->customer?->name ?? 'N/A' }} </td>
                                            <td> {{ $item->doctor_name ?: ($item->creator?->name ?? 'N/A') }} </td>
                                            <td> {{ Str::limit($item->chief_complaint, 30) }} </td>
                                            <td>
                                                <a href="{{ route('examination.view', $item->id) }}"
                                                    class="btn btn-info sm" title="View Details"> 
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('examination.delete', $item->id) }}"
                                                    class="btn btn-danger sm" title="Delete" id="delete"> 
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>

    <!-- Modal for Adding Examination -->
    <div class="modal fade" id="addExaminationModal" tabindex="-1" aria-labelledby="addExaminationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExaminationModalLabel">New Ophthalmology Encounter Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('examination.store') }}" id="examinationForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#history" role="tab">
                                    <span class="d-none d-sm-block">History & Patient</span>
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
                            <!-- History & Patient Tab -->
                            <div class="tab-pane active" id="history" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="customer_id" class="form-label">Select Patient <span class="text-danger">*</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control select2" required style="width: 100%;">
                                            <option value="">Select Patient</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phonenumber }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Doctor's Name <span class="text-danger">*</span></label>
                                        <input type="text" name="doctor_name" class="form-control" required placeholder="Dr. ...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Chief Complaint</label>
                                        <textarea name="chief_complaint" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">History of Present Illness (HPI)</label>
                                        <textarea name="hpi" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Past Ocular History & Meds</label>
                                        <textarea name="past_ocular_history" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Family & Social History</label>
                                        <textarea name="social_history" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Vitals Tab -->
                            <div class="tab-pane" id="vitals" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Temp (°C)</label>
                                        <input type="number" step="0.1" name="body_temperature" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Pulse (BPM)</label>
                                        <input type="number" name="pulse_rate" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">SpO2 (%)</label>
                                        <input type="number" step="0.1" name="oxygen_saturation" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Blood Pressure (mmHg)</label>
                                        <input type="text" name="blood_pressure" class="form-control" placeholder="120/80">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Respiration (BPM)</label>
                                        <input type="number" name="respiration_rate" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Blood Glucose (mg/dl)</label>
                                        <input type="number" step="0.1" name="blood_glucose" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Ocular Exam Tab -->
                            <div class="tab-pane" id="ocular" role="tabpanel">
                                <h6 class="mb-3 text-primary">Visual Acuity</h6>
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Chart Used</label>
                                        <input type="text" name="va_chart_used" class="form-control" placeholder="Snellen, LogMAR, etc.">
                                    </div>
                                    <div class="col-md-6 border-end">
                                        <label class="badge bg-info mb-2">Right Eye (OD)</label>
                                        <div class="mb-2">
                                            <label class="small">Unaided</label>
                                            <input type="text" name="va_od_unaided" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-2">
                                            <label class="small">Aided</label>
                                            <input type="text" name="va_od_aided" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-2">
                                            <label class="small">Pinhole</label>
                                            <input type="text" name="va_od_pinhole" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="badge bg-info mb-2">Left Eye (OS)</label>
                                        <div class="mb-2">
                                            <label class="small">Unaided</label>
                                            <input type="text" name="va_os_unaided" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-2">
                                            <label class="small">Aided</label>
                                            <input type="text" name="va_os_aided" class="form-control form-control-sm">
                                        </div>
                                        <div class="mb-2">
                                            <label class="small">Pinhole</label>
                                            <input type="text" name="va_os_pinhole" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mb-3 text-primary border-top pt-3">Intraocular Pressure (IOP)</h6>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Tonometer Type</label>
                                        <input type="text" name="tonometer_type" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">OD (mmHg)</label>
                                        <input type="number" step="0.1" name="iop_od" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">OS (mmHg)</label>
                                        <input type="number" step="0.1" name="iop_os" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- SLE Tab -->
                            <div class="tab-pane" id="sle" role="tabpanel">
                                <div class="row">
                                    <!-- OD Column -->
                                    <div class="col-md-6 border-end">
                                        <h6 class="mb-3 text-primary">Right Eye (OD)</h6>
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
                                        @foreach($sle_fields as $field => $label)
                                            <div class="mb-2">
                                                <label class="small">{{ $label }}</label>
                                                <input type="text" name="sle_od_{{ $field }}" class="form-control form-control-sm">
                                            </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small">Pupil Size</label>
                                                <input type="number" step="0.1" name="sle_od_pupil_size" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-4">
                                                <label class="small">Shape</label>
                                                <input type="text" name="sle_od_pupil_shape" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-4">
                                                <label class="small">Reaction</label>
                                                <input type="text" name="sle_od_pupil_reaction" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- OS Column -->
                                    <div class="col-md-6">
                                        <h6 class="mb-3 text-primary">Left Eye (OS)</h6>
                                        @foreach($sle_fields as $field => $label)
                                            <div class="mb-2">
                                                <label class="small">{{ $label }}</label>
                                                <input type="text" name="sle_os_{{ $field }}" class="form-control form-control-sm">
                                            </div>
                                        @endforeach
                                        <div class="row">
                                            <div class="col-4">
                                                <label class="small">Pupil Size</label>
                                                <input type="number" step="0.1" name="sle_os_pupil_size" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-4">
                                                <label class="small">Shape</label>
                                                <input type="text" name="sle_os_pupil_shape" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-4">
                                                <label class="small">Reaction</label>
                                                <input type="text" name="sle_os_pupil_reaction" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Plan Tab -->
                            <div class="tab-pane" id="plan" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Investigations / Procedures</label>
                                        <textarea name="investigations" class="form-control" rows="3" placeholder="Fundoscopy, OCT, etc."></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Differential Diagnosis</label>
                                        <textarea name="differential_diagnosis" class="form-control" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Plan of Management</label>
                                        <textarea name="management_plan" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Examination</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2 inside the modal
            $('#addExaminationModal').on('shown.bs.modal', function () {
                $('.select2').select2({
                    dropdownParent: $('#addExaminationModal')
                });
            });
        });
    </script>
@endsection
