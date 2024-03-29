@extends('frontend.user.index')
@section('title','E-SHOP || USER')

@section('main-content')



 <!-- DataTales Example -->
 <div class="container">
    <div class="row">
        <div class="col-12 col-xl-2 col-lg-2 col-md-12 section section">
            @include('frontend.user.leftside.menu')

        </div>
        <div class="col-12 col-xl-10 col-lg-10 col-md-12 section section">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    @if(count($orders)>0)
                    <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
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
                        @foreach($orders as $order)  
                        @php
                            $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
                        @endphp  
                            <tr>
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
                                    <a href="{{route('user.order.show',$order->id)}}" class="btn" style="color:#fff" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fa fa-eye"></i></a>
                                    <form method="POST" action="{{route('user.order.delete',[$order->id])}}">
                                    @csrf 
                                    @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>  
                        @endforeach
                    </tbody>
                    </table>
                    <span style="float:right">{{$orders->links()}}</span>
                    @else
                    <h6 class="text-center">No orders found!!! Please order some products</h6>
                    @endif
                </div>
                </div>
            </div>

        </div>

    </div>
 </div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }

    .btn {
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 50%;
    }

        /* Darker background on mouse-over */
    /* .btn:hover {
        background-color: RoyalBlue;
    } */

  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[8]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush