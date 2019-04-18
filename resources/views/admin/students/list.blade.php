@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        @include('layouts.errors-and-messages')
        <!-- Default box -->
        @if($students)
        <div class="box">
            <div class="box-body">
                <h2>Students</h2>
                <table class="table">
                    <thead>
                        <tr>
                            @if(!$professor)
                                <td class="col-md-1">Professor</td>
                            @endif
                            <td class="col-md-3">Name</td>
                            <td class="col-md-3">Email</td>
                            <td class="col-md-1">Status</td>
                            <td class="col-md-4">Actions</td>
                            
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            @if(!$professor)
                            <td>{{ $student->professor['name'] }}</td>
                            @endif
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>@include('layouts.status', ['status' => $student->status])</td>
                            <td>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i> Show</a>
                                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $students->links() }}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        @endif

    </section>
    <!-- /.content -->
@endsection
