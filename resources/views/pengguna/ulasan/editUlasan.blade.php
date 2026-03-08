@extends('layouts.app')

@section('content')

<div style="font-family:inherit;min-height:100vh;background:#f9fafb;padding:2.5rem 1.5rem;">
<div style="max-width:680px;margin:0 auto;">

    {{-- HEADER --}}
    <div style="margin-bottom:2rem;">
        <a href="javascript:history.back()" style="display:inline-flex;align-items:center;gap:0.4rem;font-size:0.82rem;color:#9e4a4a;text-decoration:none;margin-bottom:1rem;">
            ← Kembali
        </a>

        <h1 style="font-size:1.5rem;font-weight:700;color:#1a0000;margin:0 0 4px;">
            Edit Ulasan
        </h1>

        <p style="font-size:0.85rem;color:#9e4a4a;margin:0;">
            Perbarui ulasan kamu
        </p>
    </div>


    {{-- CARD --}}
    <div style="background:#fff;border-radius:20px;border:1px solid #fde8e8;overflow:hidden;">
        <div style="padding:2rem;">

            <form action="{{ route('ulasan.update',$ulasan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="komentar" id="komentar-input">

                {{-- RATING --}}
                <div style="margin-bottom:1.75rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:700;text-transform:uppercase;color:#9e4a4a;margin-bottom:0.75rem;">
                        Rating
                    </label>

                    <div style="display:flex;gap:0.5rem;" id="star-container">

                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor:pointer;">
                            <input
                                type="radio"
                                name="rating"
                                value="{{ $i }}"
                                class="star-radio"
                                style="display:none;"
                                {{ $ulasan->rating == $i ? 'checked' : '' }}
                            >

                            <svg
                                class="star-icon"
                                data-val="{{ $i }}"
                                width="36"
                                height="36"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#d1d5db"
                                stroke-width="1.5"
                                style="cursor:pointer;transition:0.2s;"
                            >
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </label>
                        @endfor

                    </div>

                    <p id="rating-label" style="font-size:0.78rem;color:#aaa;margin-top:6px;">
                        Ubah rating jika perlu
                    </p>
                </div>


                <hr style="border:none;border-top:1px dashed #fde8e8;margin:0 0 1.75rem;">


                {{-- ULASAN --}}
                <div style="margin-bottom:1.5rem;">

                    <label style="display:block;font-size:0.82rem;font-weight:700;text-transform:uppercase;color:#9e4a4a;margin-bottom:0.75rem;">
                        Ulasan
                    </label>

                    {{-- TOOLBAR --}}
                    <div style="display:flex;gap:0.3rem;padding:0.5rem;background:#f9fafb;border:1px solid #fde8e8;border-bottom:none;border-radius:10px 10px 0 0;">

                        <button type="button" onclick="fmt('bold')">B</button>
                        <button type="button" onclick="fmt('italic')">I</button>
                        <button type="button" onclick="fmt('underline')">U</button>

                    </div>

                    {{-- EDITOR --}}
                    <div
                        id="editor"
                        contenteditable="true"
                        style="min-height:160px;padding:1rem;border:1px solid #fde8e8;border-radius:0 0 10px 10px;background:#fff;"
                        oninput="syncEditor()"
                    >
                        {!! $ulasan->komentar !!}
                    </div>

                </div>


                {{-- BUTTON --}}
                <div style="display:flex;justify-content:flex-end;gap:0.75rem;">

                    <a href="javascript:history.back()" style="padding:0.6rem 1.5rem;background:#f3f4f6;border-radius:10px;text-decoration:none;">
                        Batal
                    </a>

                    <button
                        type="submit"
                        onclick="syncEditor()"
                        style="padding:0.6rem 1.7rem;background:#8B0000;color:white;border:none;border-radius:10px;font-weight:600;"
                    >
                        Update Ulasan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
</div>


<script>

function syncEditor(){
    document.getElementById('komentar-input').value =
    document.getElementById('editor').innerHTML;
}

function fmt(cmd){
    document.execCommand(cmd,false,null);
}

const stars = document.querySelectorAll('.star-icon');
const radios = document.querySelectorAll('.star-radio');

stars.forEach(star => {

    star.addEventListener('click', function(){

        let val = this.dataset.val;
        radios[val-1].checked = true;

        updateStars(val);
    });

});


function updateStars(val){

    stars.forEach((s,i)=>{

        if(i < val){

            s.setAttribute('fill','#f59e0b');
            s.setAttribute('stroke','#f59e0b');

        }else{

            s.setAttribute('fill','none');
            s.setAttribute('stroke','#d1d5db');

        }

    });

}


/* supaya saat halaman edit dibuka bintang langsung kuning */

document.addEventListener("DOMContentLoaded", function(){

    const checked = document.querySelector('.star-radio:checked');

    if(checked){
        updateStars(checked.value);
    }

});

</script>

@endsection