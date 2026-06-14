@extends('layouts.app')

@section('content')

<section class="container py-5">
    <h2 class="section-title mb-4">Edit News</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title EN</label>
                <input type="text" name="title_en" class="form-control" value="{{ $news->title_en }}" required>
            </div>

            <div class="mb-3">
                <label>Content EN</label>
                <textarea name="content_en" class="form-control" rows="5" required>{{ $news->content_en }}</textarea>
            </div>

            <div class="mb-3">
                <label>Title SI</label>
                <input type="text" name="title_si" class="form-control" value="{{ $news->title_si }}">
            </div>

            <div class="mb-3">
                <label>Content SI</label>
                <textarea name="content_si" class="form-control" rows="4">{{ $news->content_si }}</textarea>
            </div>

            <div class="mb-3">
                <label>Title TA</label>
                <input type="text" name="title_ta" class="form-control" value="{{ $news->title_ta }}">
            </div>

            <div class="mb-3">
                <label>Content TA</label>
                <textarea name="content_ta" class="form-control" rows="4">{{ $news->content_ta }}</textarea>
            </div>

            <div class="mb-3">
                <div class="irdc-admin-image-uploader" data-image-uploader>
                    <div class="irdc-admin-image-uploader__head">
                        <div>
                            <label class="form-label mb-1">Add more images</label>
                            <div class="form-text">Use + to add more image slots. The first remaining image is used as the cover.</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-success" data-add-image>+ Add image</button>
                    </div>
                    <div class="irdc-admin-image-uploader__list" data-image-list>
                        <div class="irdc-admin-image-uploader__row" data-image-row>
                            <span class="irdc-admin-image-uploader__number" data-image-number>1</span>
                            <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" data-image-input>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-remove-image disabled>Remove</button>
                            <div class="irdc-admin-image-uploader__preview" data-image-preview></div>
                        </div>
                    </div>
                </div>

                @if(count($news->imagePaths()) > 0)
                    <div class="mt-3 row g-3">
                        @foreach($news->imagePaths() as $path)
                            <div class="col-6 col-md-3">
                                <div class="border rounded p-2 h-100">
                                    <img src="{{ $news->imageUrl($path) }}" class="rounded w-100" style="height: 92px; object-fit: cover;" alt="">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_images[]" value="{{ $path }}" id="remove_image_{{ $loop->index }}">
                                        <label class="form-check-label small" for="remove_image_{{ $loop->index }}">Remove</label>
                                    </div>
                                    @if($loop->first)
                                        <span class="badge bg-success mt-1">Cover</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mb-3">
                <label>Published Date</label>
                <input type="date" name="published_date" class="form-control" value="{{ old('published_date', $news->published_date?->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft" {{ $news->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $news->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="form-check form-switch mb-4">
                <input type="hidden" name="is_pinned" value="0">
                <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="is_pinned" @checked(old('is_pinned', $news->is_pinned))>
                <label class="form-check-label" for="is_pinned">Pin this news to the top</label>
                <div class="form-text">Pinned published news appears first on the home page and News & Events page.</div>
            </div>

            <button type="submit" class="btn btn-green">Update News</button>
        </form>
    </div>
</section>

<script>
document.querySelectorAll('[data-image-uploader]').forEach((uploader) => {
    const list = uploader.querySelector('[data-image-list]');
    const addButton = uploader.querySelector('[data-add-image]');

    const refreshRows = () => {
        const rows = list.querySelectorAll('[data-image-row]');
        rows.forEach((row, index) => {
            row.querySelector('[data-image-number]').textContent = index + 1;
            row.querySelector('[data-remove-image]').disabled = rows.length === 1;
        });
    };

    const bindRow = (row) => {
        const input = row.querySelector('[data-image-input]');
        const preview = row.querySelector('[data-image-preview]');
        const removeButton = row.querySelector('[data-remove-image]');

        input.addEventListener('change', () => {
            preview.innerHTML = '';
            const file = input.files && input.files[0];
            if (! file) {
                return;
            }

            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = '';
            image.onload = () => URL.revokeObjectURL(image.src);
            preview.appendChild(image);
        });

        removeButton.addEventListener('click', () => {
            row.remove();
            refreshRows();
        });
    };

    bindRow(list.querySelector('[data-image-row]'));

    addButton.addEventListener('click', () => {
        const row = list.querySelector('[data-image-row]').cloneNode(true);
        row.querySelector('[data-image-input]').value = '';
        row.querySelector('[data-image-preview]').innerHTML = '';
        list.appendChild(row);
        bindRow(row);
        refreshRows();
    });

    refreshRows();
});
</script>

@endsection
