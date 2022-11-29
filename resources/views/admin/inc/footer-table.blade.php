<div class="table-footer">
    <div class="row">
        <div class="col-sm-5">
            <p style=" padding: 25px 0">
                ทั้งหมด : <b>{{ (count($items) > 0) ? $items->total() : 0 }} </b> รายการ
            </p>
        </div>
        <div class="col-sm-7" style="padding: 20px 0">
            {!! $items->appends(request()->all())->links('admin.inc.pagination') !!}
        </div>
    </div>
</div>
