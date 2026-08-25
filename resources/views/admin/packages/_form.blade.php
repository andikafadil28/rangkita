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

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $package->exists ? 'Simpan Perubahan' : 'Buat Paket' }}</button>
        <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
