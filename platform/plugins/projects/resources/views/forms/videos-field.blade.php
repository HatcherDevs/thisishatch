@php
    $videosJson = json_encode($videos ?? []);
@endphp

@once
    @push('header')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @endpush
@endonce

<div class="card mb-3" id="project-videos-card">
    <div class="card-header d-flex align-items-center justify-content-between" style="cursor:pointer;"
        data-bs-toggle="collapse" data-bs-target="#project-videos-collapse" aria-expanded="false"
        aria-controls="project-videos-collapse">
        <span class="fw-semibold">
            <i class="fa-solid fa-video me-1"></i>
            {{ trans('plugins/projects::projects.form.videos') }}
            <span class="badge  ms-1" id="videos-count-badge">{{ count($videos ?? []) }}</span>
        </span>
        <i class="fa-solid fa-chevron-down" id="videos-chevron"></i>
    </div>

    <div class="collapse" id="project-videos-collapse">
        <div class="card-body p-0">

            {{-- List --}}
            <table class="table table-sm mb-0" id="videos-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ trans('plugins/projects::projects.form.video_url') }}</th>
                        <th>{{ trans('plugins/projects::projects.form.video_cover') }}</th>
                        <th style="width:100px"></th>
                    </tr>
                </thead>
                <tbody id="videos-tbody">
                    {{-- Populated by JS --}}
                </tbody>
            </table>

            <div class="p-3 border-top">
                <button type="button" class="btn btn-sm btn-primary" id="btn-add-video">
                    <i class="fa-solid fa-plus me-1"></i>
                    {{ trans('plugins/projects::projects.form.add_video') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden input carrying the JSON --}}
<input type="hidden" name="videos_json" id="videos-json-input" value="{{ htmlspecialchars($videosJson) }}">

