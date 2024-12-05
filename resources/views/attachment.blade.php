<div class="tab-pane" id="attachments" role="tabpanel">
    <form class="dropzone dropzone-multiple p-0" id="teamflow-data-dropzone-attachment" data-dropzone="teamflow-data-dropzone-attachment"
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
        <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column comment-log-attachment-previews">
            <div class="d-flex media mb-3 pb-3 border-bottom btn-reveal-trigger"><img class="dz-image"
                    style="width: 65px !important; height: 65px !important"
                    src="../../../assets/img/generic/image-file-2.png" alt="..."
                    data-dz-thumbnail="data-dz-thumbnail" />
                <div class="flex-1 d-flex flex-between-center comment-attachment-text-wrapper">
                    <div>
                        <h6 data-dz-name="data-dz-name"></h6>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fs-10 text-400 lh-1" data-dz-size="data-dz-size"></p>
                            <div class="dz-progress"><span class="dz-upload"
                                    data-dz-uploadprogress=""></span></div>
                        </div><span class="fs-11 text-danger"
                            data-dz-errormessage="data-dz-errormessage"></span>
                    </div>
                    <div class="dropdown font-sans-serif"><button
                            class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                        <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item"
                                href="#!" data-dz-remove="data-dz-remove">Remove File</a></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="w-100 text-center my-3">
        <h5 class="mt-2 mb-4 text-center">Recent Attachments</h5>
    </div>
</div>
