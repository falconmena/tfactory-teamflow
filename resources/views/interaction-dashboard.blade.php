<div class="card p-4 mx-2 my-4">
    <div id="teamflow_activity_form_response"></div>
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
            @include('tfactory-teamflow::message', ['type' => $type, 'id' => $id, 'user' => $user])
            @include('tfactory-teamflow::attachment', ['attachable_type' => $type, 'attachable_id' => $id])
        </div>
        <div class="recent-comments py-3 px-2">
            @include('tfactory-teamflow::logs', ['type' => $type, 'id' => $id])
        </div>
    </div>
</div>
@include('tfactory-teamflow::activity', ['activityable_type' => $type, 'activityable_id' => $id, 'user' => $user])