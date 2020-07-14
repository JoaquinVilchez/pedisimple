<small><p>Este producto puede tener como máximo {{$product->maximum_variants}} variantes.</p></small>
<hr class="mt-0 mb-2">
<div class="d-flex flex-wrap">
    @foreach ($variants as $variant)
        <span class="btn btn-sm btn-checkbox m-1">{{$variant->name}}</span>    
    @endforeach
</div>