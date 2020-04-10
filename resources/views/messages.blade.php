@if (session('success_message'))
<div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
    <strong>{{session('success_message') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session('error_message'))
<div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
    <strong>{{session('error_message') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (session('alert_message'))
<div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
    <strong>{{session('alert_message') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif