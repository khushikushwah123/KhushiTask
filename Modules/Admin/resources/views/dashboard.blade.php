@extends('admin::layouts.master')
@section('content')
    <main>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $page_title }}</h1>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                    </div>
                </div>
            </section>
    </main>
    @include('admin::layouts.scripts')
@endsection
