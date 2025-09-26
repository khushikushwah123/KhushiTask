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
            <form method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

              <div class="col-md-6">
               <div class="form-group">
                 <label>Name</label>
                 <input class="form-control" type="text" name="name" value="{{old('name')}}" style="width: 100%;"/>
                 <p style="color: red;">{{$errors->first('name')}}</p>
               </div>
             </div>

              <div class="col-md-6">
               <div class="form-group">
                 <label>Images</label>
                 <input class="form-control" type="file" name="images[]" style="width: 100%;" multiple/>
                 <p style="color: red;">{{$errors->first('images')}}</p>
               </div>
             </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Price</label>
                  <input class="form-control" type="text" name="price" style="width: 100%;" value="{{old('price')}}" />
                  <p style="color: red;">{{$errors->first('price')}}</p>
                </div>
              </div>

            </div>

            <button class="btn btn-outline-info" name="submit" value="submit" type="submit">Submit</button>
            </form>
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
