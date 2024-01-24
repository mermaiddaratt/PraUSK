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
                                <div class="card-title">Add Product</div>
                            </div>
                            <div class="card-body">

                                <!-- Row start -->
                                <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-sm-12 col-lg-5">
                                            <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input type="number" class="form-control" name="price">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label">Stock</label>
                                                <input type="number" class="form-control" name="stock">
                                            </div>
                                        </div>



                                        <div class="col-sm-12 col-lg-5">
                                            <div class="mb-3">
                                                <label class="form-label">Photo</label>
                                                <input type="text" class="form-control" name="photo">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-7">
                                            <div class="mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea class="form-control" placeholder="Enter Desc" name="description" rows="3"></textarea>
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
