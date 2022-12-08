@extends('adminlte::page')

@section('title', $data->contentHeader)

@section('content')
    <div class="container">
        <div class="d-flex justify-content-end py-2">
            <button class="btn btn-primary create"><i
                    class="fa fa-plus-circle" style="color: white;"></i> เพิ่มข้อมูล
            </button>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $data->contentHeader }}</h3>
                        <div class="card-tools">
                            <form method="get" id="filter_form">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input
                                        type="text"
                                        name="search"
                                        class="form-control float-right"
                                        placeholder="ค้นหา"
                                        value="{{ request()->input('search') ? request()->input('search') : null }}"
                                    >
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default" onclick="this.form.submit()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อผู้ใช้งาน</th>
                                <th>คู่ค้า</th>
                                <th>สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($items as $index => $item)
                                <tr>
                                    <td>{{ $items->pages->start+$index + 1 }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ optional($item->partner)->name }}</td>
                                    <td>
                                        <label class="switch switch-green">
                                            <input
                                                @if($item->is_active){{"checked"}}@endif
                                                type="checkbox"
                                                class="changeStatus switch-input"
                                                data-id="{{ $item->id }}"
                                                data-value="{{ $item->is_active }}"
                                                data-type="is_active"
                                            >
                                            <span
                                                class="change switch-label"
                                                data-on="เปิด"
                                                data-off="ปิด"
                                            ></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group  blog-manage" role="group">
                                            <button
                                                data-id="{{ $item->id }}"
                                                type="button"
                                                class="btn btn-primary edit"
                                                data-bs-toggle="tooltip"
                                                title="แก้ไข"
                                            >
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                            <button
                                                data-id="{{ $item->id }}"
                                                type="button"
                                                class="btn btn-warning text-white remove"
                                                data-bs-toggle="tooltip"
                                                title="ลบ"
                                            >
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"> ไม่มีข้อมูล</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
        @include('admin.inc.footer-table')
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">เพิ่ม</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <input type="hidden" id="id">
                        <input type="hidden" id="action">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">ชื่อผู้ใช้งาน</label>
                        <input type="text" class="form-control" id="username" placeholder="กรอกชื่อผู้ใช้งาน">
                        <span class="invalid-feedback" id="err-username"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน">
                        <span class="invalid-feedback" id="err-password"></span>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                        <input type="password" class="form-control" id="password_confirmation" placeholder="กรอกยืนยันรหัสผ่าน">
                        <span class="invalid-feedback" id="err-password_confirmation"></span>
                    </div>
                    <div class="form-group">
                        <label for="partner">คู่ค้า</label>
                        <select class="form-control" id="partner">
                            <option value="">กรุณาเลือกคู่ค้า</option>
                            @foreach($partners as $partner)
                                <option value="{{$partner->id}}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback" id="err-partner"></span>
                    </div>
                    <div class="form-group">
                        <label for="user_type">ประเภทผู้ใช้งาน</label>
                        <select class="form-control" id="user_type">
                            <option value="0">ผู้ใช้งานทั่วไป</option>
                            <option value="1">ผู้ดูแลระบบ</option>
                        </select>
                        <span class="invalid-feedback" id="err-user-type"></span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default col-3 col-md-2" data-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary col-3 col-md-2" id="submit">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.changeStatus').change(function () {
                var id = $(this).attr('data-id');
                var value = parseInt($(this).attr('data-value'));
                var typeField = $(this).attr('data-type');

                $.ajax({
                    url: '{{$data->preFixUrl}}/status',
                    type: 'post',
                    context: this,
                    data: {id, value: value, typeField},
                    success: function () {
                        handleToast('success', 'แก้ไขสำเร็จ')
                    },
                    error: function (xhr, err) {
                        handleToast()
                    }
                });
            });

            $('.create').click(function () {
                $('.modal-title').html('เพิ่ม')
                $('#username').val('').prop('disabled', false)
                $('#partner').val('').change()
                $('#user_type').val(0).change()
                $('#id').val('')
                $('#password').val('')
                $('#password_confirmation').val('')
                $('#action').val('create')
                $('#modal-default').modal('show')
                $('.invalid-feedback').removeClass('d-block').addClass('d-none')
            });

            $('.edit').click(function () {
                const id = $(this).attr('data-id');
                $('.invalid-feedback').removeClass('d-block').addClass('d-none')

                $.ajax({
                    url: '{{$data->preFixUrl}}/' + id,
                    context: this,
                    success: function (res) {
                        const { username, partner_id, is_admin } = res.data

                        $('.modal-title').html('แก้ไข')
                        $('#partner').val(partner_id).change()
                        $('#user_type').val(is_admin).change()
                        $('#username').val(username).prop('disabled', true)
                        $('#password').val('')
                        $('#password_confirmation').val('')
                        $('#id').val(id)
                        $('#action').val('edit')
                        $('#modal-default').modal('show')
                    },
                    error: function (xhr, err) {
                        handleToast()
                    }
                });
            });

            $('#submit').click(function() {
                $('#submit').prop('disabled', true)
                $('.invalid-feedback').removeClass('d-block')

                const payload = {
                    id: $('#id').val(),
                    username: $('#username').val(),
                    partner: $('#partner').val(),
                    action: $('#action').val(),
                    user_type: $('#user_type').val()
                }

                if ($('#password').val() != '' || $('#password_confirmation').val() != '') {
                    Object.assign(payload, {
                        password: $('#password').val(),
                        password_confirmation: $('#password_confirmation').val(),
                    })
                }

                $.ajax({
                    url: '{{$data->preFixUrl}}/store',
                    type: 'post',
                    data: payload,
                    context: this,
                    success: function (res) {
                        const { message, success } = res

                        if(!success) {
                            if (message.hasOwnProperty('username')) {
                                $('#err-username').html(message.username[0])
                                $('#err-username').addClass('d-block')
                            }

                            if (message.hasOwnProperty('password')) {
                                $('#err-password').html(message.password[0])
                                $('#err-password').addClass('d-block')
                            }

                            if (message.hasOwnProperty('password_confirmation')) {
                                $('#err-password_confirmation').html(message.password_confirmation[0])
                                $('#err-password_confirmation').addClass('d-block')
                            }

                            if (message.hasOwnProperty('partner')) {
                                $('#err-partner').html(message.partner[0])
                                $('#err-partner').addClass('d-block')
                            }

                            $('#submit').prop('disabled', false)
                            return
                        }

                        handleToast('success', 'สำเร็จ')
                    },
                    error: function (xhr, err) {
                        handleToast()
                    }
                });
            })

            $('.remove').click(function () {
                const id = $(this).attr('data-id');
                Swal.fire({
                    title: "แจ้งเตือน",
                    text: "ยืนยันการลบข้อมูล",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    showCancelButton: true,
                }).then((res) => {
                    let {value} = res;

                    if (value) {
                        $.ajax({
                            url: '{{$data->preFixUrl}}/delete/' + id,
                            type: 'delete',
                            context: this,
                            success: function () {
                                handleToast('success', 'ลบข้อมูลเรียบร้อย')
                            },
                            error: function (xhr, err) {
                                handleToast()
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
