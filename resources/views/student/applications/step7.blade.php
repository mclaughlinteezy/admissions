@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Step 7: Referee Details</h2>

    <form method="POST" action="{{ route('student.application.step.post', 7) }}">
        @csrf

        @php
            $referees = old('referees', is_string($application->referees ?? null) ? json_decode($application->referees, true) : ($application->referees ?? [[]]));
        @endphp

        <div id="referee-wrapper">
            @foreach($referees as $index => $referee)
            <div class="referee-entry" style="padding: 15px; border: 1px solid #ccc; margin-bottom: 15px; border-radius: 5px;">
                <div class="form-group">
                    <label for="referees[{{ $index }}][referee_name]">Referee Name:</label>
                    <input type="text" name="referees[{{ $index }}][referee_name]" class="form-control" required
                        value="{{ $referee['referee_name'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="referees[{{ $index }}][referee_email]">Referee Email:</label>
                    <input type="email" name="referees[{{ $index }}][referee_email]" class="form-control"
                        value="{{ $referee['referee_email'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="referees[{{ $index }}][referee_phone]">Referee Phone:</label>
                    <input type="tel" name="referees[{{ $index }}][referee_phone]" class="form-control"
                        value="{{ $referee['referee_phone'] ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="referees[{{ $index }}][referee_position]">Referee Position:</label>
                    <input type="text" name="referees[{{ $index }}][referee_position]" class="form-control"
                        value="{{ $referee['referee_position'] ?? '' }}">
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-info mb-3" id="add-referee-btn">Add More Referee</button>

        <div>
            <a href="{{ route('student.application.step.post', 6) }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let wrapper = document.getElementById('referee-wrapper');
    let index = wrapper.querySelectorAll('.referee-entry').length;

    document.getElementById('add-referee-btn').addEventListener('click', function () {
        const div = document.createElement('div');
        div.classList.add('referee-entry');
        div.style.padding = '15px';
        div.style.border = '1px solid #ccc';
        div.style.marginBottom = '15px';
        div.style.borderRadius = '5px';

        div.innerHTML = `
            <div class="form-group">
                <label>Referee Name:</label>
                <input type="text" name="referees[${index}][referee_name]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Referee Email:</label>
                <input type="email" name="referees[${index}][referee_email]" class="form-control">
            </div>
            <div class="form-group">
                <label>Referee Phone:</label>
                <input type="tel" name="referees[${index}][referee_phone]" class="form-control">
            </div>
            <div class="form-group">
                <label>Referee Position:</label>
                <input type="text" name="referees[${index}][referee_position]" class="form-control">
            </div>
        `;

        wrapper.appendChild(div);
        index++;
    });
});
</script>
@endsection
