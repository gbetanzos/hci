@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add monitor
            </button>
            <p>

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
                            <select name="port" class="form-select" aria-label="Default select example">
                                <option selected>-- Pick one --</option>
                                <option value="80">80</option>
                                <option value="443">443</option>
                                <option value="8080">8080</option>
                            </select>
                        </div>
                        {{--
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Protocol</label>
                            <select name="protocol" class="form-select" aria-label="Default select example">
                                <option selected>-- Pick one --</option>
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
                        --}}
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($u->monitors)==0)
                        <h4>Looks like you have no monitors configured</h4>
                    @else
                        @foreach($u->monitors->sortByDesc('id') as $m)
                            <div class="card">
                                <h5 class="card-header">Host: {{$m->host}} - Port: {{$m->port}}</h5>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="pie-chart-container">
                                            <canvas id="myChart{{$m->id}}" style="width:100%; height:250px;"></canvas>
                                        </div>
                                    </div>
                                    {{--
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                    --}}
                                </div>
                            </div>
                            <script>

                                    //get the pie chart canvas
                                    <?php
                                    $data="";
                                    $statuses=[];
                                    foreach($m->tics as $t){
                                        if(!in_array($t->status, $statuses)){
                                            array_push($statuses,$t->status);
                                        }
                                    }
                                    foreach($statuses as $s){
                                        $data.="{ \n label: '$s',\n data: [";
                                        $flag=0;
                                        foreach($m->tics as $t){
                                            if($t->status==$s){
                                                $flag=1;
                                                $data.="{x:'".$t->created_at."',y:".$t->time."},";
                                            }
                                            
                                        }
                                        if($flag==1){
                                            $data=substr($data, 0, -1);
                                        }
                                        $data.="],\n";
                                        if($s==200){
                                            $data.="borderColor: \"rgb(75, 192, 192)\",\n";
                                        }elseif($s==0){
                                            $data.="borderColor: \"rgb(255, 99, 132)\",\n";
                                        }elseif($s==500){
                                            $data.="borderColor: \"rgb(255, 99, 132)\",\n";
                                        }elseif($s>=300 && $s<400){
                                            $data.="borderColor: \"rgb(255, 205, 86)\",\n";
                                        }elseif($s>=400 && $s<500){
                                            $data.="borderColor: \"rgb(153, 102, 255)\",\n";
                                        }else{
                                            $data.="borderColor: \"rgb(255, 159, 64)\",\n";
                                        }
                                        $data.="},\n";
                                    }

                                    ?>
                                    var myChart{{$m->id}} = new Chart("myChart{{$m->id}}", {
                                        type: 'line',
                                        data: {
                                            datasets: [
                                                <?php print($data);?>
                                            ]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    title: {
                                                        display: true,
                                                        text: 'Seconds'
                                                    }
                                                }
                                            },
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Status over time'
                                                }
                                            }
                                        },
                                    });

                                </script>

                            <p>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
