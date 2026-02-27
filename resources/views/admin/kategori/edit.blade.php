@extends('layout.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        @include('layout.sidebar')
        
        <!-- Main Content Area -->
        <div class="col" style="margin-left: 0px;">
            <!-- Dashboard Content -->
            <div class="container-fluid p-4">
               <!-- Header -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem;">
                        <div style="width: 4px; height: 40px; background: #8B0000; border-radius: 2px;"></div>
                        <div>
                            <h2 style="font-size: 1.75rem; font-weight: 800; color: #141516; margin: 0; letter-spacing: -0.5px;">Edit kategori</h2>
                        </div>
                    </div>
                </div>

                <!-- Card Form -->
                <div class="card shadow-lg" style="border: none; border-radius: 16px; overflow: hidden;">
                    <div style="height: 6px; background: linear-gradient(90deg, #8B0000 0%, #b91010 100%);"></div>
                    <div class="card-body p-5">
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px;">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="nama_kategori" class="form-label fw-semibold d-flex align-items-center gap-2" style="color: #2c3e50; font-size: 1rem;">
                                    <span style="color: #8B0000; font-size: 1.2rem;">🏷️</span>
                                    Nama Kategori 
                                    <span style="color: #8B0000;">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    id="nama_kategori"
                                    name="nama_kategori"
                                    value="{{ $kategori->nama_kategori }}"
                                    placeholder="edit kategori"
                                    style="border: 2px solid #e9ecef; padding: 12px 18px; border-radius: 10px; font-size: 1rem;"
                                    required
                                >
                            </div>

                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn-save text-white px-4 py-2">
                                    <i class="fas fa-check-circle me-2"></i>Update Kategori
                                </button>
                                <a href="{{ route('kategori.index') }}" class="btn-cancel px-4 py-2">
                                    <i class="fas fa-times-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
     body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
        min-height: 100vh;
    }
    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06) !important;
    }
    .card {
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #8B0000;
        box-shadow: 0 0 0 0.25rem rgba(139, 0, 0, 0.1);
        background: #fff;
    }

    .form-control:hover {
        border-color: #c9d1d9;
    }

    .btn-save {
        background: linear-gradient(135deg, #8B0000 0%, #a81010 100%);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(139, 0, 0, 0.25);
        text-transform: capitalize;
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #6B0000 0%, #8B0000 100%);
        transform: translateY(-2px);
        box-shadow: 0 3px 5px rgba(139, 0, 0, 0.35);
    }

    .btn-save:active {
        transform: translateY(0);
    }

    .btn-cancel {
        background: #fff;
        border: 2px solid #dee2e6;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        color: #6c757d;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        text-transform: capitalize;
    }

    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .alert {
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Icon animation */
    .btn-save i, .btn-cancel i {
        transition: transform 0.3s ease;
    }

    .btn-save:hover i {
        transform: scale(1.2);
    }

    .btn-cancel:hover i {
        transform: rotate(90deg);
    }
</style>

@endsection