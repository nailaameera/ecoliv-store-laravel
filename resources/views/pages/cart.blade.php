@extends('layouts.app')

@section('title')
    Store Cart Page
@endsection

@section('content')
<div class="page-content page-cart">
  <section class="store-breadcrumbs">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
              </li>
              <li class="breadcrumb-item active">Cart</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <section class="store-cart">
    <div class="container">
      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-12 table-responsive">
          <table class="table table-borderless table-cart">
            <thead>
              <tr>
                <td>Image</td>
                <td>Product Name</td>
                <td>Price</td>
                <td><menu></menu></td>
              </tr>
            </thead>
            <tbody>
              @php
                  $totalPrice = 0
              @endphp
              @foreach ($carts as $cart)
                <tr>
                  <td style="width: 25%">
                    @if ($cart->product->galleries)
                      <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" 
                      alt="" 
                      class="cart-image" />
                    @endif
                  </td>
                  <td style="width: 35%">
                    <div class="product-title">{{ $cart->product->name}}</div>
                    <div class="product-subtitle"></div>
                  </td>
                  <td style="width: 35%">
                    <div class="product-title">{{ number_format($cart->product->price) }}</div>
                    <div class="product-subtitle">Rp.</div>
                  </td>
                  <td style="width: 20%">
                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                      @method('DELETE')
                      @csrf
                      <button type="submit" class="btn btn-remove-cart">Remove</button>
                    </form>
                  </td>
                </tr>
                @php
                    $totalPrice += $cart->product->price
                @endphp
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row" data-aos="fade-up" data-aos-delay="150">
        <div class="col-12">
          <hr/>
        </div>
        <div class="col-12">
          <h2 class="mb-4">Shipping Details</h2>
        </div>
      </div>
      <form action="{{ route('checkout') }}" id="locations" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
          <div class="col-md-6">
            <div class="form-group">
              <label for="address_one">Address 1</label>
              <input type="text" class="form-control" id="address_one" name="address_one" value="" required/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="address_two">Address 2</label>
              <input type="text" class="form-control" id="address_two" name="address_two" value="" required/>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="provinces_id">Province</label>
              <select name="provinces_id" id="provinces_id" class="form-control" v-if="provinces" v-model="provinces_id">
                <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
              </select>
              <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                <label for="regencies_id">City</label>
                <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id" v-if="regencies">
                  <option v-for="regency in regencies" :value="regency.id">@{{regency.name }}</option>
                </select>
                <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="zip_code">Postal Code</label>
              <input type="text" class="form-control" id="zip_code" name="zip_code" value="" required/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" value="Indonesia"/>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="phone_number">Mobile</label>
              <input type="text" class="form-control" id="phone_number" name="phone_number" value="" required/>
            </div>
          </div>
        </div>
          <div class="row" data-aos="fade-up" data-aos-delay="150">
            <div class="col-12">
              <hr />
            </div>
            <div class="col-12">
              <h2 class="mb-1">Payment Informations</h2>
            </div>
          </div>
          <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col-4 col-md-3">
              <div class="product-title">Rp. {{ number_format($insurance_price =2000) }}</div>
              <div class="product-subtitle">Asuransi Produk</div>
            </div>
            <div class="col-4 col-md-2">
              <div class="product-title">Rp. {{ number_format($shipping_price =10000) }}</div>
              <div class="product-subtitle">Ongkos Kirim</div>
            </div>
            <div class="col-4 col-md-2">
              <div class="product-title text-success">Rp. {{ number_format($totalPrice = $totalPrice+$shipping_price+$insurance_price ?? 0) }}</div>
              <div class="product-subtitle">Total</div>
              <input type="hidden" id="totalPrice" name="total_price" value="{{$totalPrice}}">
              <input type="hidden" id="totalPay" name="total_pay" value="{{$totalPrice}}">
            </div>
            <div class="col-8 col-md-3">
              <button type="submit" class="btn btn-success mt-4 px-4 btn-block"> Checkout Now </button>
            </div>
          </div>
      </form>
    </div>
  </section>
</div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      var locations = new Vue({
        el: "#locations",
        mounted() {
          AOS.init();
          this.getProvincesData();
        },
        data: {
          provinces: null,
          regencies: null,
          provinces_id: null,
          regencies_id: null
        },
        methods: {
          getProvincesData () {
            var self = this;
            axios.get('{{ route ('api-provinces') }}')
              .then(function(response){
                self.provinces = response.data;
              })
          },
          getRegenciesData (){
            var self = this;
            axios.get('{{ url ('api/regencies') }}/' + self.provinces_id)
              .then(function(response){
                self.regencies = response.data;
              })
          },
          getCostService(){
            document.getElementById('totalPrice').value = $totalPrice+$shipping_price+$insurance_price;
            document.getElementById('totalPrice').value = $totalPayment;
          },
        },
        watch: {
          provinces_id: function(val, oldVal) {
            this.regencies_id = null;
            this.getRegenciesData();
          }
        }
      });
    </script>
@endpush