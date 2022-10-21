
<div id="carousel-header" class="carousel slide" data-ride="carousel">

  <div class="carousel-inner">
      @foreach($slides as $key => $slide)
    <div class="carousel-item {{ $key === 0 ? "active": ""}}">
      <img src="{{asset('assets/images/'.$slide->bg_image)}}" class="d-block w-100" alt="...">

    </div>
    @endforeach
    {{-- <div class="carousel-item">
      <img src="{{asset('storage/uploads/'.$slide->bg_image)}}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{asset('storage/uploads/'.$slide->bg_image)}}" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div> --}}
  </div>

</div>
<!-- End of slider section
============================================= -->
