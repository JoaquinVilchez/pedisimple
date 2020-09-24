<div class="row">
    <div class="col-4">
        <img src="{{asset('storage/uploads/user/'.$user->image)}}" class="img-thumbnail float-right" width="75px">
    </div>
    <div class="col-8">
        <h5>{{$user->fullName()}}</h5>
        <small><a href="tel:{{$user->getPhone()}}" target="_blank"><p class="mb-0"><i class="fas fa-phone"></i> {{$user->getPhone()}}</p></a></small>
    <small><a href="mailto:{{$user->email}}" target="_blank"><p class="mb-0"><i class="far fa-envelope"></i> {{$user->email}}</p></a></small>
    </div>
</div>
  <hr>
<div class="row">
    <div class="col-4">
        <img src="{{asset('storage/uploads/commerce/'.$user->restaurant->image)}}" class="img-thumbnail float-right" width="75px">
    </div>
    <div class="col-8">
        <div>
            <h5 class="d-inline">{{$user->restaurant->name}}</h5>
            <small class="d-inline ml-1"><span class="{{$user->restaurant->stateStyle()}}">{{$user->restaurant->translateState()}}</span></small>
        </div>
        <small><a href="tel:{{$user->getPhone()}}" target="_blank"><p class="mb-0"><i class="fas fa-phone"></i> {{$user->restaurant->getPhone()}}</p></a></small>
        <small><p class="mb-0"><i class="fas fa-map-marker-alt"></i> {{$user->restaurant->address->getAddress()}}</p></small>
    </div>
</div>  
<hr>
<div class="card">
    <div class="card-body p-0">
        <small><p class="my-0"> <span class="txt-muted">(Test) Última facturacion:</span> 01/09/2020</p></small>
        <small><p class="my-0"> <span class="txt-muted">(Test) Facturas impagas:</span> 0</p></small>
        <small><p class="my-0"> <span class="txt-muted">(Test) Cliente desde:</span> Hace 2 meses</p></small>
    </div>
</div>