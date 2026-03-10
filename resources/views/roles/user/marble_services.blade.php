@extends('layouts.userapp')

@section('content')
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
@endsection
