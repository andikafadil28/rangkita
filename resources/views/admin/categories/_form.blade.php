<form
    action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
    method="POST"
    class="card admin-form"
>
    @csrf
    @if ($category->exists)
        @method('PUT')
    @endif

    <div class="field">
        <label for="name">Nama Kategori</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
        <div class="hint">Slug dibuat otomatis dari nama.</div>
        @error('name')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="field-row">
        <div class="field">
            <label for="icon">Icon (emoji)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" placeholder="Contoh: 🧠">
            @error('icon')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field">
            <label for="sort_order">Urutan</label>
            <input type="number" name="sort_order" id="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
            @error('sort_order')<div class="error-text">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="field">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
        @error('description')<div class="error-text">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $category->exists ? 'Simpan Perubahan' : 'Buat Kategori' }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>
