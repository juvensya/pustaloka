@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layout.sidebar')

        <!-- Main Content Area -->
        <div class="col p-4" style="background: #f8f9fa; min-height: 100vh;">

            <!-- Header -->
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 4px; height: 40px; background: #8B0000; border-radius: 2px;"></div>
                    <div>
                        <h2 style="font-size: 1.75rem; font-weight: 800; color: #141516; margin: 0; letter-spacing: -0.5px;">Tambah Petugas</h2>
                        <p style="color: #666; font-size: 0.95rem; margin: 0;">Isi form berikut untuk menambah petugas baru</p>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2.5rem;">
                <form action="{{ route('petugas.store') }}" method="POST" autocomplete="off">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">

                        {{-- Nama --}}
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem;">
                                Nama <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 0.95rem; outline: none; box-sizing: border-box; color: #2c3e50;"
                                onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                            @error('name')
                                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.35rem; margin-bottom: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem;">
                                Email <span style="color: #dc3545;">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email"
                                autocomplete="off"
                                style="width: 100%; padding: 14px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 0.95rem; outline: none; box-sizing: border-box; color: #2c3e50;"
                                onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                            @error('email')
                                <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.35rem; margin-bottom: 0;">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Password --}}
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #2c3e50; margin-bottom: 0.5rem;">
                            Password <span style="color: #dc3545;">*</span>
                        </label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Masukkan password (min. 6 karakter)"
                                autocomplete="new-password"
                                style="width: 100%; padding: 14px 50px 14px 16px; border: 2px solid #e9ecef; border-radius: 10px; font-size: 0.95rem; outline: none; box-sizing: border-box; color: #2c3e50;"
                                onfocus="this.style.borderColor='#8B0000'" onblur="this.style.borderColor='#e9ecef'">
                            <button type="button" onclick="togglePassword()"
                                style="position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6c757d; font-size: 1rem;">
                                👁
                            </button>
                        </div>
                        @error('password')
                            <p style="color: #dc3545; font-size: 0.8rem; margin-top: 0.35rem; margin-bottom: 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Divider --}}
                    <div style="border-top: 2px solid #f0f0f0; margin-bottom: 1.5rem;"></div>

                    {{-- Buttons --}}
                    <div style="display: flex; gap: 12px;">
                        <button type="submit"
                            style="background: #8B0000; color: white; padding: 13px 32px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s;"
                            onmouseover="this.style.background='#6B0000'" onmouseout="this.style.background='#8B0000'">
                            Simpan Petugas
                        </button>
                        <a href="{{ route('petugas.index') }}"
                            style="background: #f8f9fa; color: #6c757d; padding: 13px 32px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; border: 2px solid #e9ecef; transition: all 0.2s;"
                            onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection