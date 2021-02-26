@extends('frontend.user.index')
@section('title','E-SHOP || USER')

@section('title','Comment Edit')

@section('main-content')

<div class="container">
  <div class="row">
      <div class="col-12 col-xl-2 col-lg-2 col-md-12 section section">
          @include('frontend.user.leftside.menu')

      </div>
      <div class="col-12 col-xl-10 col-lg-10 col-md-12 section section">
        <div class="card">
          <h5 class="card-header">Comment Edit</h5>
          <div class="card-body">
            <form action="{{route('user.post-comment.update',$comment->id)}}" method="POST">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="name">By:</label>
                <input type="text" disabled class="form-control" value="{{$comment->user_info->name}}">
              </div>
              <div class="form-group">
                <label for="comment">comment</label>
              <textarea name="comment" id="" cols="20" rows="10" class="form-control">{{$comment->comment}}</textarea>
              </div>
              <div class="form-group">
                <label for="status">Status :</label><br/>
                <select name="status" id="" class="form-control">
                  <option value="">--Select Status--</option>
                  <option value="active" {{(($comment->status=='active')? 'selected' : '')}}>Active</option>
                  <option value="inactive" {{(($comment->status=='inactive')? 'selected' : '')}}>Inactive</option>
                </select><br/>
              </div><br/>
              <button type="submit" class="btn btn-primary">Update</button>
            </form>
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
</style>
@endpush