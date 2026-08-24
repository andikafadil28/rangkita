@extends('layouts.app')

@section('title', $package->name . ' - Rangkita')

@section('content')
    <section class="quiz-wrap">
        <header class="quiz-topbar">
            <div class="quiz-topbar-info">
                <strong>{{ $package->name }}</strong>
                <span class="badge badge-soft">{{ $mode === 'test' ? 'Mode Test' : 'Mode Latihan' }}</span>
            </div>

            @if ($mode === 'test')
                <div class="quiz-timer" id="quizTimer">--:--</div>
            @endif
        </header>

        <form method="POST" action="{{ route('soal.submit', $package) }}" id="quizForm">
            @csrf
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="time_spent" id="timeSpent" value="">

            @foreach ($questions as $index => $question)
                @php
                    $options = [
                        'a' => $question->option_a,
                        'b' => $question->option_b,
                        'c' => $question->option_c,
                        'd' => $question->option_d,
                        'e' => $question->option_e,
                    ];
                @endphp

                <article class="card quiz-question">
                    <div class="question-number">{{ $index + 1 }}</div>

                    <p class="question-text">{{ $question->question_text }}</p>

                    <div class="quiz-options">
                        @foreach ($options as $letter => $text)
                            @if ($text !== null)
                                <label class="option-item">
                                    <input type="radio"
                                        name="answers[{{ $question->id }}]"
                                        value="{{ $letter }}">
                                    <span class="option-letter">{{ strtoupper($letter) }}.</span>
                                    <span class="option-text">{{ $text }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </article>
            @endforeach

            <div class="quiz-submit-row">
                <button type="submit" class="btn-primary btn-lg">Kumpulkan Jawaban</button>
            </div>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var timeLimit = {{ $timeLimit ?? 'null' }};
            var elapsed = 0;
            var timerEl = document.getElementById('quizTimer');
            var timeSpentEl = document.getElementById('timeSpent');
            var form = document.getElementById('quizForm');

            function formatTime(totalSeconds) {
                var minutes = Math.floor(totalSeconds / 60);
                var seconds = totalSeconds % 60;
                return String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }

            setInterval(function () {
                elapsed++;
            }, 1000);

            if (timeLimit && timerEl) {
                var remaining = timeLimit;
                timerEl.textContent = formatTime(remaining);

                setInterval(function () {
                    remaining--;
                    elapsed = timeLimit - remaining;
                    timerEl.textContent = formatTime(Math.max(remaining, 0));

                    if (remaining <= timeLimit * 0.1) {
                        timerEl.classList.add('timer-danger');
                    }

                    if (remaining <= 0) {
                        form.submit();
                    }
                }, 1000);
            }

            form.addEventListener('submit', function () {
                if (!timeSpentEl.value) {
                    timeSpentEl.value = elapsed;
                }
            });
        });
    </script>
@endsection
