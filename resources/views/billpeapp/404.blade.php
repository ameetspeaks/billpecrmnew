@extends('billpeapp.layout.app')

@section('content')
<div class="site-wrapper bg404">
    <!-- ======== 10.1. ooops section ======== -->
    <section>
        <div class="container">
            <div class="hero404" data-aos="zoom-in">
                <h2 class="text-center">OOOPS...</h2>
                <h2 class="text-center">PAGE NOT FOUND</h2>
                <h4>ERROR 404</h4>
                <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere dolor voluptatum dolores
                    veritatis provident
                    reiciendis doloremque non autem soluta qui? Repudiandae, vel.</p>
                <a class="btn-hover1" href="{{route('index')}}">Back to Home</a>
            </div>
        </div>
    </section>
    <!-- ======== End of 10.1. ooops section ======== -->
    <!-- ======== End of 10.2. footer404 section ======== -->
    <div class="footor404">
        <div class="d-flex align-items-center justify-content-center gap-4">
            <a href="#"> <i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"> <i class="fa-brands fa-twitter"></i></a>
            <a href="#"> <i class="fa-brands fa-instagram"></i></a>
        </div>
        <p class="text-center">Copyright © 2023 Paypath by Evonicmedia. All Right Reserved.</p>
    </div>
</div>
@endsection