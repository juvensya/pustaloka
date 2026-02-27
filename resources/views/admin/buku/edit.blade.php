@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        @include('layout.sidebar')

        {{-- Main Content --}}
        <div class="col p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); height: 100vh; overflow: hidden;">

            <div style="display: flex; flex-direction: column; height: 100%; max-width: 1400px; margin: 0 auto;">
                
                {{-- Header --}}
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem;">
                        <div style="width: 4px; height: 40px; background: #8B0000; border-radius: 2px;"></div>
                        <div>
                            <h2 style="font-size: 1.75rem; font-weight: 800; color: #2c3e50; margin: 0; letter-spacing: -0.5px;">Edit Buku</h2>
                        </div>
                    </div>
                </div>

                {{-- Card Form --}}
                <div style="background: white; border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08); flex: 1; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #dee2e6;">
                    
                    {{-- Card Header --}}
                    <div style="background: #f8f9fa; padding: 1rem 2rem; border-bottom: 2px solid #e9ecef;">
                        <h3 style="color: #2c3e50; font-size: 1.05rem; font-weight: 700; margin: 0;">Form Edit Data Buku</h3>
                    </div>

                    {{-- Form Content TANPA Scroll --}}
                    <div style="flex: 1; padding: 1.5rem 2rem; overflow: hidden; display: flex; flex-direction: column;">

                        {{-- Error Validation --}}
                        @if($errors->any())
                            <div style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%); border-left: 5px solid #dc3545; color: #721c24; padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.85rem; box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);">
                                <strong style="display: block; margin-bottom: 8px; font-size: 0.9rem;">
                                    Terdapat kesalahan input
                                </strong>
                                <ul style="margin: 0; padding-left: 20px; line-height: 1.5;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" id="formBuku" style="flex: 1; display: flex; flex-direction: column;">
                            @csrf
                            @method('PUT')

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; flex: 1;">
                                
                                {{-- Column 1 --}}
                                <div style="padding: 1.25rem; border-radius: 14px; display: flex; flex-direction: column;">
                                    <h4 style="color: #2c3e50; font-size: 0.95rem; font-weight: 700; margin: 0 0 1rem 0; padding-bottom: 0.6rem; border-bottom: 2px solid #dee2e6;">
                                        Informasi Utama
                                    </h4>

                                    <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                                        {{-- Kategori --}}
                                        <div>
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Kategori <span style="color: #dc3545; font-weight: 800;">*</span>
                                            </label>
                                            <select name="kategori_id" required 
                                                    style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                    onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                                @foreach ($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Judul --}}
                                        <div>
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Judul Buku <span style="color: #dc3545; font-weight: 800;">*</span>
                                            </label>
                                            <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required 
                                                   placeholder="Masukkan judul buku"
                                                   style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                   onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                        </div>

                                        {{-- Penulis --}}
                                        <div>
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Penulis <span style="color: #dc3545; font-weight: 800;">*</span>
                                            </label>
                                            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" required 
                                                   placeholder="Masukkan nama penulis"
                                                   style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                   onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                        </div>

                                        {{-- Penerbit --}}
                                        <div>
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Penerbit <span style="color: #dc3545; font-weight: 800;">*</span>
                                            </label>
                                            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required 
                                                   placeholder="Masukkan nama penerbit"
                                                   style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                   onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                        </div>
                                    </div>
                                </div>

                                {{-- Column 2 --}}
                                <div style="padding: 1.25rem; border-radius: 14px; display: flex; flex-direction: column;">
                                    <h4 style="color: #2c3e50; font-size: 0.95rem; font-weight: 700; margin: 0 0 1rem 0; padding-bottom: 0.6rem; border-bottom: 2px solid #dee2e6;">
                                        Detail Tambahan
                                    </h4>

                                    <div style="display: flex; flex-direction: column; gap: 1rem; flex: 1;">
                                        {{-- Tahun & Stock --}}
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                            <div>
                                                <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                    Tahun Terbit <span style="color: #dc3545; font-weight: 800;">*</span>
                                                </label>
                                                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required 
                                                       placeholder="2024" min="1900" max="2100"
                                                       style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                       onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                       onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                            </div>

                                            <div>
                                                <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                    Stock <span style="color: #dc3545; font-weight: 800;">*</span>
                                                </label>
                                                <input type="number" name="stock" value="{{ old('stock', $buku->stock) }}" required min="0"
                                                       placeholder="0"
                                                       style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; font-weight: 500;"
                                                       onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                       onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                            </div>
                                        </div>

                                        {{-- Deskripsi --}}
                                        <div style="flex: 1; display: flex; flex-direction: column;">
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Deskripsi <span style="color: #dc3545; font-weight: 800;">*</span>
                                            </label>
                                            <textarea name="deskripsi" rows="2" required 
                                                      placeholder="Masukkan deskripsi singkat buku..."
                                                      style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; resize: none; font-weight: 500; line-height: 1.5; flex: 1;"
                                                      onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                      onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                        </div>

                                        {{-- Cover Buku --}}
                                        <div>
                                            <label style="display: block; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem; font-size: 0.85rem;">
                                                Ganti Cover Buku
                                            </label>
                                            
                                            @if($buku->gambar)
                                                <div style="margin-bottom: 0.75rem; text-align: center;">
                                                    <img src="{{ asset('uploads/buku/' . $buku->gambar) }}" alt="Cover Lama" style="width: 100px; height: auto; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12); border: 2px solid #e9ecef;">
                                                    <p style="font-size: 0.75rem; color: #6c757d; margin-top: 0.5rem;">Cover saat ini</p>
                                                </div>
                                            @endif

                                            <input type="file" name="gambar" accept="image/*" id="gambarInput"
                                                   style="width: 100%; padding: 10px 12px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.85rem; outline: none; background: white; transition: all 0.3s; cursor: pointer;"
                                                   onfocus="this.style.borderColor='#adb5bd'; this.style.boxShadow='0 0 0 3px rgba(173, 181, 189, 0.1)'"
                                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                                   onchange="previewImage(event)">
                                            <small style="color: #6c757d; font-size: 0.75rem; display: block; margin-top: 0.3rem;">
                                                Kosongkan jika tidak ingin mengganti cover
                                            </small>
                                            
                                            {{-- Preview Image --}}
                                            <div id="imagePreview" style="margin-top: 0.75rem; display: none; text-align: center;">
                                                <img id="preview" src="" alt="Preview" style="width: 100px; height: auto; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12); border: 2px solid white;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>

                    {{-- Footer Buttons --}}
                    <div style="padding: 1rem 2rem; background: #f8f9fa; border-top: 2px solid #e9ecef; display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="{{ route('buku.index') }}" 
                           style="background: #8B0000; color: white; padding: 10px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; font-size: 0.9rem;"
                           onmouseover="this.style.background='#6B0000'; this.style.transform='translateY(-2px)'"
                           onmouseout="this.style.background='#8B0000'; this.style.transform='translateY(0)'">
                            Kembali
                        </a>

                        <button type="submit" form="formBuku"
                                style="background: #8B0000; color: white; padding: 10px 36px; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s; font-size: 0.9rem;"
                                onmouseover="this.style.background='#6B0000'; this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.background='#8B0000'; this.style.transform='translateY(0)'">
                            Update Buku
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // Image Preview
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }

    // Form Validation
    document.getElementById('formBuku').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        let emptyFields = [];
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                emptyFields.push(field);
                field.style.borderColor = '#dc3545';
                field.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.2)';
                
                setTimeout(() => {
                    field.style.borderColor = '#e9ecef';
                    field.style.boxShadow = 'none';
                }, 3000);
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!\n\nField yang masih kosong: ' + emptyFields.length);
            
            if (emptyFields.length > 0) {
                emptyFields[0].focus();
            }
        }
    });
</script>
@endsection