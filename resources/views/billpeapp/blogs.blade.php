@extends('billpeapp.layout.app')

@section('content')

<div class="first_nav_hero_about">
    <!-- ======== 1.1. header section ======== -->
    @include('billpeapp/layout/header')
    <!-- ======== End of 1.1. header section ========  -->
            <!-- ======== 9.1. Blogs cards section ========  -->
    <section class="news-cards">
    <div class="container">
        <h2 class="text-center news-h2">OUR LATEST NEWS & EVENTS</h2>
        
        <div class="row d-flex gap-md-0 gap-sm-5 gap-4 mb-5">
            @foreach($blogs as $blog)
            <div class="col-lg-4 col-md-4 d-flex" data-aos="flip-right">
                <div class="card news-card-back">
                    <img src="{{$blog->blog_image}}" alt="card-img">
                    <div class="card-body">
                        <a href="#">
                            <h5>{{$blog->title}} - {{$blog->meta_title}}</h5>
                        </a>
                        <p class="card-text p-f-s">{{$blog->meta_description}}</p>
                    </div>
                    <hr class="dotted-line">
                    <div class="card-viewer d-flex justify-content-between ">
                        <div>
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>2023/06/12</span>
                        </div>
                        <div>
                            <i class="fa-regular fa-message"></i>
                            <span>0</span>
                        </div>
                    </div>
                    <div class="news-link">
                        <a class="btn-hover1" href="#">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </section>
    <!-- ======== End of 9.1. Blogs cards section ========  -->
</div>

@endsection