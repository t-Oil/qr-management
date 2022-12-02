<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabun/THSarabunNew.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabun/THSarabunNew Bold.ttf') }}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabun/THSarabunNew Italic.ttf') }}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabun/THSarabunNew BoldItalic.ttf') }}") format('truetype');
    }

    body {
        font-family: "THSarabunNew";
    }

    table tr th {
        text-align: left;
        font-size: 20px;
    }

    .page-break{
        page-break-after:always;
    }

</style>

@php
    $headerStyle = "background-color: #cccccc;border: 1px solid #000000;";
    $bodyStyle = "border: 1px solid #000000;";
@endphp

<img src="{{ public_path() . '/assets/images/logo.png' }}"  style="height: 100px; width: auto; float: right">
<table style="border-collapse: collapse;" width="100%">
    <tr>
        <th>วันที่</th>
        <th>{{ $item->taskDate() }}</th>
    </tr>
    <tr>
        <th>ทะเบียนรถ</th>
        <th>{{ $item->vehicle_registration }}</th>
    </tr>
    <tr>
        <th>ทะเบียนพ่วง</th>
        <th>{{ $item->trailer_registration ?? '-' }}</th>
    </tr>
    <tr>
        <th>ประเภทชั่ง</th>
        <th>{{ $item->jobType->code }} {{ $item->jobType->name }}</th>
    </tr>
    <tr>
        <th>คู่ค้า</th>
        <th>{{ $item->partner->code }} {{ $item->partner->name }}</th>
    </tr>
    <tr>
        <th>สินค้า</th>
        <th>{{ $item->product->code }} {{ $item->product->name }}</th>
    </tr>
    <tr>
        <th>แผนก</th>
        <th>{{ $item->department->code }} {{ $item->department->name }}</th>
    </tr>
    <tr>
        <th>เลขบัตรประชาชน</th>
        <th>{{ $item->id_card }}</th>
    </tr>
    <tr>
        <th>ชื่อ-นามสกุล</th>
        <th>{{ $item->getFullname() }}</th>
    </tr>
    <tr>
        <th>QR Code</th>
        <th><img src="{{ $item->qr_code }}"></th>
    </tr>
</table>
