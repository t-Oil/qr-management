@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-secondary">
                    <div class="card-header bg-dark-primary">
                        <h3 class="card-title m-0">เปลี่ยนรหัสผ่าน</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{(url('change-password/update'))}}" method="POST">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>รหัสผ่านเก่า</label>
                                    <input
                                        type="password"
                                        name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        placeholder="รหัสผ่านเก่า"
                                    >
                                    @error('old_password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>รหัสผ่านใหม่</label>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="รหัสผ่านใหม่"
                                    >
                                    @error('password')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ยืนยันรหัสผ่านใหม่</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="ยืนยันรหัสผ่านใหม่"
                                    >
                                    @error('password_confirmation')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('web.index') }}" class="btn btn-secondary">กลับ</a>
                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_after')

    <script type="text/javascript">
        @if(session()->has('changePassword'))
        Swal.fire({
            title: 'เปลี่ยนรหัสผ่านเรียบร้อย',
            text: "กรุณาเข้าสู่ระบบใหม่",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3490dc',
            confirmButtonText: 'ตกลง',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route('auth.logout') }}'
            }
        })
        @endif
    </script>
@endsection
