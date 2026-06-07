@extends('layouts.app')

@section('content')

<section class="container py-5">
    <h2 class="section-title mb-4">Add News</h2>

    <div class="card feature-card p-4">
        <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Title EN</label>
                <input type="text" name="title_en" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Content EN</label>
                <textarea name="content_en" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label>Title SI</label>
                <input type="text" name="title_si" class="form-control">
            </div>

            <div class="mb-3">
                <label>Content SI</label>
                <textarea name="content_si" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label>Title TA</label>
                <input type="text" name="title_ta" class="form-control">
            </div>

            <div class="mb-3">
                <label>Content TA</label>
                <textarea name="content_ta" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <div class="irdc-admin-image-uploader" data-image-uploader>
                    <div class="irdc-admin-image-uploader__head">
                        <div>
                            <label class="form-label mb-1">Images</label>
                            <div class="form-text">Use + to add 2, 3, 4, 5, 6, or more images. The first image becomes the cover.</div>
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
            </div>

            <div class="mb-3">
                <label>Published Date</label>
                <input type="date" name="published_date" class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
            </div>

            <div class="form-check form-switch mb-4">
                <input type="hidden" name="is_pinned" value="0">
                <input class="form-check-input" type="checkbox" name="is_pinned" value="1" id="is_pinned" @checked(old('is_pinned'))>
                <label class="form-check-label" for="is_pinned">Pin this news to the top</label>
                <div class="form-text">Pinned published news appears first on the home page and News & Events page.</div>
            </div>

            <button type="submit" class="btn btn-green">Save News</button>
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
