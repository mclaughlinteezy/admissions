@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 6: Work Experience</h2>

    <form method="POST" action="{{ route('student.application.step.post', 6) }}">
        @csrf

        @php
        $experiences = old('work_experience');

        if (!$experiences) {
            $experiences = is_string($application->work_experience)
                ? json_decode($application->work_experience, true)
                : ($application->work_experience ?? []);
        }
        @endphp

        <div id="work-experience-wrapper">
            @forelse($experiences as $index => $exp)
                <div class="work-experience-entry" style="border: solid 1px #DDD; margin: 0; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[{{ $index }}][companyname]" placeholder="Company Name" value="{{ $exp['companyname'] ?? '' }}" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[{{ $index }}][jobtitle]" placeholder="Job Title" value="{{ $exp['jobtitle'] ?? '' }}" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-sm-1">From</div>
                        <div class="col-sm-3">
                            <select class="form-control" name="work_experience[{{ $index }}][from_month]" required>
                                <option value="">Select Month</option>
                                @foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $val => $label)
                                    <option value="{{ $val }}" {{ ($exp['from_month'] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[{{ $index }}][from_year]" required>
                                <option value="">Select Year</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}" {{ ($exp['from_year'] ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-sm-1">To</div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[{{ $index }}][to_month]">
                                <option value="">Current</option>
                                @foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $val => $label)
                                    <option value="{{ $val }}" {{ ($exp['to_month'] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[{{ $index }}][to_year]">
                                <option value="">Current</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}" {{ ($exp['to_year'] ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Show one blank entry if no data exists --}}
                {{-- <div class="work-experience-entry" style="border: solid 1px #DDD; margin: 0; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[0][companyname]" placeholder="Company Name" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[0][jobtitle]" placeholder="Job Title" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 10px;">
                        <div class="col-sm-1">From</div>
                        <div class="col-sm-3">
                            <select class="form-control" name="work_experience[0][from_month]" required>
                                <option value="">Select Month</option>
                                @foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[0][from_year]" required>
                                <option value="">Select Year</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-sm-1">To</div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[0][to_month]">
                                <option value="">Current</option>
                                @foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[0][to_year]">
                                <option value="">Current</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div> --}}
            @endforelse
        </div>

        <div class="mt-3">
            <button type="button" class="btn btn-info add-experience">Add More</button>
        </div>

        <div class="mt-4">
            <a href="{{ route('student.application.step.post', 5) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let wrapper = document.getElementById('work-experience-wrapper');
    let index = wrapper.querySelectorAll('.work-experience-entry').length;

    document.querySelector('.add-experience').addEventListener('click', function () {
        const template = wrapper.querySelector('.work-experience-entry');
        const clone = template.cloneNode(true);

        clone.querySelectorAll('input, select').forEach(function (input) {
            let name = input.name;
            name = name.replace(/\[\d+\]/, `[${index}]`);
            input.name = name;
            input.value = '';
        });

        wrapper.appendChild(clone);
        index++;
    });
});
</script>
@endsection
