@extends('layouts.app')

@section('content')
<style>

</style>

<script>
var botmanWidget = {
    frameEndpoint: '/hci/botman/chat',
    chatServer: '/hci/botman',
    bubbleAvatarUrl: '{{ env('APP_URL') }}/img/bot.png',
    aboutText: 'Write Something',
    introMessage: "✋ Hi!",
    title:"Mehnitoring bot"
};
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

@if(Session::has('success'))
    <script type="text/javascript">
     swal({
         title:'Success!',
         text:"{{Session::get('success')}}",
         timer:5000,
         type:'success'
     }).then((value) => {
       //location.reload();
     }).catch(swal.noop);
    </script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" integrity="sha512-24XP4a9KVoIinPFUbcnjIjAjtS59PUoxQj3GNVpWc86bCqPuy3YxAcxJrxFCxXe4GHtAumCbO2Ze2bddtuxaRw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Button trigger modal -->
            <div class="row">
                <div class="col-sm-10" style="padding:2px;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i data-feather="plus"></i> Add monitor
                    </button>
                </div>
                <div class="col-sm-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Data points to show
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @for ($i = 1; $i < 10; $i++)
                            <li><a class="dropdown-item" href="{{route('home')}}?n={{ $i*20}}">{{ $i *20}}</a></li>
                        @endfor

                        </ul>
                    </div>
                </div>
            </div>
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
                                <div class="card-header">
                                <div class="btn-group">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i data-feather="bar-chart"></i> Host: {{$m->host}} - Port: {{$m->port}}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" onClick="fMonitorDel({{$m->id}})">
                                                <i data-feather="trash-2"></i> Delete monitor
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <div class="pie-chart-container">
                                            <canvas id="myChart{{$m->id}}" style="width:100%; height:250px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>

                                    //get the pie chart canvas
                                    <?php
                                    $n=10;
                                    if(isset($_GET['n'])){
                                        $n=(int)$_GET['n'];
                                        if($n==0){
                                            $n=10;
                                        }
                                    }

                                    $data="";
                                    $statuses=[];
                                    foreach($m->tics->take($n) as $t){
                                        if(!in_array($t->status, $statuses)){
                                            array_push($statuses,$t->status);
                                        }
                                    }
                                    foreach($statuses as $s){
                                        $data.="{ \n label: '$s',\n data: [";
                                        $flag=0;
                                        foreach($m->tics->take($n) as $t){
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
<script>
    feather.replace();
    function fMonitorDel(id){
        if (confirm("Are you sure you want to delete this monitor?") == true) {
            $("#monitor_id").val(id);
            $("#frmMonitorDestroy").submit();
        }
    }
</script>
<form method="POST" action="{{route('monitors.destroy')}}" id="frmMonitorDestroy">
    @method('DELETE')
    {{csrf_field()}}
    <input type="hidden" name="mid" id="monitor_id">
</form>

@endsection
