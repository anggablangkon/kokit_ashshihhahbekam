@extends('layouts.layouts')

@section('title', 'Profil Saya')

@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center justify-content-between py-2">
            <div class="flex-grow-1">
                <h4 class="fs-sm text-uppercase fw-bold m-0">Profil Saya</h4>
                <p class="text-muted mb-0">Perbarui foto profil dan password dashboard.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">Informasi Profil</h4>
                    </div>
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="72" height="72" style="object-fit: cover;">
                                <div>
                                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                                    <div class="text-muted">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control bg-light text-muted" value="{{ auth()->user()->name }}" disabled readonly>
                                <div class="form-text">Nama tidak dapat diubah.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control bg-light text-muted" value="{{ auth()->user()->email }}" disabled readonly>
                                <div class="form-text">Email tidak dapat diubah.</div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/png,image/jpeg,image/webp">
                                @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Foto Profil</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header border-dashed">
                        <h4 class="card-title mb-0">Update Password</h4>
                    </div>
                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection