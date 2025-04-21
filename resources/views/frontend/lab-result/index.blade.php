@extends('layouts.app-nonav')

@section('title', 'Obeid Hospital')

@section('content')

<div class="container-fluid bg-blue p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('/') }}" class="btn btn-primary btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">Lab and Radiology Result</h5>
            </div>
        </div>
    </div>
    <div class="row mx-2 pt-3">
        <h5 class="font-bold text-capitalize text-white">{{ $user->name }}'s Record</h5>
    </div>

    @foreach($records as $record)
        

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

       

    @endforeach

</div>
@endsection