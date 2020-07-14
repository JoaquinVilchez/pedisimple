<h4>{{$product}}</h4>
<hr>
<div class="d-flex flex-wrap">
    @foreach ($variants as $variant)
        <span class="btn btn-sm btn-checkbox m-1">{{$variant->name}}</span>    
    @endforeach
</div>
@if ($aditional_notes!=null)
    <div>
        <hr>
        <p class="mt-2">Nota adicional: <br>
        <span class="text-muted ml-2">{{$aditional_notes}}</span></p>
    </div>
@endif