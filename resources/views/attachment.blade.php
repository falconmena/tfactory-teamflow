<div class="tab-pane" id="attachments" role="tabpanel">
    <form class="dropzone dropzone-multiple p-0" id="teamflow-data-dropzone-attachment"
        action="{{ route('teamflow.attachment.store') }}" method="POST">
        @csrf
        <input type="hidden" name="attachable_id" value="{{ $attachable_id }}">
        <input type="hidden" name="attachable_type" value="{{ $attachable_type }}">
        <div class="fallback">
            <input name="file" type="file" multiple="multiple" />
        </div>
        <div class="dz-message" data-dz-message="data-dz-message"> 
            <img class="me-2" src="../../../assets/img/icons/cloud-upload.svg" width="25" alt="" />
            Drop your files here
        </div>
        <div class="w-100 text-center my-3">
            <h5 class="mt-2 mb-4 text-center">Recent Attachments</h5>
        </div>
    </form>
</div>
