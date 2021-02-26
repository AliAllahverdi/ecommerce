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
            <div class="row">
                <div class="col-md-12">
                   @include('backend.layouts.notification')
                </div>
            </div>
           <div class="card-header py-3">
             <h6 class="m-0 font-weight-bold text-primary float-left">Comment Lists</h6>
           </div>
           <div class="card-body">
             <div class="table-responsive">
               @if(count($comments)>0)
               <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                 <thead>
                   <tr>
                     <th>S.N.</th>
                     <th>Author</th>
                     <th>Post Title</th>
                     <th>Message</th>
                     <th>Date</th>
                     <th>Status</th>
                     <th>Action</th>
                   </tr>
                 </thead>
                 <tfoot>
                   <tr>
                     <th>S.N.</th>
                     <th>Author</th>
                     <th>Post Title</th>
                     <th>Message</th>
                     <th>Date</th>
                     <th>Status</th>
                     <th>Action</th>
                   </tr>
                 </tfoot>
                 <tbody>
                   @foreach($comments as $comment)
                   {{-- {{$comment}}   --}}
                     @php 
                     $title=DB::table('posts')->select('title')->where('id',$comment->post_id)->get();
                     @endphp
                       <tr>
                           <td>{{$comment->id}}</td>
                           <td>{{$comment->user_info['name']}}</td>
                           <td>@foreach($title as $data){{ $data->title}} @endforeach</td>
                           <td>{{$comment->comment}}</td>
                           <td>{{$comment->created_at->format('M d D, Y g: i a')}}</td>
                           <td>
                               @if($comment->status=='active')
                                 <span class="badge badge-success">{{$comment->status}}</span>
                               @else
                                 <span class="badge badge-warning">{{$comment->status}}</span>
                               @endif
                           </td>
                           <td>
                               <a href="{{route('user.post-comment.edit',$comment->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="color:#fff" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fa fa-edit"></i></a>
                               <form method="POST" action="{{route('user.post-comment.delete',[$comment->id])}}">
                                 @csrf 
                                 @method('delete')
                                     <button class="btn btn-danger btn-sm dltBtn" data-id={{$comment->id}}  data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>
                               </form>
                           </td>
                       </tr>  
                   @endforeach
                 </tbody>
               </table>
               <span style="float:right">{{$comments->links()}}</span>
               @else
                 <h6 class="text-center">No post comments found!!!</h6>
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
                    "targets":[5,6]
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