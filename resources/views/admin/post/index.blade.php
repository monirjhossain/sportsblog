@extends('layouts.backend.app') 
@section('title','Post');
@push('header')
    <link rel="stylesheet" href="{{ asset('backend') }}/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

@endpush
@section('content')
    <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Posts</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ url('admin/post') }}" class="active">Post List</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                <div class="alert  alert-success alert-dismissible fade show" role="alert">
                                     <span class="badge badge-pill badge-success">Success</span> {{ $error }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                    @endforeach
                            </div>
                        @endif
                        
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Post Table</strong>
                                <a href="{{ route('admin.post.create') }}" class="btn btn-success"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="card-body">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @foreach ($posts as $key=> $post)
                                    <tbody>
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->slug }}</td>
                                            <td>{{ $post->name }}</td>
                                            <td><img src="{{ asset('storage/post/'. $post->image) }}" alt="{{ $post->name }}" height="60px" width="90px"></td>
                                            <td>
                                                <a href="{{ route('admin.post.show', $post->id) }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $post->id }}">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
            <div class="animated">
               @foreach ($posts as $post)
               <div class="modal fade" id="deleteModal-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" data-backdrop="static" style="display: none;" aria-hidden="true">
                   <div class="modal-dialog modal-sm" role="document">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title" id="staticModalLabel">Delete post!</h5>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">×</span>
                               </button>
                           </div>
                           <div class="modal-body">
                               <p>
                                   Do you want to delete post?
                               </p>
                           </div>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                               <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                               document.getElementById('deletepost-{{ $post->id }}').submit();">Confirm</button>
                               <form action="{{ route('admin.post.destroy', $post->id) }}" style="display:none" id="deletepost-{{ $post->id }}" method="POST">
                               @csrf
                               @method('DELETE')
                               </form>
                           </div>
                       </div>
                   </div>
               </div>
               @endforeach
            </div>
        </div><!-- .content -->
    </div>
   
@endsection

@push('footer')
    <script src="{{ asset('backend') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend') }}/vendors/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/init-scripts/data-table/datatables-init.js"></script>

    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
        {!! Toastr::message() !!}

@endpush
