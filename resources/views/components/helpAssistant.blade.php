<div class="help-button-wrapper">
    <ul class="help-list">
      <li>
        <p class="text-danger">¿Necesitas ayuda?</p>
        <hr class="m-0">
      </li>
      <li><span id="start-tour"><a target=”_autoblank” href="https://wa.me/549{{str_replace('-', '', env('APP_NUMBER'))}}">Hablar con un asesor</a></span></li>
    </ul>
    <button type="button" class="help-button">
      <span>
        <i class="fas fa-user-tie"></i>
      </span>
    </button>
</div>

<script>
    $(".help-button").on("click", function() {
      $(".help-button-wrapper").toggleClass("expanded");
    });

    $(document).on("click", function(event) {
      if (!$(event.target).closest(".help-button").length) {
        $(".help-button-wrapper").removeClass("expanded");
      }
    });
</script>