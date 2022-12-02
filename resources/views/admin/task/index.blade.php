@extends('adminlte::page')

@section('title', $data->contentHeader)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{ $data->contentHeader }}</h3>
                            <div>
                                <form method="get" id="filter_form">
                                    <div class="form-group">
                                        <label>วันที่</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                              </span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="reservation">
                                            <input type="hidden" name="start_date" id="start_date" value="{{ request()->input('start_date') ?? '' }}">
                                            <input type="hidden" name="end_date" id="end_date" value="{{ request()->input('end_date') ?? '' }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"
                                                        onclick="this.form.submit()">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table text-nowrap w-auto mw-100">
                            <thead>
                            <tr>
                                <th scope="col">QR Code</th>
                                <th scope="col">วันที่</th>
                                <th scope="col">ทะเบียนรถ</th>
                                <th scope="col">ทะเบียนพ่วง</th>
                                <th scope="col">ประเภทชั่ง</th>
                                <th scope="col">คู่ค้า</th>
                                <th scope="col">สินค้า</th>
                                <th scope="col">แผนก</th>
                                <th scope="col">เลขบัตรประชาชน</th>
                                <th scope="col">ชื่อ-นามสกุล</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($items as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <button class="btn export" data-id="{{$item->id}}" data-type="preview"><i
                                                class="fas fa-qrcode"></i></button>
                                    </td>
                                    <td>{{ $item->taskDate() }}</td>
                                    <td>{{ $item->vehicle_registration }}</td>
                                    <td>{{ $item->trailer_registration ?? '-' }}</td>
                                    <td>{{ $item->jobType->code }} {{ $item->jobType->name }}</td>
                                    <td>{{ $item->partner->code }} {{ $item->partner->name }}</td>
                                    <td>{{ $item->product->code }} {{ $item->product->name }}</td>
                                    <td>{{ $item->department->code }} {{ $item->department->name }}</td>
                                    <td>{{ $item->id_card }}</td>
                                    <td>{{ $item->getFullName() }}</td>
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
@stop

@section('css')
@stop

@section('js')
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">

    {{-- moment --}}
    <script src="{{ asset('vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>

    <script>
        let startDate = $('#start_date').val()
        let endDate = $('#end_date').val()

        const option = {
            minDate: moment().subtract('days', 29),
            locale: {
                format: 'DD/MM/yyyy'
            }
        }

        if (startDate !== '' && endDate !== '') {
            Object.assign(option, {
                startDate: moment(startDate, 'Y-MM-DD').format('DD/MM/yyyy'),
                endDate: moment(endDate, 'Y-MM-DD').format('DD/MM/yyyy'),
            })
        }

        $('#reservation').daterangepicker(option,function(start, end) {
            $('#start_date').val(start.format('Y-MM-DD'))
            $('#end_date').val(end.format('Y-MM-DD'))
        })

        $(document).ready(function () {
            $('.export').click(function () {
                const params = [{
                    name: "type",
                    value: $(this).attr('data-type')
                }]

                const url = `/task/${$(this).attr('data-id')}/export?${$.param(params)}`;
                window.open(url);
            })
        });
    </script>
@stop
