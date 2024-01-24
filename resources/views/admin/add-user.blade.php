@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include('components.alert')


                <!-- Row start -->
                <div class="row">
                    <div class="col-sm-12 col-12">

                        <!-- Card start -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Add User</div>
                            </div>
                            <div class="card-body">

                                <!-- Row start -->
                                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-sm-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" id="" class="form-control">
                                                    <option value="">-- Choose Role --</option>
                                                    <option value="bank">Bank</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="kantin">Kantin</option>
                                                    <option value="siswa">Siswa</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-actions-footer">
                                                <a href="{{ route('home') }}" class="btn btn-light">Cancel</a>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Row end -->
                            </div>
                        </div>
                        <!-- Card end -->
                    </div>
                </div>
                <!-- Row end -->
            </div>
        </div>
    </div>
@endsection
