@extends('layouts.app')

@section('title', $package->name . ' - Rangkita')

@section('content')
    <section class="quiz-wrap" data-mode="{{ $displayMode }}" data-allow-back="{{ $allowBack ? '1' : '0' }}">
        <header class="quiz-topbar">
            <div class="quiz-topbar-info">
                <strong>{{ $package->name }}</strong>
                <span class="badge badge-soft">{{ $mode === 'test' ? 'Mode Test' : 'Mode Latihan' }}</span>
                @if ($displayMode === 'step')
                    <span class="badge badge-soft quiz-progress" id="quizProgress">Soal 1 dari {{ $totalQuestions }}</span>
                @endif
            </div>

            @if ($mode === 'test')
                <div class="quiz-timer" id="quizTimer">--:--</div>
            @endif
        </header>

        <form method="POST" action="{{ route('soal.submit', $package) }}" id="quizForm">
            @csrf
            <input type="hidden" name="mode" value="{{ $mode }}">
            <input type="hidden" name="time_spent" id="timeSpent" value="">

            {{-- STEP MODE: Recap View (hidden by default) --}}
            <div class="quiz-recap hidden" id="quizRecap">
                <h2 class="section-subtitle">Rekap Jawaban</h2>
                <p class="quiz-recap-summary" id="recapSummary"></p>
                <div class="quiz-recap-grid" id="recapGrid"></div>
                <div class="quiz-submit-row">
                    @if ($allowBack)
                        <button type="button" class="btn-secondary" id="recapBackBtn">Kembali ke Soal</button>
                    @endif
                    <button type="submit" class="btn-primary btn-lg">Submit Jawaban</button>
                </div>
            </div>

            {{-- QUESTIONS --}}
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

                <article class="card quiz-question quiz-step" data-index="{{ $index }}" data-id="{{ $question->id }}">
                    <div class="question-number">
                        {{ $index + 1 }}
                        @if ($usePointSystem)
                            @php
                                $pc = $question->point_correct ?? $package->point_correct ?? 0;
                            @endphp
                            <span class="points-badge">+{{ $pc }} poin</span>
                        @endif
                    </div>

                    <p class="question-text">{{ $question->question_text }}</p>

                    <div class="quiz-options">
                        @foreach ($options as $letter => $text)
                            @if ($text !== null)
                                <label class="option-item">
                                    <input type="radio"
                                        name="answers[{{ $question->id }}]"
                                        value="{{ $letter }}"
                                        data-step-input>
                                    <span class="option-letter">{{ strtoupper($letter) }}.</span>
                                    <span class="option-text">{{ $text }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                </article>
            @endforeach

            {{-- SCROLL MODE: Submit button at bottom --}}
            @if ($displayMode === 'scroll')
                <div class="quiz-submit-row">
                    <button type="submit" class="btn-primary btn-lg">Kumpulkan Jawaban</button>
                </div>
            @endif

            {{-- STEP MODE: Navigation buttons --}}
            @if ($displayMode === 'step')
                <div class="quiz-nav" id="quizNav">
                    <button type="button" class="btn-secondary" id="prevBtn" disabled>Soal Sebelumnya</button>
                    <button type="button" class="btn-primary" id="nextBtn">Soal Berikutnya</button>
                    <button type="button" class="btn-primary btn-lg hidden" id="finishBtn">Selesai</button>
                </div>
            @endif
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var timeLimit = {{ $timeLimit ?? 'null' }};
            var elapsed = 0;
            var timerEl = document.getElementById('quizTimer');
            var timeSpentEl = document.getElementById('timeSpent');
            var form = document.getElementById('quizForm');
            var quizWrap = document.querySelector('.quiz-wrap');
            var displayMode = quizWrap.dataset.mode;
            var allowBack = quizWrap.dataset.allowBack === '1';

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

            if (displayMode !== 'step') return;

            var steps = Array.from(document.querySelectorAll('.quiz-step'));
            var totalSteps = steps.length;
            var currentIndex = 0;
            var progressEl = document.getElementById('quizProgress');
            var prevBtn = document.getElementById('prevBtn');
            var nextBtn = document.getElementById('nextBtn');
            var finishBtn = document.getElementById('finishBtn');
            var recapView = document.getElementById('quizRecap');
            var recapGrid = document.getElementById('recapGrid');
            var recapSummary = document.getElementById('recapSummary');
            var recapBackBtn = document.getElementById('recapBackBtn');
            var answers = {};

            function showStep(index) {
                steps.forEach(function (step, i) {
                    if (i === index) {
                        step.classList.add('active');
                        step.classList.remove('slide-left', 'slide-right');
                    } else {
                        step.classList.remove('active');
                    }
                });

                currentIndex = index;
                progressEl.textContent = 'Soal ' + (index + 1) + ' dari ' + totalSteps;

                prevBtn.disabled = !allowBack || index === 0;
                prevBtn.classList.toggle('hidden', !allowBack || index === 0);

                var isLast = index === totalSteps - 1;
                nextBtn.classList.toggle('hidden', isLast);
                finishBtn.classList.toggle('hidden', !isLast);
            }

            function animateStep(newIndex, direction) {
                var oldStep = steps[currentIndex];
                var newStep = steps[newIndex];

                oldStep.classList.add(direction === 'next' ? 'slide-left' : 'slide-right');
                oldStep.classList.remove('active');

                setTimeout(function () {
                    oldStep.classList.remove('slide-left', 'slide-right');
                    newStep.classList.add('active');
                    newStep.classList.remove('slide-left', 'slide-right');
                }, 150);

                currentIndex = newIndex;
                progressEl.textContent = 'Soal ' + (newIndex + 1) + ' dari ' + totalSteps;

                prevBtn.disabled = !allowBack || newIndex === 0;
                prevBtn.classList.toggle('hidden', !allowBack || newIndex === 0);

                var isLast = newIndex === totalSteps - 1;
                nextBtn.classList.toggle('hidden', isLast);
                finishBtn.classList.toggle('hidden', !isLast);
            }

            function collectAnswers() {
                steps.forEach(function (step) {
                    var id = step.dataset.id;
                    var checked = step.querySelector('input[type="radio"]:checked');
                    answers[id] = checked ? checked.value : null;
                });
            }

            function buildRecap() {
                collectAnswers();
                recapGrid.innerHTML = '';
                var answered = 0;

                steps.forEach(function (step, i) {
                    var id = step.dataset.id;
                    var hasAnswer = answers[id] !== null && answers[id] !== undefined;
                    if (hasAnswer) answered++;

                    var item = document.createElement('div');
                    item.className = 'recap-item-number ' + (hasAnswer ? 'recap-answered' : 'recap-unanswered');

                    if (allowBack) {
                        item.innerHTML = '<button type="button" class="recap-num-btn" data-goto="' + i + '">' + (i + 1) + '</button>';
                    } else {
                        item.innerHTML = '<span class="recap-num-static">' + (i + 1) + '</span>';
                    }

                    recapGrid.appendChild(item);
                });

                recapSummary.textContent = answered + ' dari ' + totalSteps + ' soal sudah dijawab.';
            }

            showStep(0);

            nextBtn.addEventListener('click', function () {
                if (currentIndex < totalSteps - 1) {
                    animateStep(currentIndex + 1, 'next');
                }
            });

            prevBtn.addEventListener('click', function () {
                if (allowBack && currentIndex > 0) {
                    animateStep(currentIndex - 1, 'prev');
                }
            });

            finishBtn.addEventListener('click', function () {
                buildRecap();
                recapView.classList.remove('hidden');
                steps.forEach(function (s) { s.classList.add('hidden'); });
                document.getElementById('quizNav').classList.add('hidden');
                progressEl.textContent = 'Rekap Jawaban';
            });

            recapBackBtn.addEventListener('click', function () {
                recapView.classList.add('hidden');
                steps.forEach(function (s) { s.classList.remove('hidden'); });
                document.getElementById('quizNav').classList.remove('hidden');
                showStep(currentIndex);
            });

            recapGrid.addEventListener('click', function (e) {
                var btn = e.target.closest('.recap-num-btn');
                if (!btn) return;
                var goto = parseInt(btn.dataset.goto, 10);
                recapView.classList.add('hidden');
                steps.forEach(function (s) { s.classList.remove('hidden'); });
                document.getElementById('quizNav').classList.remove('hidden');
                showStep(goto);
            });
        });
    </script>
@endsection
