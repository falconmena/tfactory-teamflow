<div class="tab-pane active" id="send-message" role="tabpanel">
    <div class="row px-2">
        <div class="col-12 d-flex">
            <div class="avatar avatar-2xl">
                <img class="rounded-circle" src="../../assets/img/team/1.jpg" alt="" />
            </div>
            <div class="flex-1 ms-2">
                <h6 class="mb-0 fs-0">Tasneem Aldirini</h6>
                <a class="text-800 fs--1" href="#!">
                    <span class="fw-semi-bold">Sales</span>
                    <span class="ms-1 text-500">&lt;t.dirini@techs.com&gt;</span>
                </a>
            </div>
        </div>
        <div class="col-12 mt-3 mb-2">
            <form action="{{ route('teamflow.message.store') }}">
                <input type="hidden" value="message" name="notableType">
                <input type="hidden" value="1" name="notableId">
                <p class="text-warning fs--2 mb-2">To: Followers of "[T7805] Test Case Round one"</p>
                <textarea class="tinymce d-none fs--1 border" data-tinymce="data-tinymce" name="message"></textarea>
                <div class="text-end mt-3">
                    <button class="btn btn-primary px-4 py-2 fs--1"><span class="d-inline-block mx-2">Send </span> <span class="fab fa-telegram-plane"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>