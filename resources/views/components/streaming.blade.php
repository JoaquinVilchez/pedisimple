<audio id='stream' controls style='display:none'><source src="https://streaming.escuchanosonline.com/8444/stream" type='audio/mpeg'></audio>

<div id="masfm" class="d-flex align-items-center justify-content-between">
    <img src="{{asset('storage/masfm/logo.jpg')}}" alt="Radio FM Mas 92.7">
    <p class="text">¡Escuchanos en vivo!</p>
    <a href="#" id="play-button" onclick="controlAction()"><i class="far fa-play-circle"></i></a>
</div>

@section('css-scripts')
<style>
  #masfm{
    background-color:#000;
    margin-bottom: 1.5em;
    border-radius: 5px;
  }
  #masfm img{
    margin: 0 1.5em;
    width: 4em;
    height: 4em;
  }
  #masfm .text{
    color: #FFF;
    text-transform: uppercase;
    font-size: 1.5em;
    font-family: "Poppins";
    font-weight: 800;
    margin: 0;
  }
  #masfm #play-button{
    color: #FFF;
    font-size: 2em;
    margin: 0 1.5em;
  }
  @media (max-width: 990px) {
    #masfm{
      width: 100%;
    }
    }#masfm .text{
      font-size: 1em;
    }
  }
</style>
@endsection

@section('js-scripts')
<script>
 function controlAction(){
  const player = document.getElementById('stream')
  const controls = document.getElementById('play-button')
  if(!player.paused){
    controls.innerHTML = '<i class="far fa-play-circle"></i>'
    player.pause()

  }else{
    player.play()
    controls.innerHTML = '<i class="far fa-pause-circle"></i>'
  }
 }
</script>
@endsection