@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($professors)
        <div class="box">
            <div class="box-body">
                <h2>Professors</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <td class="col-md-1">ID</td>
                            <td class="col-md-3">Name</td>
                            <td class="col-md-3">Email</td>
         
                            <td class="col-md-4">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($professors as $professor)
                        <tr>
                            <td>{{ $professor->id }}</td>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->email }}</td>
                     
                            <td>
                                <form action="{{ route('admin.professors.destroy', $professor->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.professors.show', $professor->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                        <a href="{{ route('admin.professors.edit', $professor->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $professors->links() }}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
