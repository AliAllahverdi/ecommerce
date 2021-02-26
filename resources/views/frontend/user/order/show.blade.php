@extends('frontend.user.index')

@section('title','Order Detail')

@section('main-content')

<div class="container">
    <div class="row">
        <div class="col-12 col-xl-2 col-lg-2 col-md-12 section section">
            @include('frontend.user.leftside.menu')

        </div>
        <div class="col-12 col-xl-10 col-lg-10 col-md-12 section section">
          <div class="card">
          <h5 class="card-header">Order<a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fa fa-download fa-sm text-white-50"></i> Generate PDF</a>
            </h5>
            <div class="card-body">
              @if($order)
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                      <th>S.N.</th>
                      <th>Order No.</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Quantity</th>
                      <th>Charge</th>
                      <th>Total Amount</th>
                      <th>Status</th>
                      <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      @php
                          $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
                      @endphp 
                      <td>{{$order->id}}</td>
                      <td>{{$order->order_number}}</td>
                      <td>{{$order->first_name}} {{$order->last_name}}</td>
                      <td>{{$order->email}}</td>
                      <td>{{$order->quantity}}</td>
                      <td>@foreach($shipping_charge as $data) $ {{number_format($data,2)}} @endforeach</td>
                      <td>${{number_format($order->total_amount,2)}}</td>
                      <td>
                          @if($order->status=='new')
                            <span class="badge badge-primary">{{$order->status}}</span>
                          @elseif($order->status=='process')
                            <span class="badge badge-warning">{{$order->status}}</span>
                          @elseif($order->status=='delivered')
                            <span class="badge badge-success">{{$order->status}}</span>
                          @else
                            <span class="badge badge-danger">{{$order->status}}</span>
                          @endif
                      </td>
                      <td>
                          <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                            @csrf 
                            @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>
                          </form>
                      </td>
                    
                  </tr>
                </tbody>
              </table>
          
              <section class="confirmation_part section_padding">
                <div class="order_boxes">
                  <div class="row">
                    <div class="col-lg-6 col-lx-4">
                      <div class="order-info">
                        <h4 class="text-center pb-4">ORDER INFORMATION</h4>
                        <table class="table">
                              <tr class="">
                                  <td>Order Number</td>
                                  <td> : {{$order->order_number}}</td>
                              </tr>
                              <tr>
                                  <td>Order Date</td>
                                  <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                              </tr>
                              <tr>
                                  <td>Quantity</td>
                                  <td> : {{$order->quantity}}</td>
                              </tr>
                              <tr>
                                  <td>Order Status</td>
                                  <td> : {{$order->status}}</td>
                              </tr>
                              <tr>
                                @php
                                    $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
                                @endphp
                                  <td>Shipping Charge</td>
                                  <td> : $ {{ $shipping_charge->count() > 0 ? number_format($shipping_charge[0],2) : ''}}</td>
                              </tr>
                              <tr>
                                  <td>Total Amount</td>
                                  <td> : $ {{number_format($order->total_amount,2)}}</td>
                              </tr>
                              <tr>
                                <td>Payment Method</td>
                                <td> : @if($order->payment_method=='cod') Cash on Delivery @else Paypal @endif</td>
                              </tr>
                              <tr>
                                  <td>Payment Status</td>
                                  <td> : {{$order->payment_status}}</td>
                              </tr>
                        </table>
                      </div>
                    </div>
          
                    <div class="col-lg-6 col-lx-4">
                      <div class="shipping-info">
                        <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
                        <table class="table">
                              <tr class="">
                                  <td>Full Name</td>
                                  <td> : {{$order->first_name}} {{$order->last_name}}</td>
                              </tr>
                              <tr>
                                  <td>Email</td>
                                  <td> : {{$order->email}}</td>
                              </tr>
                              <tr>
                                  <td>Phone No.</td>
                                  <td> : {{$order->phone}}</td>
                              </tr>
                              <tr>
                                  <td>Address</td>
                                  <td> : {{$order->address1}}, {{$order->address2}}</td>
                              </tr>
                              <tr>
                                  <td>Country</td>
                                  <td> : {{$order->country}}</td>
                              </tr>
                              <tr>
                                  <td>Post Code</td>
                                  <td> : {{$order->post_code}}</td>
                              </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              @endif
          
            </div>
          </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

    .btn {
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 50%;
    }

</style>
@endpush