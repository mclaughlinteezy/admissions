@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 6: Work Experience</h2>

    <form method="POST" action="{{ route('student.application.step.post', 6) }}">
        @csrf

        @php
            $experiences = old('work_experience', [
                ['companyname' => '', 'jobtitle' => '', 'from_month' => '', 'from_year' => '', 'to_month' => '', 'to_year' => '']
            ]);
        @endphp

        <div id="work-experience-wrapper">
            @foreach($experiences as $index => $exp)
                <div class="work-experience-entry border p-3 mb-3 rounded">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[{{ $index }}][companyname]" placeholder="Company Name" value="{{ $exp['companyname'] ?? '' }}" required>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="work_experience[{{ $index }}][jobtitle]" placeholder="Job Title" value="{{ $exp['jobtitle'] ?? '' }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-1 d-flex align-items-center">From</div>
                        <div class="col-sm-3">
                            <select class="form-control" name="work_experience[{{ $index }}][from_month]" required>
                                <option value="">Month</option>
                                @foreach(['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $val => $label)
                                    <option value="{{ $val }}" {{ ($exp['from_month'] ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" name="work_experience[{{ $index }}][from_year]" required>
                                <option value="">Year</option>
                                @for($year = date('Y'); $year >= 1950; $year--)
                                    <option value="{{ $year }}" {{ ($exp['from_year'] ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-sm-1 d-flex align-items-center">To</div>
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
            @endforeach
        </div>

        <div class="mb-3">
            <button type="button" class="btn btn-info add-experience">Add More</button>
        </div>

        <div>
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
            input.value = '';
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        });

        wrapper.appendChild(clone);
        index++;
    });
});
</script>
@endsection
