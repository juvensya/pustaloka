@extends('layouts.app')

@section('content')

<div style="font-family:inherit;min-height:100vh;background:#f9fafb;padding:2.5rem 1.5rem;">
<div style="max-width:680px;margin:0 auto;">

    {{-- HEADER --}}
    <div style="margin-bottom:2rem;">
        <a href="javascript:history.back()" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:#9e4a4a;text-decoration:none;margin-bottom:1rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
        <h1 style="font-size:1.5rem;font-weight:700;color:#1a0000;margin:0 0 4px;">Edit Ulasan</h1>
        <p style="font-size:0.85rem;color:#9e4a4a;margin:0;">Perbarui ulasan dan rating kamu</p>
    </div>

    {{-- CARD --}}
    <div style="background:#fff;border-radius:20px;border:1px solid #fde8e8;overflow:hidden;">
        <div style="padding:2rem;">

            <form action="{{ route('ulasan.update', $ulasan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="komentar" id="komentar-input">

                {{-- RATING --}}
                <div style="margin-bottom:1.75rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9e4a4a;margin-bottom:0.75rem;">Rating</label>

                    <div style="display:flex;gap:0.5rem;" id="star-container">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor:pointer;">
                            <input type="radio" name="rating" value="{{ $i }}" style="display:none;" class="star-radio" {{ $ulasan->rating == $i ? 'checked' : '' }}>
                            <svg class="star-icon" data-val="{{ $i }}" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" style="transition:all 0.15s;cursor:pointer;">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </label>
                        @endfor
                    </div>
                    <p id="rating-label" style="font-size:0.78rem;color:#aaa;margin:6px 0 0;">Ubah rating jika perlu</p>
                </div>

                <hr style="border:none;border-top:1px dashed #fde8e8;margin:0 0 1.75rem;">

                {{-- ULASAN --}}
                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#9e4a4a;margin-bottom:0.75rem;">Ulasan</label>

                    {{-- TOOLBAR --}}
                    <div style="display:flex;gap:0.3rem;padding:0.5rem 0.75rem;background:#f9fafb;border:1px solid #fde8e8;border-bottom:none;border-radius:10px 10px 0 0;flex-wrap:wrap;">

                        <button type="button" onclick="fmt('bold')" title="Bold"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;font-weight:700;font-size:0.85rem;color:#374151;">B</button>

                        <button type="button" onclick="fmt('italic')" title="Italic"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;font-style:italic;font-size:0.85rem;color:#374151;">I</button>

                        <button type="button" onclick="fmt('underline')" title="Underline"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;text-decoration:underline;font-size:0.85rem;color:#374151;">U</button>

                        <button type="button" onclick="fmt('strikeThrough')" title="Strikethrough"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;text-decoration:line-through;font-size:0.85rem;color:#374151;">S</button>

                        <div style="width:1px;background:#e5e7eb;margin:4px 2px;"></div>

                        <button type="button" onclick="fmt('justifyLeft')" title="Rata Kiri"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;font-size:0.75rem;color:#374151;display:flex;align-items:center;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="15" y2="12"/><line x1="3" y1="18" x2="18" y2="18"/></svg>
                        </button>

                        <button type="button" onclick="fmt('justifyCenter')" title="Tengah"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;font-size:0.75rem;color:#374151;display:flex;align-items:center;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="6" y1="12" x2="18" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
                        </button>

                        <button type="button" onclick="fmt('justifyRight')" title="Rata Kanan"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;font-size:0.75rem;color:#374151;display:flex;align-items:center;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="9" y1="12" x2="21" y2="12"/><line x1="6" y1="18" x2="21" y2="18"/></svg>
                        </button>

                        <div style="width:1px;background:#e5e7eb;margin:4px 2px;"></div>

                        <button type="button" onclick="fmt('insertUnorderedList')" title="Bullet List"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;color:#374151;display:flex;align-items:center;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="9" y1="6" x2="20" y2="6"/><line x1="9" y1="12" x2="20" y2="12"/><line x1="9" y1="18" x2="20" y2="18"/><circle cx="4" cy="6" r="1" fill="currentColor"/><circle cx="4" cy="12" r="1" fill="currentColor"/><circle cx="4" cy="18" r="1" fill="currentColor"/></svg>
                        </button>

                        <button type="button" onclick="fmt('insertOrderedList')" title="Numbered List"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;color:#374151;display:flex;align-items:center;justify-content:center;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>
                        </button>

                        <div style="width:1px;background:#e5e7eb;margin:4px 2px;"></div>

                        <button type="button" onclick="fmt('removeFormat')" title="Hapus Format"
                            style="width:32px;height:32px;border:1px solid #e5e7eb;background:#fff;border-radius:6px;cursor:pointer;color:#9e4a4a;font-size:0.7rem;font-weight:700;">Tx</button>

                    </div>

                    {{-- EDITOR --}}
                    <div id="editor"
                        contenteditable="true"
                        style="min-height:160px;padding:1rem;border:1px solid #fde8e8;border-radius:0 0 10px 10px;font-size:0.9rem;line-height:1.7;color:#1a0000;background:#fff;outline:none;"
                        oninput="syncEditor()">
                        {!! $ulasan->komentar !!}
                    </div>

                </div>

                {{-- SUBMIT --}}
                <div style="display:flex;justify-content:flex-end;gap:0.75rem;">
                    <a href="javascript:history.back()" style="padding:0.65rem 1.5rem;background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;border-radius:10px;font-size:0.875rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;">
                        Batal
                    </a>
                    <button type="submit" onclick="syncEditor()"
                        style="padding:0.65rem 1.75rem;background:linear-gradient(135deg,#8B0000,#a80000);color:#fff;border:none;border-radius:10px;font-size:0.875rem;font-weight:700;cursor:pointer;font-family:inherit;display:inline-flex;align-items:center;gap:0.4rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Update Ulasan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
