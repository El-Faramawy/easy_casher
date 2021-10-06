<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="card">
        @php
            $sliders = App\Models\Slider::all();
        @endphp
        @if ($sliders->count()>0)
            <div class="card-header">
                <div class="card-title">كل صور البانر</div>
            </div>
            <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($sliders as $slider)
                            <div class="carousel-item {{$loop->first?'active':''}}">
                                <img src="{{get_file($slider->image)}}" class="rounded d-block w-100" alt="Carousel">
                            </div>
                        @endforeach

                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            @else
            <div class="card-header">
                <div class="card-title">لا يوجد صور لعرضها</div>
            </div>
        @endif

    </div>
</div>
