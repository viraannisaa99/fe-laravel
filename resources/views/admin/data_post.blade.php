@extends('admin.base')
@section('content')
    <!-- Content Row -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Product</h1>
        <a href="{{ route('posts.create') }}"><button type="button" class="btn ml-3 btn-success btn-sm"><i class="fa fa-plus fa-fw"></i> Tambah Data</button></a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="d-flex justify-content-end">
            </h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Nama Product</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['data'] as $item)
                        <tr>
                            <th scope="row">{{ $item['id'] }}</th>
                            <td style="max-width: 100px">
                                @if ($item['image'])
                                    <img src="{{ env('API_BACKEND') . '/storage/posts/' . $item['image'] }}" class="img-fluid">
                                @else
                                    <small class="text-muted">Tidak ada gambar</small>
                                @endif
                            </td>
                            <td style="max-width: 150px">{{ $item['title'] }}</td>
                            <td style="max-width: 250px">{{ $item['content'] }}</td>
                            <td>{{ $item['author'] }}</td>
                            <td>{{ $item['post_date'] }}</td>
                            <td>
                                <a href="{{ route('posts.edit', $item['id']) }}" class="d-inline">
                                    <button class="btn btn-sm btn-icon">
                                        <i class="fa fa-edit fa-fw text-warning"></i>
                                    </button>
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $item['id']) }}" class="d-inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="id" class="form-control" value="{{ $item['id'] }}">

                                    <button class="btn btn-sm btn-icon" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa fa-trash fa-fw text-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
