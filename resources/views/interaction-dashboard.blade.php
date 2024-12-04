<div class="card p-4 mx-2 my-4">
    <div class="card-body">
        <div class="d-md-flex justify-content-between">
            <div>
                <nav class="d-block d-xl-flex">
                    <div class="d-inline-block d-xl-flex nav nav-tabs border-0" id="nav-tab" role="tablist">
                        <button class="d-inline-block btn btn-falcon-default btn-sm m-2 active" data-bs-toggle="tab" data-bs-target="#send-message" type="button" role="tab"><span class="fas fa-envelope"></span><span class="d-inline-block mx-2">Send
                                Message</span></button>
                        <button class="d-inline-block btn btn-falcon-default btn-sm m-2" data-bs-toggle="tab" data-bs-target="#log-note" type="button" role="tab"><span class="fas fa-sticky-note"></span><span class="d-inline-block mx-2">Log Note</span></button>
                        <button class="d-inline-block btn btn-falcon-default btn-sm m-2" data-bs-toggle="tab" data-bs-target="#attachments" type="button"><span class="fas fa-paperclip"></span><span class="d-inline-block ms-2">Attachments</span><sup class="px-1 text-primary">30</sup></button>
                    </div>
                    <div class="d-inline-block d-lg-inline-block">
                        <button class="d-inline-block btn btn-falcon-default btn-sm m-2" data-bs-toggle="modal" data-bs-target="#schedule-activity-modal" type="button"><span class="fas fa-clock"></span><span class="d-inline-block mx-2">Schedule
                                Activity</span></button>
                    </div>
                </nav>
            </div>
            <div class="d-flex">
                <div>
                    <button class="btn btn-falcon-default btn-sm m-2"><span class="fas fa-user-plus"></span><span class="d-inline-block mx-2">Follow</span></button>
                </div>
                <div class="dropdown font-sans-serif">
                    <button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none m-2" type="button" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-user"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2">
                        {{-- <a class="dropdown-item" href="#!">Add Followers</a>
                            <a class="dropdown-item" href="#!">Add Channels</a>
                            <div class="dropdown-divider"></div> --}}
                        <a class="dropdown-item" href="#!">User #1</a>
                        <a class="dropdown-item" href="#!">User #2</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content pt-4" id="nav-tabContent">
            @include('tfactory-teamflow::message', ['type' => $type, 'id' => $id])
            @include('tfactory-teamflow::attachment', ['attachable_type' => $types, 'attachable_id' => $id])
        </div>
        <div class="recent-comments py-3 px-2">
            <div class="row">
                <div class="col-12">
                    <h5 class="mt-2 mb-4 text-center">Recent Logs</h5>
                </div>
            </div>
            <div class="row my-2">
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
            <div class="row my-2">
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
        </div>
    </div>
</div>
<div class="modal fade" id="schedule-activity-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content position-relative">
            {{-- <div class="position-absolute top-0 end-0 mt-3 me-4 z-2">
              <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body p-0">
                <div class="rounded-top-3 pt-4 ps-4 pe-7 bg-body-tertiary">
                    <h5 class="mb-1" id="modalExampleDemoLabel">Schedule Activity</h5>
                </div>
                <div class="p-4">
                    <form>
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Activity Type</label>
                                <select name="" class="form-control fs--1">
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Due Date</label>
                                <input class="form-control fs--1" name="" type="date" />
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Summary</label>
                                <input class="form-control fs--1" name="" type="text" />
                            </div>
                            <div class="col-12 col-lg-6 mb-3">
                                <label class="col-form-label fs--1">Assigned To</label>
                                <select name="" class="form-control fs--1">
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="col-12 my-3">
                                <div class="min-vh-25 border rounded">
                                    <textarea class="tinymce d-none fs--1 border" data-tinymce="data-tinymce" name="content"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer px-4 pb-3">
                <button class="btn btn-outline-danger fs--1 py-2 px-4 m-2" type="button" data-bs-dismiss="modal">Discard</button>
                <button class="btn btn-outline-primary fs--1 py-2 px-4 m-2" type="button" data-bs-dismiss="modal">Mark as Done</button>
                <button class="btn btn-primary fs--1 py-2 px-4 my-2 mx-0" type="button">Schedule</button>
            </div>
        </div>
    </div>
</div>