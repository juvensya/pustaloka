@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        @include('layout.sidebar')

        {{-- Main Content --}}
        <div class="col p-0" style="background:#f8f9fa;min-height:100vh;">

            @include('layout.navbar')

            {{-- Content area dengan padding --}}
            <div style="padding:1.5rem;">

            {{-- Body --}}
            <div style="flex: 1; overflow: hidden; background: #f8f8f8; padding: 16px 32px; display: flex; flex-direction: column; gap: 12px;">

                {{-- Success Alert --}}
                @if (session('status') === 'profile-updated')
                    <div id="success-alert" style="display: flex; align-items: center; gap: 8px; background: #fff5f5; border-left: 4px solid #8B0000; color: #5a0000; border-radius: 8px; padding: 10px 14px; font-size: 13px; flex-shrink: 0;">
                        <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Profile berhasil diperbarui.
                    </div>
                @endif

                {{-- ========================= UPDATE PROFILE ========================== --}}
                <div style="background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(139,0,0,0.05); height: fit-content; padding: 18px 24px;">

                    {{-- Card Header --}}
                    <div style="display: flex; align-items: center; gap: 10px; padding-bottom: 12px; margin-bottom: 14px; border-bottom: 1px solid #fdf0f0; flex-shrink: 0;">
                        <div style="width: 30px; height: 30px; background: #fff0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <span style="font-size: 13px; font-weight: 700; color: #1a0000;">Informasi Akun</span>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" >
                        @csrf
                        @method('PATCH')

                        <div style="display: flex; flex-direction: column; gap: 10px; max-width: 480px;">

                            {{-- Nama --}}
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       placeholder="Masukkan nama lengkap"
                                       style="width: 100%; padding: 9px 14px; font-size: 13px; color: #1a0000; background: #fafafa; border: 1.5px solid #fde0e0; border-radius: 10px; outline: none; transition: border-color 0.15s;"
                                       onfocus="this.style.borderColor='#8B0000'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#fde0e0'; this.style.background='#fafafa';">
                                @error('name')
                                    <small style="display: block; margin-top: 4px; font-size: 11px; color: #b30000;">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Email hanya untuk Admin --}}
                            @if(auth()->user()->role === 'admin')
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       placeholder="Masukkan email"
                                       style="width: 100%; padding: 9px 14px; font-size: 13px; color: #1a0000; background: #fafafa; border: 1.5px solid #fde0e0; border-radius: 10px; outline: none; transition: border-color 0.15s;"
                                       onfocus="this.style.borderColor='#8B0000'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#fde0e0'; this.style.background='#fafafa';">
                                @error('email')
                                    <small style="display: block; margin-top: 4px; font-size: 11px; color: #b30000;">{{ $message }}</small>
                                @enderror
                            </div>
                            @endif

                            <div>
                                <button type="submit"
                                        style="padding: 9px 20px; background: #8B0000; color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 2px 8px rgba(139,0,0,0.2); transition: background 0.15s;"
                                        onmouseover="this.style.background='#6e0000'"
                                        onmouseout="this.style.background='#8B0000'">
                                    Simpan Perubahan
                                </button>
                            </div>

                        </div>
                    </form>
                </div>


                {{-- ========================= UPDATE PASSWORD (ADMIN ONLY) ========================== --}}
                @if(auth()->user()->role === 'admin')
                <div style="background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(139,0,0,0.05); height: fit-content; padding: 18px 24px;">

                    {{-- Card Header --}}
                    <div style="display: flex; align-items: center; gap: 10px; padding-bottom: 12px; margin-bottom: 14px; border-bottom: 1px solid #fdf0f0; flex-shrink: 0;">
                        <div style="width: 30px; height: 30px; background: #fff0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="#8B0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <span style="font-size: 13px; font-weight: 700; color: #1a0000;">Ganti Password</span>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" >
                        @csrf
                        @method('PUT')

                        <div style="display: flex; flex-direction: column; gap: 10px; max-width: 480px;">

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Password Lama</label>
                                <input type="password" name="current_password" placeholder="••••••••"
                                       style="width: 100%; padding: 9px 14px; font-size: 13px; color: #1a0000; background: #fafafa; border: 1.5px solid #fde0e0; border-radius: 10px; outline: none;"
                                       onfocus="this.style.borderColor='#8B0000'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#fde0e0'; this.style.background='#fafafa';">
                                @error('current_password')
                                    <small style="display: block; margin-top: 4px; font-size: 11px; color: #b30000;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Password Baru</label>
                                <input type="password" name="password" placeholder="••••••••"
                                       style="width: 100%; padding: 9px 14px; font-size: 13px; color: #1a0000; background: #fafafa; border: 1.5px solid #fde0e0; border-radius: 10px; outline: none;"
                                       onfocus="this.style.borderColor='#8B0000'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#fde0e0'; this.style.background='#fafafa';">
                                @error('password')
                                    <small style="display: block; margin-top: 4px; font-size: 11px; color: #b30000;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" placeholder="••••••••"
                                       style="width: 100%; padding: 9px 14px; font-size: 13px; color: #1a0000; background: #fafafa; border: 1.5px solid #fde0e0; border-radius: 10px; outline: none;"
                                       onfocus="this.style.borderColor='#8B0000'; this.style.background='#fff';"
                                       onblur="this.style.borderColor='#fde0e0'; this.style.background='#fafafa';">
                            </div>

                            <div>
                                <button type="submit"
                                        style="padding: 9px 20px; background: #fff; color: #8B0000; font-size: 13px; font-weight: 600; border: 1.5px solid rgba(139,0,0,0.35); border-radius: 10px; cursor: pointer; transition: all 0.15s;"
                                        onmouseover="this.style.background='#8B0000'; this.style.color='#fff'; this.style.borderColor='#8B0000';"
                                        onmouseout="this.style.background='#fff'; this.style.color='#8B0000'; this.style.borderColor='rgba(139,0,0,0.35)';">
                                    Update Password
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
    const alertEl = document.getElementById('success-alert');
    if (alertEl) setTimeout(() => alertEl.remove(), 4000);
</script>

@endsection