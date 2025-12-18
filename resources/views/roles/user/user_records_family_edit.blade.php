<form method="POST" action="{{ route('user.family.update', $member->id) }}">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $member->name }}" class="form-control mb-2">
    <input type="text" name="father_name" value="{{ $member->father_name }}" class="form-control mb-2">
    <input type="number" name="age" value="{{ $member->age }}" class="form-control mb-2">
    <input type="text" name="cnic" value="{{ $member->cnic }}" class="form-control mb-2">
    <input type="date" name="dob" value="{{ $member->dob }}" class="form-control mb-2">

    <select name="gender" class="form-control mb-3">
        <option value="male" {{ $member->gender=='male'?'selected':'' }}>Male</option>
        <option value="female" {{ $member->gender=='female'?'selected':'' }}>Female</option>
    </select>

    <button class="btn btn-success">Update</button>
</form>