{{-- Modal --}}
<div class="modal fade" id="video-modal" tabindex="-1" aria-labelledby="video-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="video-modal-label">
                    {{ trans('plugins/projects::projects.form.add_video') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ trans('plugins/projects::projects.form.video_url') }}
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="modal-video-url"
                        placeholder="https://youtube.com/watch?v=...">
                    <div class="invalid-feedback" id="modal-url-error">
                        {{ trans('plugins/projects::projects.form.video_url_required') }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        {{ trans('plugins/projects::projects.form.video_cover') }}
                    </label>
                    <x-core::form.image name="video_cover_temp" :value="null" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ trans('core/base::forms.cancel') }}
                </button>
                <button type="button" class="btn btn-primary" id="btn-save-video">
                    {{ trans('core/base::forms.save') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var videos = {!! $videosJson !!};
        var editingIndex = -1;

        function getMediaUrl(path) {
            if (!path) return '';
            if (path.startsWith('http')) return path;
            return '{{ rtrim(config('filesystems.disks.public.url', asset('storage')), '/') }}/' + path.replace(
                /^\//, '');
        }

        function syncHidden() {
            document.getElementById('videos-json-input').value = JSON.stringify(videos);
            document.getElementById('videos-count-badge').textContent = videos.length;
        }

        function renderRow(video, index) {
            var tr = document.createElement('tr');
            tr.dataset.index = index;

            var coverHtml = video.cover ?
                '<img src="' + getMediaUrl(video.cover) +
                '" style="width:48px;height:36px;object-fit:cover;border-radius:4px;">' :
                '<span class="text-muted small">—</span>';

            var shortUrl = video.url.length > 50 ? video.url.substring(0, 47) + '...' : video.url;

            tr.innerHTML =
                '<td class="align-middle text-muted small">' + (index + 1) + '</td>' +
                '<td class="align-middle"><span title="' + video.url + '">' + shortUrl + '</span></td>' +
                '<td class="align-middle">' + coverHtml + '</td>' +
                '<td class="align-middle">' +
                '<button type="button" class="btn btn-sm btn-icon btn-outline-primary me-1 btn-edit-video" data-index="' +
                index + '" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>' +
                '<button type="button" class="btn btn-sm btn-icon btn-outline-danger btn-delete-video" data-index="' +
                index + '" title="Delete"><i class="fa-solid fa-trash"></i></button>' +
                '</td>';

            return tr;
        }

        function renderTable() {
            var tbody = document.getElementById('videos-tbody');
            tbody.innerHTML = '';
            if (videos.length === 0) {
                var empty = document.createElement('tr');
                empty.innerHTML =
                    '<td colspan="4" class="text-center text-muted py-3 small">{{ trans('plugins/projects::projects.form.no_videos') }}</td>';
                tbody.appendChild(empty);
            } else {
                videos.forEach(function(v, i) {
                    tbody.appendChild(renderRow(v, i));
                });
            }
            syncHidden();
        }

        function openModal(index) {
            editingIndex = index;
            var modal = document.getElementById('video-modal');
            var modalTitle = document.getElementById('video-modal-label');
            var urlInput = document.getElementById('modal-video-url');

            var bbCoverInput = document.querySelector('.image-box-video_cover_temp .image-data');
            var bbPreview = document.querySelector('.image-box-video_cover_temp .preview-image');
            var bbRemoveBtn = document.querySelector('.image-box-video_cover_temp .image-picker-remove-button');
            var defaultImg = bbPreview ? bbPreview.dataset.default : '';

            if (index >= 0) {
                modalTitle.textContent = '{{ trans('plugins/projects::projects.form.edit_video') }}';
                urlInput.value = videos[index].url || '';
                var existingCover = videos[index].cover || '';
                if (bbCoverInput) {
                    bbCoverInput.value = existingCover;
                }
                if (bbPreview) {
                    bbPreview.src = existingCover ? getMediaUrl(existingCover) : defaultImg;
                    bbPreview.classList.toggle('default-image', !existingCover);
                }
                if (bbRemoveBtn) {
                    bbRemoveBtn.style.display = existingCover ? '' : 'none';
                }
            } else {
                modalTitle.textContent = '{{ trans('plugins/projects::projects.form.add_video') }}';
                urlInput.value = '';
                if (bbCoverInput) {
                    bbCoverInput.value = '';
                }
                if (bbPreview) {
                    bbPreview.src = defaultImg;
                    bbPreview.classList.add('default-image');
                }
                if (bbRemoveBtn) {
                    bbRemoveBtn.style.display = 'none';
                }
            }

            urlInput.classList.remove('is-invalid');

            bootstrap.Modal.getOrCreateInstance(modal).show();
        }

        document.getElementById('btn-add-video').addEventListener('click', function() {
            openModal(-1);
        });

        document.getElementById('videos-tbody').addEventListener('click', function(e) {
            var editBtn = e.target.closest('.btn-edit-video');
            var deleteBtn = e.target.closest('.btn-delete-video');

            if (editBtn) {
                openModal(parseInt(editBtn.dataset.index));
            }

            if (deleteBtn) {
                var idx = parseInt(deleteBtn.dataset.index);
                if (confirm('{{ trans('plugins/projects::projects.form.confirm_delete_video') }}')) {
                    videos.splice(idx, 1);
                    renderTable();
                }
            }
        });

        document.getElementById('btn-save-video').addEventListener('click', function() {
            var urlInput = document.getElementById('modal-video-url');
            var url = urlInput.value.trim();

            if (!url) {
                urlInput.classList.add('is-invalid');
                return;
            }

            urlInput.classList.remove('is-invalid');

            var coverInput = document.querySelector('.image-box-video_cover_temp .image-data');
            var cover = coverInput ? coverInput.value : '';
            var entry = {
                url: url,
                cover: cover
            };

            if (editingIndex >= 0) {
                videos[editingIndex] = entry;
            } else {
                videos.push(entry);
            }

            renderTable();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('video-modal')).hide();
        });

        document.getElementById('project-videos-card').querySelector('[data-bs-toggle="collapse"]')
            .addEventListener('click', function() {
                var chevron = document.getElementById('videos-chevron');
                var isExpanded = this.getAttribute('aria-expanded') === 'true';
                chevron.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
            });

        renderTable();
    })();
</script>
