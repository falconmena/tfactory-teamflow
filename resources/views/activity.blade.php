<div class="modal fade" id="schedule-activity-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content position-relative">
            {{-- <div class="position-absolute top-0 end-0 mt-3 me-4 z-2">
              <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <form id="teamflow_activity_form" autocomplete="off" action="{{ route('teamflow.activity.store') }}"
                method="POST">
                @csrf
                <input type="hidden" name="activityable_id" value="{{ $activityable_id }}">
                <input type="hidden" name="activityable_type" value="{{ $activityable_type }}">
                <div class="modal-body p-0">
                    <div class="rounded-top-3 pt-4 ps-4 pe-7 bg-body-tertiary">
                        <h5 class="mb-1" id="modalExampleDemoLabel">Schedule Activity</h5>
                    </div>
                    <div class="rounded-top-3 pt-4 ps-4 pe-7" id="teamflow_activity_error_response"></div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Activity Type</label>
                                <select name="activity_type" class="form-control fs--1">
                                    <option value="" disabled>Select</option>
                                    @foreach (Config::get('tfactory-teamflow.activity_type') as $key => $activity_type)
                                        <option value="{{ $key }}" selected="selected">{{ $activity_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Due Date</label>
                                <input class="form-control fs--1" name="due_date" type="date" />
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Summary</label>
                                <input class="form-control fs--1" name="summary" type="text" />
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Assigned To</label>
                                <select name="assigned_to" class="form-control fs--1">
                                    <option value="1">Ammar</option>
                                </select>
                            </div>
                            <div class="col-12 my-3">
                                <div class="min-vh-25 border rounded">
                                    <!-- Hidden input to hold TinyMCE content -->
                                    <input type="hidden" id="teamflow-activity-editor-content" name="editor_content">

                                    <textarea class="tinymce d-none fs--1 border" id="teamflow-activity-editor" teamflow-data-tinymce="teamflow-data-tinymce" name="content"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 pb-3">
                    <button class="btn btn-outline-danger fs--1 py-2 px-4 m-2" type="button"
                        data-bs-dismiss="modal">Discard</button>
                    <button class="btn btn-outline-primary fs--1 py-2 px-4 m-2" type="button"
                        data-bs-dismiss="modal">Mark as Done</button>
                    <button class="btn btn-primary fs--1 py-2 px-4 my-2 mx-0" id="teamflow_schedule_activity"
                        type="button">Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
