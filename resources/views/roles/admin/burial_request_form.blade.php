@extends('layouts.adminapp')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    ">      
        {{ session('success') }}
    </div>
@endif

 {{-- Validation Errors --}}
    @if ($errors->any())
        <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 400px;
            z-index: 1050;
            box-shadow: 0 0.5rem 1rem rgba(128, 0, 0, 0.2);
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            line-height: 1.3;
        ">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="list-style-type: none">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

{{-- Error Message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    ">      
        {{ session('success') }}
    </div>
@endif


<div class="content" id="mainContent">
    <div class="container-fluid py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -40px;">
            <h4 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-cross me-2"></i>Burial Request Details
            </h4>
            <a href="{{ route('admin.burial.requests') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fa-solid fa-user me-2"></i>Burial Name</label>
                        <input type="text" class="form-control rounded-pill" value="{{ $request->user->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fa-solid fa-id-card me-2"></i>CNIC</label>
                        <input type="text" class="form-control rounded-pill" value="{{ $request->cnic ?? 'N/A' }}" disabled>
                    </div>

                    <!-- Death Certificate -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fa-solid fa-file me-2"></i>Death Certificate</label>
                        <div class="d-flex flex-row gap-2 align-items-center mb-2">
                            <!-- View Button -->
                            <a href="{{ asset('uploads/death/' . $request->death_certificate) }}" target="_blank" 
                               class="btn btn-outline-primary rounded-pill">
                                <i class="fa-solid fa-eye me-1"></i>View
                            </a>
                        
                            <!-- Download Button -->
                            <a href="{{ asset('uploads/death/' . $request->death_certificate) }}" 
                               download="{{ $request->death_certificate }}" 
                               class="btn btn-outline-success rounded-pill">
                                <i class="fa-solid fa-download me-1"></i>Download
                            </a>
                        </div>
                    
                        <!-- File name -->
                        <small class="text-muted">File: {{ $request->death_certificate }}</small>
                    
                        <!-- If it's an image, show preview -->
                        @if(Str::endsWith($request->death_certificate, ['jpg','jpeg','png']))
                            <img src="{{ asset('uploads/death/' . $request->death_certificate) }}" 
                                 alt="Death Certificate" 
                                 class="img-fluid rounded shadow-sm mt-2" 
                                 style="max-height: 250px;">
                        @endif
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fa-solid fa-user-tie me-2"></i>Father Name</label>
                        <input type="text" class="form-control rounded-pill" value="{{ $request->father_name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="fa-solid fa-hourglass-half me-2"></i>Date of Death</label>
                        <input type="text" class="form-control rounded-pill" value="{{ ucfirst($request->date_of_death) }}" disabled>
                    </div>

                    <!-- Approve / Reject Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <!-- Approve Form -->
                        <form method="POST" action="{{ route('admin.burial.requests.approve', $request->id) }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Grave Image Upload --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-success">
                                    Grave Picture <small class="text-muted">(Optional)</small>
                                </label>
                                <input type="file" name="grave_image" 
                                       class="form-control rounded-pill shadow-sm"
                                       accept="image/*"
                                       id="graveImageInput">
                            </div>

                            {{-- Preview --}}
                            <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                                <p class="fw-semibold text-success">Preview:</p>
                                <img id="imagePreview" src="" alt="Grave Preview" class="img-fluid rounded shadow-sm" style="max-width: 250px;">
                            </div>

                            <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-check me-1"></i>Approve Burial
                            </button>
                        </form>

                        <!-- Reject Form -->
                        <form method="POST" action="{{ route('admin.burial.requests.reject', $request->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-times me-1"></i>Reject Burial
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #f5fdf9;
    }
    .card {
        transition: 0.3s;
    }
    .form-control {
        padding: 0.6rem 1rem;
    }
    .btn-success {
        background-color: #1d9e7e;
        border: none;
        transition: 0.3s;
    }
    .btn-success:hover {
        background-color: #157359;
    }
    .btn-danger {
        background-color: #d9534f;
        border: none;
        transition: 0.3s;
    }
    .btn-danger:hover {
        background-color: #b52b27;
    }
    .btn-outline-secondary:hover {
        background-color: #e6e6e6;
    }
</style>

{{-- Script --}}
<script>
window.onload = function() {
    // Image preview
    const graveInput = document.getElementById('graveImageInput');
    if(graveInput){
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        graveInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '';
            }
        });
    }
};
 setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);

   
</script>
@endsection
