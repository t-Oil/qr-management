@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h3>สร้าง QR Code</h3>
                <div class="row">
                    <div class="col-md-12">
                        <form action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ทะเบียนรถ</label>
                                        <input type="text" class="form-control" name="vehicle_registration">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ทะเบียนพ่วง</label>
                                        <input type="text" class="form-control" name="trailer_registration">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>คู่ค้า</label>
                                        <input type="text" class="form-control" value="{{ optional(auth()->user())->partner->name }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>สินค้า</label>
                                        <select class="form-control" name="product">
                                            <option value="">เลือกสินค้า</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->code }}
                                                    - {{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>แผนก</label>
                                        <select class="form-control" name="department">
                                            <option value="">เลือกแผนก</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->code }}
                                                    - {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>เลขบัตรประชาชน</label>
                                        <input type="text" class="form-control" name="id_card">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>คำนำหน้า</label>
                                        <select class="form-control" name="prefix">
                                            <option value="1">นาย</option>
                                            <option value="2">นาง</option>
                                            <option value="3">นางสาว</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>ชื่อ</label>
                                        <input type="text" class="form-control" name="first_name">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>นามสกุล</label>
                                        <input type="text" class="form-control" name="last_name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col text-center">
                                    <button type="button" class="btn btn-primary">สร้าง QR Code</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
