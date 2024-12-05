<div class="row">
    <div class="col-12">
        <h5 class="mt-2 mb-4 text-center">Recent Logs</h5>
    </div>
</div>
<div id="logs-container" class="row my-2" 
     data-type="{{ $type }}" 
     data-id="{{ $id }}" 
     data-route="{{ route('teamflow.logs.get', ['type' => $type, 'id' => $id]) }}">
     <div class="col-md d-flex">
        <div class="avatar avatar-xl">
            <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
        </div>
        <div class="flex-1 ms-2">
            <h6 class="fs--1 mb-0">Tasneem Aldirini <span class="ms-1 text-500 fs--2">&lt;t.dirini@techs.com&gt;</span></h6>
            <p class="text-warning fs--2 mb-2">Sales Manager</p>
            <h6 class="mb-0 fs--2">Tasneem aldirini activity</h6>
        </div>
    </div>
    <div class="col-md-auto ms-auto d-flex align-items-center ps-6 ps-md-3"><small class="py-2">8:40 AM (9 hours ago)</small></div>
</div>
<hr>
</div>