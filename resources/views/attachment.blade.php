<div class="tab-pane" id="attachments" role="tabpanel">
    <form class="dropzone dropzone-multiple p-0" id="teamflow-data-dropzone-attachment"
        action="{{ route('teamflow.attachment.store') }}" method="POST">
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
        <div class="dz-preview dz-file-preview">
            <div class="dz-details">
                <img data-dz-thumbnail />
                <div class="dz-filename"><span data-dz-name></span></div>
                <div class="dz-size" data-dz-size></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="dz-remove" data-dz-remove>Remove File</div>
        </div>
    </form>
    <div class="w-100 text-center my-3">
        <h5 class="mt-2 mb-4 text-center">Recent Attachments</h5>
        <div id="teamflow-recent-attachments"></div>
    </div>
</div>