</div>

<style>
    #editor:empty:before {
        content: attr(placeholder);
        color: #ccc;
        pointer-events: none;
    }
</style>

<script>
    function syncEditor() {
        document.getElementById('komentar-input').value = document.getElementById('editor').innerHTML;
    }

    function fmt(cmd) {
        document.getElementById('editor').focus();
        document.execCommand(cmd, false, null);
    }

    const stars  = document.querySelectorAll('.star-icon');
    const radios = document.querySelectorAll('.star-radio');
    const labels = ['', 'Buruk', 'Kurang', 'Cukup', 'Bagus', 'Sangat Bagus'];

    stars.forEach(star => {
        star.addEventListener('click', function () {
            const val = parseInt(this.dataset.val);
            radios[val - 1].checked = true;
            updateStars(val);
        });
        star.addEventListener('mouseover', function () {
            updateStars(parseInt(this.dataset.val), true);
        });
        star.addEventListener('mouseout', function () {
            const checked = document.querySelector('.star-radio:checked');
            updateStars(checked ? parseInt(checked.value) : 0);
        });
    });

    function updateStars(val, hover = false) {
        stars.forEach((s, i) => {
            if (i < val) {
                s.setAttribute('fill', hover ? '#fbbf24' : '#f59e0b');
                s.setAttribute('stroke', hover ? '#fbbf24' : '#f59e0b');
            } else {
                s.setAttribute('fill', 'none');
                s.setAttribute('stroke', '#d1d5db');
            }
        });
        if (!hover && val > 0) {
            document.getElementById('rating-label').textContent = labels[val];
            document.getElementById('rating-label').style.color = '#f59e0b';
        }
    }

    // Inisialisasi bintang dari data yang sudah ada
    document.addEventListener('DOMContentLoaded', function () {
        const checked = document.querySelector('.star-radio:checked');
        if (checked) {
            const val = parseInt(checked.value);
            updateStars(val);
            document.getElementById('rating-label').textContent = labels[val];
            document.getElementById('rating-label').style.color = '#f59e0b';
        }
    });
</script>

@endsection