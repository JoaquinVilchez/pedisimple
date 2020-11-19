@extends('layouts.app')

@section('content')

<div class="container-fluid overflow">
  <div class="row">
    <main role="main" class="col-auto ml-sm-auto col-12 pt-1">
      @yield('main')
      @include('components.helpAssistant')
    </main>
  </div>
</div>

<script>

  $(window).on('load',function(){
      $('#updatePricesModal').modal('show');
  });

  var url = window.location.pathname;
  const parts = url.split('/');
  var activeCategory = parts[1];
  var activePage = parts[2];

  function markReadNotification(){
    $.ajax({
      url : '{{ route("updatePrices.readNotification") }}',
      type: 'POST',
      headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success:function(){
          $('#updatePricesModal').modal('hide');
      },
    });
  }

  document.getElementById(activeCategory+'Collapse').classList.add("show")
  document.getElementById(activePage).classList.add("active")
</script>

@endsection





