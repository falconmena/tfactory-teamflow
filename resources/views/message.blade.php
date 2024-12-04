<div class="tab-pane active" id="send-message" role="tabpanel">
    <div class="row px-2">
        <div class="col-12 d-flex">
            <div class="avatar avatar-2xl">
                <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
            </div>
            <div class="flex-1 ms-2">
                <h6 class="mb-0 fs-0">{{ $user->first_name }} {{ $user->last_name }}</h6>
                <a class="text-800 fs--1" href="#!">
                    <span class="fw-semi-bold">{{ $user->roles->pluck('name')->first() }}</span>
                    <span class="ms-1 text-500">{{ $user->email }}</span>
                </a>
            </div>
        </div>
        <div class="col-12 mt-3 mb-2">
            <form action="{{ route('teamflow.message.store') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $type }}" name="notableType">
                <input type="hidden" value="{{ $id }}" name="notableId">
                <input type="hidden" value="{{ auth('admin')->user()->id }}" name="created_by">
                <p class="text-warning fs--2 mb-2">To: Followers of "[T7805] Test Case Round one"</p>
                <textarea class="tinymce d-none fs--1 border" data-tinymce="data-tinymce" name="message"></textarea>
                <div class="text-end mt-3">
                    <button class="btn btn-primary px-4 py-2 fs--1"><span class="d-inline-block mx-2">Send </span> <span class="fab fa-telegram-plane"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>