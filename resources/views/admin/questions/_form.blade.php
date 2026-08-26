<form
    action="{{ $question->exists ? route('admin.questions.update', [$package, $question]) : route('admin.questions.store', $package) }}"
    method="POST"
    class="card admin-form"
>
    @csrf
    @if ($question->exists)
        @method('PUT')
    @endif

    <div class="field">
        <label for="question_text">Teks Soal</label>
        <textarea name="question_text" id="question_text">{{ old('question_text', $question->question_text) }}</textarea>
        @error('question_text')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label>Opsi Jawaban</label>
        <div class="field-row">
            <div class="field">
                <input type="text" name="option_a" placeholder="Opsi A" value="{{ old('option_a', $question->option_a) }}">
                @error('option_a')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <input type="text" name="option_b" placeholder="Opsi B" value="{{ old('option_b', $question->option_b) }}">
                @error('option_b')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <input type="text" name="option_c" placeholder="Opsi C" value="{{ old('option_c', $question->option_c) }}">
                @error('option_c')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <input type="text" name="option_d" placeholder="Opsi D" value="{{ old('option_d', $question->option_d) }}">
                @error('option_d')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <input type="text" name="option_e" placeholder="Opsi E (opsional)" value="{{ old('option_e', $question->option_e) }}">
                @error('option_e')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="hint">Kosongkan Opsi E untuk soal 4 pilihan (misal soal TKP/Polri nanti).</div>
    </div>

    <div class="field">
        <label>Kunci Jawaban</label>
        <div class="answer-options">
            @foreach (['a', 'b', 'c', 'd', 'e'] as $key)
                <label class="answer-option">
                    <input
                        type="radio"
                        name="correct_answer"
                        value="{{ $key }}"
                        @checked(old('correct_answer', $question->correct_answer) === $key)
                    >
                    {{ strtoupper($key) }}
                </label>
            @endforeach
        </div>
        <div class="hint">Pilihan E cuma valid kalau opsi E terisi.</div>
        @error('correct_answer')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="explanation">Pembahasan (opsional)</label>
        <textarea name="explanation" id="explanation">{{ old('explanation', $question->explanation) }}</textarea>
        @error('explanation')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="difficulty">Tingkat Kesulitan</label>
        <select name="difficulty" id="difficulty">
            @foreach (['mudah', 'sedang', 'sulit'] as $level)
                <option value="{{ $level }}" @selected(old('difficulty', $question->difficulty ?? 'sedang') === $level)>
                    {{ ucfirst($level) }}
                </option>
            @endforeach
        </select>
        @error('difficulty')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    @if ($package->point_correct !== null)
        <fieldset class="scoring-fieldset">
            <legend>Override Poin (Opsional)</legend>
            <div class="field-row">
                <div class="field">
                    <label for="point_correct">Poin Benar</label>
                    <input type="number" name="point_correct" id="point_correct" min="0" value="{{ old('point_correct', $question->point_correct) }}" placeholder="Ikut paket: {{ $package->point_correct }}">
                    @error('point_correct')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="point_blank">Poin Kosong</label>
                    <input type="number" name="point_blank" id="point_blank" value="{{ old('point_blank', $question->point_blank) }}" placeholder="Ikut paket: {{ $package->point_blank ?? 0 }}">
                    @error('point_blank')<div class="error-text">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label for="point_wrong">Poin Salah</label>
                    <input type="number" name="point_wrong" id="point_wrong" value="{{ old('point_wrong', $question->point_wrong) }}" placeholder="Ikut paket: {{ $package->point_wrong ?? 0 }}">
                    @error('point_wrong')<div class="error-text">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="hint">Kosongkan semua untuk mengikuti aturan poin dari paket. Isi untuk override per soal — misal soal ini lebih berat, benar = 10 poin.</div>
        </fieldset>
    @endif

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $question->exists ? 'Simpan Perubahan' : 'Tambah Soal' }}</button>
        <a href="{{ route('admin.questions.index', $package) }}" class="btn-secondary">Batal</a>
    </div>
</form>
