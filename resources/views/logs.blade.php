<div class="row">
    <div class="col-12">
        <h5 class="mt-2 mb-4 text-center">Recent Logs</h5>
    </div>
</div>
<div id="logs-container" class="row my-2" 
     data-type="{{ $type }}" 
     data-id="{{ $id }}" 
     data-token="{{ csrf_token() }}"
     data-route="{{ route('teamflow.logs.get', ['type' => $type, 'id' => $id]) }}">
</div>