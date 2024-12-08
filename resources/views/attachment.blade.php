<div class="tab-pane" id="attachments" role="tabpanel">
    <form class="dropzone dropzone-multiple p-0" id="teamflow-dropzone-attachment" 
        action="{{ route('teamflow.attachment.store') }}" method="POST" data-recent-token="{{ csrf_token() }}" data-delete-token="{{ csrf_token() }}"
        data-recent-route="{{ route('teamflow.attachment.recent') }}" data-delete-attachemnt-route="{{ route('teamflow.attachment.delete') }}">
        @csrf
        <input type="hidden" name="attachable_id" value="{{ $attachable_id }}">
        <input type="hidden" name="attachable_type" value="{{ $attachable_type }}">
        <input type="hidden" name="created_by" value="{{ $user->id }}">
        <div class="fallback">
            <input name="file" type="file" multiple="multiple" />
        </div>
        <div class="dz-message" data-dz-message="data-dz-message"> 
            <img class="me-2" src="../../../assets/img/icons/cloud-upload.svg" width="25" alt="" />
            Drop your files here
        </div>
    </form>
    <div class="w-100 text-center my-3">
        <h5 class="mt-2 mb-4 text-center">Recent Attachments</h5>
        <div id="teamflow-recent-attachments"></div>
    </div>
</div>
