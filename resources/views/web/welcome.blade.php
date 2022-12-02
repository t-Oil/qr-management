@extends('layouts.app')

@section('content')
    <div class="container" id="task-box">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h3>สร้าง QR Code</h3>
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{(url('task/store'))}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>วันที่<span class="text-danger">*</span></label>
                                        <div class="input-group date" id="task_date" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input"
                                                   name="task_date" data-target="#task_date"
                                                   value="{{ old('task_date') ?? '' }}"/>
                                            <div class="input-group-append" data-target="#task_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                        @error('task_date')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ทะเบียนรถ<span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('vehicle_registration') is-invalid @enderror"
                                            name="vehicle_registration"
                                            value="{{ old('vehicle_registration') ?? '' }}"
                                        >
                                        @error('vehicle_registration')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ทะเบียนพ่วง</label>
                                        <input
                                            type="text"
                                            class="form-control @error('trailer_registration') is-invalid @enderror"
                                            name="trailer_registration"
                                            value="{{ old('trailer_registration') ?? '' }}"
                                        >
                                        @error('trailer_registration')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ประเภทชั่ง<span class="text-danger">*</span></label>
                                        <select class="form-control @error('job_type') is-invalid @enderror"
                                                name="job_type">
                                            <option value="">เลือกประเภทชั่ง</option>
                                            @foreach($jobTypes as $jobType)
                                                <option
                                                    value="{{ $jobType->id }}" {{old('job_type') == $jobType->id ? 'selected': ''}}>
                                                    {{ $jobType->code }} - {{ $jobType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('job_type')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>คู่ค้า</label>
                                        <input type="text" class="form-control"
                                               value="{{ optional(auth()->user())->partner->name }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>สินค้า<span class="text-danger">*</span></label>
                                        <select class="form-control @error('product') is-invalid @enderror"
                                                name="product">
                                            <option value="">เลือกสินค้า</option>
                                            @foreach($products as $product)
                                                <option
                                                    value="{{ $product->id }}" {{old('product') == $product->id ? 'selected': ''}}>{{ $product->code }}
                                                    - {{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>แผนก<span class="text-danger">*</span></label>
                                        <select class="form-control @error('department') is-invalid @enderror"
                                                name="department">
                                            <option value="">เลือกแผนก</option>
                                            @foreach($departments as $department)
                                                <option
                                                    value="{{ $department->id }}" {{old('department') == $department->id ? 'selected': ''}}>{{ $department->code }}
                                                    - {{ $department->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>เลขบัตรประชาชน<span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('id_card') is-invalid @enderror"
                                            name="id_card"
                                            value="{{ old('id_card') ?? '' }}"
                                        >
                                        @error('id_card')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>คำนำหน้า</label>
                                        <select class="form-control" name="prefix">
                                            @foreach($prefixes as $index => $prefix)
                                                <option value="{{$index}}">{{$prefix}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>ชื่อ<span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            name="first_name"
                                            value="{{ old('first_name') ?? '' }}"
                                        >
                                        @error('first_name')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>นามสกุล<span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            name="last_name"
                                            value="{{ old('last_name') ?? '' }}"
                                        >
                                        @error('last_name')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if( !Session::has( 'qr' ))
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary">สร้าง QR Code</button>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                            @endif
                        </form>
                    </div>

                    @if( Session::has( 'qr' ))
                        <div class="col-md-12 py-2">
                            <div class="d-flex justify-content-center">
                                <img src="{{Session::get( 'qr' )}}">
                            </div>
                            <div class="d-flex justify-content-around pt-2">
                                <button class="btn btn-primary export" data-id="{{Session::get( 'id' )}}" data-type="preview">พิมพ์</button>
                                <button class="btn btn-dark export" data-id="{{Session::get( 'id' )}}" data-type="download">PDF</button>
                                <a href="{{ route('web.index') }}" class="btn btn-danger">ล้างค่า</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_after')
    <script>
        $('#task_date').datetimepicker({
            format: 'DD/MM/yyyy',
            defaultDate: new Date()
        });

        $('.export').click(function () {
            const params = [{
                name: "type",
                value: $(this).attr('data-type')
            }]

            const url = `/task/${$(this).attr('data-id')}/export?${$.param(params)}`;
            window.open(url);
        })

    </script>
@endsection
