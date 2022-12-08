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
                                <th>รหัสแผนก</th>
                                <th>ชื่อแผนก</th>
                                <th>สถานะ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($items as $index => $item)
                                <tr>
                                    <td>{{ $items->pages->start+$index + 1 }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
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
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="code">รหัสสินค้า</label>
                        <input type="text" class="form-control" id="code" placeholder="กรอกรหัสสินค้า">
                        <span class="invalid-feedback" id="err-code"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">ชื่อสินค้า</label>
                        <input type="text" class="form-control" id="name" placeholder="กรอกชื่อสินค้า">
                        <span class="invalid-feedback" id="err-name"></span>
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
                $('#code').val('')
                $('#name').val('')
                $('#id').val('')
                $('#modal-default').modal('show')
            });

            $('.edit').click(function () {
                const id = $(this).attr('data-id');

                $.ajax({
                    url: '{{$data->preFixUrl}}/' + id,
                    context: this,
                    success: function (res) {
                        const { code, name} = res.data

                        $('.modal-title').html('แก้ไข')
                        $('#code').val(code)
                        $('#name').val(name)
                        $('#id').val(id)
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
                    code: $('#code').val(),
                    name: $('#name').val()
                }

                $.ajax({
                    url: '{{$data->preFixUrl}}/store',
                    type: 'post',
                    data: payload,
                    context: this,
                    success: function (res) {
                        const { message, success } = res

                        if(!success) {
                            if (message.hasOwnProperty('code')) {
                                $('#err-code').html(message.code[0])
                                $('#err-code').addClass('d-block')
                            }

                            if (message.hasOwnProperty('name')) {
                                $('#err-name').html(message.name[0])
                                $('#err-name').addClass('d-block')
                            }

                            $('#submit').prop('disabled', false)
                            return
                        }

                        handleToast('success', 'สำเร็จ')
                    },
                    error: function (xhr, err) {
                        // handleToast()
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
