<form
    action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
    method="POST"
    class="card admin-form"
>
    @csrf
    @if ($package->exists)
        @method('PUT')
    @endif

    <div class="field">
        <label for="soal_category_id">Kategori</label>
        <select name="soal_category_id" id="soal_category_id">
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('soal_category_id', $package->soal_category_id) == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('soal_category_id')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="name">Nama Paket</label>
        <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}">
        <div class="hint">Slug dibuat otomatis dari nama. Contoh: "TIU Numerik" jadi /soal/paket/tiu-numerik.</div>
        @error('name')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field-row">
        <div class="field">
            <label for="difficulty">Tingkat Kesulitan</label>
            <select name="difficulty" id="difficulty">
                @foreach (['mudah', 'sedang', 'sulit'] as $level)
                    <option value="{{ $level }}" @selected(old('difficulty', $package->difficulty ?? 'sedang') === $level)>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>
            @error('difficulty')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="price">Harga (Rupiah)</label>
            <input type="number" name="price" id="price" min="0" step="500" value="{{ old('price', $package->price ?? 0) }}">
            <div class="hint">Isi 0 = paket gratis, langsung bisa dikerjakan tanpa bayar.</div>
            @error('price')<div class="error-text">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="field field-checkbox">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $package->is_active ?? true))>
        <label for="is_active">Aktif (tampil di halaman publik)</label>
        @error('is_active')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <fieldset class="scoring-fieldset">
        <legend>Sistem Poin</legend>
        <div class="field-row">
            <div class="field">
                <label for="point_correct">Poin Jawaban Benar</label>
                <input type="number" name="point_correct" id="point_correct" min="0" value="{{ old('point_correct', $package->point_correct) }}" placeholder="Kosongkan = persentase">
                @error('point_correct')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="point_blank">Poin Tidak Dijawab</label>
                <input type="number" name="point_blank" id="point_blank" value="{{ old('point_blank', $package->point_blank ?? 0) }}">
                @error('point_blank')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="point_wrong">Poin Jawaban Salah</label>
                <input type="number" name="point_wrong" id="point_wrong" value="{{ old('point_wrong', $package->point_wrong ?? 0) }}">
                @error('point_wrong')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="hint">Kosongkan "Poin Jawaban Benar" untuk menggunakan sistem persentase (0-100). Isi untuk sistem poin — contoh: Benar=5, Kosong=0, Salah=-2 (minus buat penalti).</div>
    </fieldset>

    <fieldset class="scoring-fieldset">
        <legend>Pengaturan Quiz</legend>
        <div class="field-row">
            <div class="field">
                <label for="display_mode">Mode Tampilan</label>
                <select name="display_mode" id="display_mode">
                    <option value="scroll" @selected(old('display_mode', $package->display_mode ?? 'scroll') === 'scroll')">Scroll (Semua Soal)</option>
                    <option value="step" @selected(old('display_mode', $package->display_mode ?? 'scroll') === 'step')">Step (Satu Per Satu)</option>
                </select>
                @error('display_mode')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="time_limit">Waktu Pengerjaan Test (detik)</label>
                <input type="number" name="time_limit" id="time_limit" min="60" max="86400" value="{{ old('time_limit', $package->time_limit) }}" placeholder="Kosongkan = 54 detik/soal">
                @error('time_limit')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="field field-checkbox" id="allowBackWrapper">
            <input type="hidden" name="allow_back" value="0">
            <input type="checkbox" name="allow_back" id="allow_back" value="1" @checked(old('allow_back', $package->allow_back ?? true))>
            <label for="allow_back">Boleh kembali ke soal sebelumnya (mode Step)</label>
            @error('allow_back')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="hint">Mode Scroll: semua soal tampil sekaligus, scroll ke bawah. Mode Step: satu soal per layar dengan navigasi Next/Previous. Waktu kosong = otomatis 54 detik per soal.</div>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $package->exists ? 'Simpan Perubahan' : 'Buat Paket' }}</button>
        <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modeSelect = document.getElementById('display_mode');
        var wrapper = document.getElementById('allowBackWrapper');

        function toggleAllowBack() {
            wrapper.style.display = modeSelect.value === 'step' ? '' : 'none';
        }

        modeSelect.addEventListener('change', toggleAllowBack);
        toggleAllowBack();
    });
</script>
