@extends('admin::layouts.master')
@section('content')
  <!-- Preloader -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{isset($page_title) ? $page_title:''}}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-12 col-12">


          <div class="card card-default">

          <!-- /.card-header -->
          <div class="card-body">
            @if(session()->has('success'))
            <p class="alert alert-success text-center">{{session()->get('success')}}</p>
            @endif

            <div class="row">

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Name</label>
                           <h6> {{$data->name}} </h6>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label>Price</label>
                        <h6>₹ {{$data->price}}</h6>
                    </div>
                </div>
                <div class="col-sm-12" id="deadSimpleLightbox">
                    <div class="mb-3">
                        <label>Images</label><br>
                        @foreach(explode(',',$data->images) as $row)
                            <img src="{{ asset(str_replace('public/', '', $row)) }}" style="width:100x;height:100px;">
                        @endforeach
                    </div>
                </div>

            </div>


          </div>

        </div>




          </div>
          <!-- ./col -->


        </div>


      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @include('admin::layouts.scripts')
  @endsection
