@extends('layouts.admin.app')

@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="col-md-4">ID</td>
                            <td class="col-md-4">Name</td>
                            <td class="col-md-4">Email</td>
                            <td class="col-md-4">Roles</td>
                        </tr>
                    </tbody>
                    <tbody>
                    <tr>
                        <td>{{ $school->id }}</td>
                        <td>{{ $school->name }}</td>
                        <td>{{ $school->email }}</td>
                        <td>
                            {{ $school->roles()->get()->implode('name', ', ') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection
