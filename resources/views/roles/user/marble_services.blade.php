@extends('layouts.userapp')

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
<div class="content" id="mainContent" style="padding-top: 5px;"> 
    <div class="container-fluid py-4">
        <div class="row">

           <!-- Main content column -->
            <div class="col-md-9 col-lg-10">
                <h4 class="mb-4">My Buried Records - Marble Service</h4>

                @if($burials->isEmpty())
                    <div class="alert alert-info">
                        No buried records found for marble service.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Date of Death</th>
                                    <th>Grave ID</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($burials as $key => $burial)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $burial->name }}</td>
                                        <td>{{ $burial->father_name }}</td>
                                        <td>{{ $burial->date_of_death }}</td>
                                        <td>{{ $burial->grave_id }}</td>
                                        {{-- <td>
                                            <a href="{{ route('marble.service.create', $burial->grave_id) }}" 
                                               class="btn btn-primary btn-sm">
                                                Book Service
                                            </a>
                                        </td> --}}
                                        <td>
                                            @if($burial->marbleBookings->isNotEmpty())
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($burial->marbleBookings->last()->status) }}
                                                </span>
                                            @else
                                                <a href="{{ route('marble.service.create', $burial->grave_id) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    Book Service
                                                </a>
                                            @endif
                                        </td>
                                        <td>
    @if($burial->marbleBookings->isNotEmpty() && $burial->marbleBookings->last()->status == 'pending')
        <a href="{{ route('marble.pay', $burial->marbleBookings->last()->id) }}"
           class="btn btn-sm btn-outline-primary ms-2">
            <i class="fa-solid fa-credit-card"></i> Pay Fee
        </a>
    @endif
</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
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
