@extends('layouts.master')

@section('title', 'View Record')

@section('content')

<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Record Details</h4>
            

            <div>
                <a href="javascript:void(0);" class="btn btn-light btn-sm shadow-sm" onclick="printRecord()">
                    <i class="fas fa-print text-primary mx-2"></i>Print
                </a>
                <a href="{{ url('admin/records') }}" class="btn btn-light btn-sm shadow-sm">
                        <i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back
                </a>
            </div>
           
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Patient Name:</b></h6>
                    <p class="text-capitalize"> {{ $record->user->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Resident Number:</b></h6>
                    <p>{{ $record->resident_number }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Phone Number:</b></h6>
                    <p>{{ $record->phone_number }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Birthday:</b></h6>

                    <p>{{ \Carbon\Carbon::parse($record->birthday)->format('F j, Y') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Gender:</b></h6>
                    <p class="text-capitalize">{{ $record->gender }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Address:</b></h6>
                    <p>{{ $record->address }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Medical History</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Past Medical History:</b></h6>
                    <p>{{ $record->past_medical_history }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Family Medical History:</b></h6>
                    <p>{{ $record->family_medical_history }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Current Medications:</b></h6>
                    <p>{{ $record->current_medications }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Treatment Plans:</b></h6>
                    <p>{{ $record->treatment_plans }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Test Results</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Lab Test Results:</b></h6>
                    <p>{{ $record->lab_test_results }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Physical Exam Notes:</b></h6>
                    <p>{{ $record->physical_exam_notes }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Appointments</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Appointment History:</b></h6>
                    <p>{{ $record->appointment_history }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Upcoming Appointments:</b></h6>
                    <p>{{ $record->upcoming_appointments }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Feedback and History</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Appointment Feedback:</b></h6>
                    <p>{{ $record->appointment_feedback }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Prescription History:</b></h6>
                    <p>{{ $record->prescription_history }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Allergies and Reactions</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Known Allergies:</b></h6>
                    <p>{{ $record->known_allergies }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Adverse Reactions:</b></h6>
                    <p>{{ $record->adverse_reactions }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Vaccination and Lifestyle</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Vaccination History:</b></h6>
                    <p>{{ $record->vaccination_history }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Lifestyle Factors:</b></h6>
                    <p>{{ $record->lifestyle_factors }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Social Determinants</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Social Determinants:</b></h6>
                    <p>{{ $record->social_determinants }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Communication Logs:</b></h6>
                    <p>{{ $record->communication_logs }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Care Plans and Generated Data</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Care Plans:</b></h6>
                    <p>{{ $record->care_plans }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Patient Generated Data:</b></h6>
                    <p>{{ $record->patient_generated_data }}</p>
                </div>
            </div>

            <hr>

            <h5 class="mt-4"><b>Insurance and Billing</b></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h6><b>Insurance Details:</b></h6>
                    <p>{{ $record->insurance_details }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6><b>Billing History:</b></h6>
                    <p>{{ $record->billing_history }}</p>
                </div>
            </div>

            <hr>

            <!-- Display Profile Picture Image -->
            @if($record->profile_image)
                <div class="mb-3">
                    <b>Profile Picture:</b><br>
                    <img src="{{ asset($record->profile_image) }}" alt="Profile Picture" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
            @endif

          


            @if(!empty($record->lab_results_image))
                <div class="row m-3 bg-white px-1 py-4 rounded">
                    <div class="rounded shadow-sm p-3">
                        <h6>Lab Test Result</h6>
                        @php
                            $labResultsFileType = pathinfo($record->lab_results_image, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($labResultsFileType, ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="#" data-toggle="modal" data-target="#labResultModal">
                                <img src="{{ asset($record->lab_results_image) }}" alt="Lab Results" class="img-fluid" style="max-width: 100%; height: auto;">
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="labResultModal" tabindex="-1" role="dialog" aria-labelledby="labResultModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="labResultModalLabel">Lab Test Result</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset($record->lab_results_image) }}" alt="Lab Results" class="img-fluid" style="max-width: 100%; height: auto;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Lab Results File: <a href="{{ asset($record->lab_results_image) }}" target="_blank">{{ basename($record->lab_results_image) }}</a></p>
                        @endif

                        <a href="{{ asset($record->lab_results_image) }}" download class="btn btn-primary mt-2">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endif

            @if(!empty($record->imaging_studies_image))
                <div class="row m-3 bg-white px-1 py-4 rounded">
                    <div class="rounded shadow-sm p-3">
                        <h6>Image Studies</h6>
                        @php
                            $imagingStudiesFileType = pathinfo($record->imaging_studies_image, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($imagingStudiesFileType, ['jpg', 'jpeg', 'png', 'gif']))
                            <a href="#" data-toggle="modal" data-target="#imagingStudiesModal">
                                <img src="{{ asset($record->imaging_studies_image) }}" alt="Imaging Studies" class="img-fluid" style="max-width: 100%; height: auto;">
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="imagingStudiesModal" tabindex="-1" role="dialog" aria-labelledby="imagingStudiesModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imagingStudiesModalLabel">Image Studies</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ asset($record->imaging_studies_image) }}" alt="Imaging Studies" class="img-fluid" style="max-width: 100%; height: auto;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Imaging Studies File: <a href="{{ asset($record->imaging_studies_image) }}" target="_blank">{{ basename($record->imaging_studies_image) }}</a></p>
                        @endif

                        <a href="{{ asset($record->imaging_studies_image) }}" download class="btn btn-primary mt-2">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


<style>
    @media print {
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff; /* White background for print */
        }

        /* Hide elements that should not be printed */
        .no-print {
            display: none;
        }

        /* Card styles */
        .card {
            border: none;
            box-shadow: none;
            margin: 0;
            padding: 0;
        }

        .card-header {
            background-color: #007bff; /* Bootstrap primary color */
            color: white;
            padding: 15px;
            text-align: center;
            border-bottom: 2px solid #0056b3; /* Darker border for separation */
        }

        .card-body {
            padding: 20px;
        }

        h4, h5, h6 {
            margin: 10px 0;
            color: #007bff; /* Use primary color for headings */
        }

        h4 {
            font-size: 24px; /* Larger font size for main title */
        }

        h5 {
            font-size: 20px; /* Slightly larger for section titles */
            border-bottom: 1px solid #ddd; /* Underline for section titles */
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        h6 {
            font-size: 16px; /* Standard size for subheadings */
            font-weight: bold;
        }

        /* Paragraph styles */
        p {
            font-size: 14px; /* Standard paragraph size */
            line-height: 1.5; /* Improved line height for readability */
            margin: 5px 0 15px; /* Spacing between paragraphs */
        }

        /* Image styles */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Section styles */
        .section {
            margin-bottom: 30px; /* Space between sections */
            padding: 15px;
            border: 1px solid #ddd; /* Light border around sections */
            border-radius: 5px; /* Rounded corners */
            background-color: #f9f9f9; /* Light background for sections */
        }

        /* Page break */
        .page-break {
            page-break-after: always;
        }
    }
</style>


<script>
    function printRecord() {
        var printWindow = window.open('', '_blank', 'width=800,height=600');
        printWindow.document.write('<html><head><title>Print Record</title>');
        printWindow.document.write('<link rel="stylesheet" href="{{ asset('path/to/your/css/bootstrap.min.css') }}">');
        printWindow.document.write('</head><body>');
        
        // Add the logo at the top
        printWindow.document.write('<div style="text-align: center; margin-bottom: 20px;">');
        printWindow.document.write('<img src="{{ asset('uploads/obeid-logo.png') }}" alt="Logo" style="max-width: 200px; height: auto;">'); // Adjust the path and size as needed
        printWindow.document.write('</div>');
        
        // Append the content of the current page
        printWindow.document.write(document.querySelector('.container-fluid').innerHTML);
        
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    }
</script>

@endsection