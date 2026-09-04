@php
    $events = old('events', $wedding->events ?? []);
@endphp

<form
    action="{{ $wedding->exists ? route('admin.weddings.update', $wedding) : route('admin.weddings.store') }}"
    method="POST"
    enctype="multipart/form-data"
    class="card admin-form admin-wedding-form"
>
    @csrf
    @if ($wedding->exists)
        @method('PUT')
    @endif

    <fieldset class="scoring-fieldset">
        <legend>Template dan Publikasi</legend>
        <div class="field-row">
            <div class="field">
                <label for="template_id">Template</label>
                <select name="template_id" id="template_id" required>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}" @selected(old('template_id', $wedding->template_id) == $template->id)>
                            {{ $template->name }} - {{ $template->style }}
                        </option>
                    @endforeach
                </select>
                @error('template_id')<div class="error-text">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="status">Status</label>
                <select name="status" id="status" required>
                    <option value="draft" @selected(old('status', $wedding->status ?? 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $wedding->status ?? 'draft') === 'published')>Published</option>
                </select>
                <div class="hint">Draft hanya bisa dilihat admin.</div>
                @error('status')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="scoring-fieldset">
        <legend>Data Mempelai</legend>
        <div class="field-row">
            <div class="field">
                <label for="groom_short_name">Nama Pendek Pria</label>
                <input type="text" name="groom_short_name" id="groom_short_name" maxlength="50" value="{{ old('groom_short_name', $wedding->groom_short_name) }}" required>
                @error('groom_short_name')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="bride_short_name">Nama Pendek Wanita</label>
                <input type="text" name="bride_short_name" id="bride_short_name" maxlength="50" value="{{ old('bride_short_name', $wedding->bride_short_name) }}" required>
                @error('bride_short_name')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label for="groom_full_name">Nama Lengkap Pria</label>
                <input type="text" name="groom_full_name" id="groom_full_name" maxlength="150" value="{{ old('groom_full_name', $wedding->groom_full_name) }}" required>
                @error('groom_full_name')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="bride_full_name">Nama Lengkap Wanita</label>
                <input type="text" name="bride_full_name" id="bride_full_name" maxlength="150" value="{{ old('bride_full_name', $wedding->bride_full_name) }}" required>
                @error('bride_full_name')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label for="groom_parent">Keterangan Orang Tua Pria</label>
                <input type="text" name="groom_parent" id="groom_parent" maxlength="255" value="{{ old('groom_parent', $wedding->groom_parent) }}">
                @error('groom_parent')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="bride_parent">Keterangan Orang Tua Wanita</label>
                <input type="text" name="bride_parent" id="bride_parent" maxlength="255" value="{{ old('bride_parent', $wedding->bride_parent) }}">
                @error('bride_parent')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="scoring-fieldset">
        <legend>Tanggal Utama dan Akad</legend>
        <div class="field">
            <label for="wedding_date">Tanggal dan Jam Utama</label>
            <input type="datetime-local" name="wedding_date" id="wedding_date" value="{{ old('wedding_date', $wedding->wedding_date?->format('Y-m-d\TH:i')) }}" required>
            <div class="hint">Dipakai untuk countdown undangan.</div>
            @error('wedding_date')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="field-row">
            <div class="field">
                <label for="akad_title">Judul Akad</label>
                <input type="text" name="events[akad][title]" id="akad_title" maxlength="100" value="{{ data_get($events, 'akad.title', 'Akad Nikah') }}" required>
                @error('events.akad.title')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="akad_date">Tanggal Akad</label>
                <input type="date" name="events[akad][date]" id="akad_date" value="{{ data_get($events, 'akad.date') }}" required>
                @error('events.akad.date')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="akad_time">Jam Akad</label>
                <input type="time" name="events[akad][time]" id="akad_time" value="{{ data_get($events, 'akad.time') }}" required>
                @error('events.akad.time')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label for="akad_place">Tempat Akad</label>
                <input type="text" name="events[akad][place]" id="akad_place" maxlength="150" value="{{ data_get($events, 'akad.place') }}" required>
                @error('events.akad.place')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="akad_address">Alamat Akad</label>
                <textarea name="events[akad][address]" id="akad_address" maxlength="500" required>{{ data_get($events, 'akad.address') }}</textarea>
                @error('events.akad.address')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="scoring-fieldset">
        <legend>Resepsi <span class="admin-optional-label">Opsional</span></legend>
        <p class="hint">Kosongkan semua field jika tidak ada resepsi. Kalau mulai diisi, seluruh detail wajib lengkap.</p>
        <div class="field-row">
            <div class="field">
                <label for="resepsi_title">Judul Resepsi</label>
                <input type="text" name="events[resepsi][title]" id="resepsi_title" maxlength="100" value="{{ data_get($events, 'resepsi.title') }}">
                @error('events.resepsi.title')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="resepsi_date">Tanggal Resepsi</label>
                <input type="date" name="events[resepsi][date]" id="resepsi_date" value="{{ data_get($events, 'resepsi.date') }}">
                @error('events.resepsi.date')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="resepsi_time">Jam Resepsi</label>
                <input type="time" name="events[resepsi][time]" id="resepsi_time" value="{{ data_get($events, 'resepsi.time') }}">
                @error('events.resepsi.time')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="field-row">
            <div class="field">
                <label for="resepsi_place">Tempat Resepsi</label>
                <input type="text" name="events[resepsi][place]" id="resepsi_place" maxlength="150" value="{{ data_get($events, 'resepsi.place') }}">
                @error('events.resepsi.place')<div class="error-text">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="resepsi_address">Alamat Resepsi</label>
                <textarea name="events[resepsi][address]" id="resepsi_address" maxlength="500">{{ data_get($events, 'resepsi.address') }}</textarea>
                @error('events.resepsi.address')<div class="error-text">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="scoring-fieldset">
        <legend>Lokasi dan Galeri</legend>
        <div class="field">
            <label for="maps_url">Google Maps URL</label>
            <input type="url" name="maps_url" id="maps_url" maxlength="2048" value="{{ old('maps_url', $wedding->maps_url) }}" placeholder="https://maps.google.com/...">
            @error('maps_url')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        @if ($wedding->exists && $wedding->gallery->isNotEmpty())
            <div class="admin-gallery-grid">
                @foreach ($wedding->gallery as $photo)
                    <article class="admin-gallery-card">
                        <img src="{{ Storage::disk('public')->url($photo->photo_path) }}" alt="{{ $photo->caption ?: 'Foto galeri' }}">
                        <div class="field">
                            <label for="gallery_caption_{{ $photo->id }}">Caption</label>
                            <input type="text" name="existing_gallery[{{ $photo->id }}][caption]" id="gallery_caption_{{ $photo->id }}" maxlength="255" value="{{ old('existing_gallery.'.$photo->id.'.caption', $photo->caption) }}">
                        </div>
                        <div class="field">
                            <label for="gallery_order_{{ $photo->id }}">Urutan</label>
                            <input type="number" name="existing_gallery[{{ $photo->id }}][sort_order]" id="gallery_order_{{ $photo->id }}" min="0" value="{{ old('existing_gallery.'.$photo->id.'.sort_order', $photo->sort_order) }}" required>
                        </div>
                        <button type="submit" class="btn-danger btn-sm" form="delete-gallery-{{ $photo->id }}">Hapus Foto</button>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="field">
            <label for="gallery">Tambah Foto Galeri</label>
            <input type="file" name="gallery[]" id="gallery" accept="image/jpeg,image/png,image/webp" multiple>
            <div class="hint">Maksimal 10 foto per upload, masing-masing 5 MB. Format JPG, PNG, atau WebP.</div>
            @error('gallery')<div class="error-text">{{ $message }}</div>@enderror
            @error('gallery.*')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div id="galleryCaptionFields" class="admin-upload-list" aria-live="polite"></div>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $wedding->exists ? 'Simpan Perubahan' : 'Buat Undangan' }}</button>
        <a href="{{ route('admin.weddings.index') }}" class="btn-secondary">Batal</a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var galleryInput = document.getElementById('gallery');
        var captionFields = document.getElementById('galleryCaptionFields');

        galleryInput.addEventListener('change', function () {
            captionFields.replaceChildren();

            Array.from(galleryInput.files).forEach(function (file, index) {
                var field = document.createElement('div');
                var label = document.createElement('label');
                var input = document.createElement('input');

                field.className = 'field';
                label.htmlFor = 'gallery_caption_' + index;
                label.textContent = 'Caption: ' + file.name;
                input.type = 'text';
                input.name = 'gallery_captions[]';
                input.id = 'gallery_caption_' + index;
                input.maxLength = 255;

                field.append(label, input);
                captionFields.append(field);
            });
        });
    });
</script>
