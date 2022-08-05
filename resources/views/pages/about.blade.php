@extends('layouts.app')

@section('title')
    Store About
@endsection

@section('content')
<div class="page-content page-home">
  <section class="store-carousel">
    <div class="container">
      <div class="row">
        <div class="col-lg-12" data-aos="zoom-in">
          <div id="storeCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li class="active" data-target="#storeCarousel" data-slide-to="0"></li>
              <li data-target="#storeCarousel" data-slide-to="1"></li>
              <li data-target="#storeCarousel" data-slide-to="2"></li>
            </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="/images/about1.jpg" alt="carousel image" class="d-block w-100" />
                </div>
                <div class="carousel-item">
                  <img src="/images/about2.jpg" alt="carousel image" class="d-block w-100" />
                </div>
                <div class="carousel-item">
                  <img src="/images/about3.jpg" alt="carousel image" class="d-block w-100" />
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
      <div class="container-fluid page-header mb-5 wow fadeIn">
        <div class="container">
          <div class="row g-5 align-items-center">
            <div class="" data-aos="zoom-in">
              <p></p>
              <p></p>
              <h1 class="display-5 mb-4">ECOLIV Indonesia</h1>
              <p>
                Ecoliv Indonesia adalah usaha yang bergerak pada bidang lingkungan. Ecoliv meiliki tujuan yaitu dengan mempromosikan hidup dengan prinsip zero waste atau tidak membuang secara percuma namun, barang-barang yang dijual disini
                memiliki banyak keuntungan dan tidak memperbanyak sampah di Bumi.
              </p>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection