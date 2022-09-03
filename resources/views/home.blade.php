@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add monitor
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add monitor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('monitors.store')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Host</label>
                            <input type="" name="host" class="form-control" id="exampleFormControlInput1" placeholder="google.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Port</label>
                            <input type="" name="port" class="form-control" id="exampleFormControlInput1" placeholder="80">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Protocol</label>
                            <select name="protocol" class="form-select" aria-label="Default select example">
                                <option selected>--Pick one --</option>
                                <option value="1">tcp</option>
                                <option value="2">udp</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Frequency (minutes)</label>
                            <select name="frequency" class="form-select" aria-label="Default select example">
                                <option selected>--Pick one --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($u->monitors)==0)
                        <h1>Looks like you have no monitors configured</h1>
                    @else
                        @foreach($u->monitors->sortByDesc('id') as $m)
                            {{$m->host}}
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
