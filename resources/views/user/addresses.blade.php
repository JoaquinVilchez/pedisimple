@extends('layouts.user')

@section('info-content')

    <h5>Mis direcciones @if(count($addresses)>0)<small>({{count($addresses)}})</small>@endif</h5>
            @if(count($addresses)>0)
            <table class="table table-hover">
                <tbody>
                @foreach($addresses as $address)
                <tr>
                    <td>{{$address->getFullAddress()}}</td>
                    <td><a href="#" data-addressid="{{$address->id}}" data-toggle="modal" data-target="#deleteAddressModal"><i class="fas fa-trash-alt"></i></a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <p class="ml-3">Aún no tienes direcciones</p>
            @endif
    <a href="#" data-toggle="modal" data-target="#addAddressModal">+ Agregar dirección</a>


    <!-- Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Agregar dirección</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{route('address.store')}}" method="POST">
                    @csrf
                    
                    <div class="form-group form-row">
                        <div class="col-7">
                        <input type="text" name="street" class="form-control" placeholder="Calle">
                        </div>
                        <div class="col">
                        <input type="text" name="number" class="form-control" placeholder="Número">
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-3">
                        <input type="text" name="floor" class="form-control" placeholder="Piso">
                        <small class="text-muted ml-1">Opcional</small>
                        </div>
                        <div class="col-3">
                        <input type="text" name="department" class="form-control" placeholder="Depto">
                        <small class="text-muted ml-1">Opcional</small>
                        </div>
                        <div class="col">
                            <input type="text" name="building_name" class="form-control" placeholder="Nombre edificio">
                            <small class="text-muted ml-1">Opcional</small>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col">
                            <select type="text" name="cityId" class="form-control" placeholder="Zip">
                                <option value="1" selected>Venado Tuerto</option>
                                <option value="2">Rufino</option>
                            </select>
                        </div>
                    </div>
                      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar dirección</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <form action="{{route('address.destroy', $address)}}" method="POST">
                    @method('DELETE')
                    @csrf

            <div class="modal-body">
                    <h5>¿Estás seguro de eliminar esta dirección?</h5>  
                    <input type="hidden" id="addressid" name="addressid" value="">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('js-scripts')
<script>
    $('#deleteAddressModal').on('show.bs.modal', function(event){
      var button = $(event.relatedTarget)

      var addressid = button.data('addressid')
      var modal = $(this)

      modal.find('.modal-body #addressid').val(addressid)
    })
</script>
@endsection