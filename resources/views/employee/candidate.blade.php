@extends('employee.layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12 col-lg-10">
        <div class="wrap">
            <div class="form-box p-4 p-md-5">
                <div class="d-flex">
                    <div class="w-100">
                        <h4><b>Candidate Details</b></h4>
                    </div>
                </div>
                <br>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Candidate Name:</b> {{ $data->candidate_name ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Department:</b> {{ $data->department_name ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Interview Date:</b> {{ \Carbon\Carbon::parse($data->interview_date_time)->format('j F Y g:i a') ?? '' }}
                    </div>
                    <div class="col-md-6">
                        <b>Status:</b> {{ $data->interview_status ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Additional Notes</b> {{ $data->additional_notes ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Interview type:</b> {{ $data->interview_type ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Candidate Email </b> {{ $data->candidate_email ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Candidate Phone:</b> {{ $data->candidate_phone ?? '' }}
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Candidate Address </b> {{ $data->address ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Job Applied For:</b> {{ $data->job_applied_for ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Candidate Status </b> {{ $data->candidate_status ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Experience:</b> {{ $data->experience ?? '' }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Candidate Position </b> {{ $data->position ?? ''  }}
                    </div>
                    <div class="col-md-6">
                        <b>Shift:</b> {{ $data->candidate_shift ?? '' }}
                    </div>
                </div>


                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Reason for change </b> {{ $data->reason_for_change ?? ''  }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <b>Cover Letter:</b>
                        <a href="{{ url($data->cover_letter_path ?? '' ) }}" target="_blank" class="btn btn-primary btn-sm">Download</a>
                    </div>
                    <div class="col-md-6">
                        <b>Resume:</b>
                        <a href="{{ url($data->resume_path ?? '' ) }}" target="_blank" class="btn btn-primary btn-sm">Download</a>
                    </div>
                </div>


                <hr>
                <h5 class="mb-3">Additional Information</h5>
                <form method="POST" action="{{ route('candidate.feedback', $id) }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="feedback" class="col-sm-3 col-form-label">Feedback</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('interview_feedback') is-invalid @enderror" id="feedback" name="interview_feedback" rows="3">
                            {{ $data->interview_feedback ?? ''  }}
                            </textarea>
                            @error('interview_feedback')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="feedback" class="col-sm-3 col-form-label">Follow up action</label>
                        <div class="col-sm-9">
                            <textarea class="form-control @error('follow_up_action') is-invalid @enderror" id="feedback" name="follow_up_action" rows="3">
                            {{ $data->follow_up_action ?? ''  }}
                            </textarea>
                            @error('follow_up_action')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection