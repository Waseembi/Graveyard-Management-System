@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <h4 class="mb-3">Edit Family Member</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.family.update', $member->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $member->name) }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Father Name</label>
                        <input type="text" name="father_name"
                               value="{{ old('father_name', $member->father_name) }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"> Relationship</label>
                        <select name="relationship" class="form-select" required>
                            <option value="">Select</option>
                            <option value="father" {{ old('relationship', $member->relationship) == 'father' ? 'selected' :                     '' }}>Father</option>
                            <option value="mother" {{ old('relationship', $member->relationship) == 'mother' ? 'selected' :                     '' }}>Mother</option>
                            <option value="brother" {{ old('relationship', $member->relationship) == 'brother' ? 'selected'                     : '' }}>Brother</option>
                            <option value="sister" {{ old('relationship', $member->relationship) == 'sister' ? 'selected' :                     '' }}>Sister</option>
                            <option value="son" {{ old('relationship', $member->relationship) == 'son' ? 'selected' : '' }}                 >Son</option>
                            <option value="daughter" {{ old('relationship', $member->relationship) == 'daughter' ?                 'selected' : '' }}>Daughter</option>
                            <option value="wife" {{ old('relationship', $member->relationship) == 'wife' ? 'selected' : '' }}                   >Wife</option>
                            <option value="other" {{ old('relationship', $member->relationship) == 'other' ? 'selected' :                   '' }}>Other</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age"
                               value="{{ old('age', $member->age) }}"
                               class="form-control" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">CNIC</label>
                        <input type="text" name="cnic"
                               value="{{ old('cnic', $member->cnic) }}"
                               class="form-control"
                               placeholder="Optional">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob"
                               value="{{ old('dob', $member->dob) }}"
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $member->gender)=='male' ? 'selected' : '' }}>
                                Male
                            </option>
                            <option value="female" {{ old('gender', $member->gender)=='female' ? 'selected' : '' }}>
                                Female
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address"
                               value="{{ old('address', $member->address) }}"
                               class="form-control"
                               placeholder="Optional">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update
                        </button>

                        <a href="{{ route('user.records') }}#family" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
