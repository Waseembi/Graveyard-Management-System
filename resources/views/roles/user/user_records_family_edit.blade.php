@extends('layouts.userapp')

@section('content')

<div class="content" id="mainContent">
    <div class="container-fluid">

        {{-- Success message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
    ">      
        {{ session('success') }}
    </div>
@endif

 {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger text-center mx-auto mt-5" style="
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
{{-- Error message --}}
@if(session('error'))
    <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(255, 0, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
    ">      
        {{ session('error') }}
    </div>
@endif

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-success"><i class="bi bi-pencil-square me-2"></i>Edit Family Member</h4>
                <p class="text-muted mb-0">Modify family member details.</p>
            </div>
            
            <a href="{{ route('user.records') }}#family" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Update Form Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">Edit Details</h6>
            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('user.family.update', $member->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Father Name</label>
                            <input type="text" name="father_name" value="{{ old('father_name', $member->father_name) }}" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Relationship</label>
                            <select name="relationship" class="form-select shadow-sm" required>
                                <option value="">Select</option>
                                <option value="father" {{ old('relationship', $member->relationship)=='father' ? 'selected' : '' }}>Father</option>
                                <option value="mother" {{ old('relationship', $member->relationship)=='mother' ? 'selected' : '' }}>Mother</option>
                                <option value="brother" {{ old('relationship', $member->relationship)=='brother' ? 'selected' : '' }}>Brother</option>
                                <option value="sister" {{ old('relationship', $member->relationship)=='sister' ? 'selected' : '' }}>Sister</option>
                                <option value="son" {{ old('relationship', $member->relationship)=='son' ? 'selected' : '' }}>Son</option>
                                <option value="daughter" {{ old('relationship', $member->relationship)=='daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="wife" {{ old('relationship', $member->relationship)=='wife' ? 'selected' : '' }}>Wife</option>
                                <option value="other" {{ old('relationship', $member->relationship)=='other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Age</label>
                            <input type="number" name="age" value="{{ old('age', $member->age) }}" class="form-control shadow-sm" min="0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNIC</label>
                            <input type="text" name="cnic" value="{{ old('cnic', $member->cnic) }}" class="form-control shadow-sm" placeholder="Optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="dob" max="{{ date('Y-m-d') }}"required value="{{ old('dob', $member->dob) }}" class="form-control shadow-sm">
                        </div>
                        
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select shadow-sm">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $member->gender)=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $member->gender)=='female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" value="{{ old('address', $member->address) }}" class="form-control shadow-sm" placeholder="Optional">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                        
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>



<script>
    setTimeout(() => {
        const alert = document.querySelector(".alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endsection
