@extends('admin.base')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Product</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="mt-3">
                <div class="card mt-2">
                    <form class="m-3" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Title :</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Content :</label>
                            <input type="text" name="content" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Author :</label>
                            <input type="text" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Post Date :</label>
                            <input type="date" name="post_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Image :</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="float-right btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
