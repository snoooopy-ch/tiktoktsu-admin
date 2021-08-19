<div class="col-12">
    @if ($errors->any())
        <div class="card-body">
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @if ($message = Session::get('flash_message'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ trans($message) }}
        </div>
    @endif
</div>

<div class="col-12">
    <form action="{{ route('publish.send') }}" method="POST" enctype="form-data/multipart" class="mt-5 mb-5">
        <h1 class="text-center mb-3 text-primary">TikTokランキングに掲載</h1>
        <h4 class="text-center mb-3">TikTokの@以降の英数字のみを入力してください(@は不要)。更新後、掲載まで数日かかることがあります。</h4>
        <div class="d-md-flex d-sm-block justify-content-center align-items-center text-sm-center text-center">
            @csrf
            <span>https://www.tiktok.com/@</span>
            <input class="form-control w-auto mr-1 m-sm-auto m-auto m-md-1" name="uniqueId" id="uniqueId">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                <i class="feather icon-edit-1"></i> TikTokアカウントを追加
            </button>

        </div>
    </form>
</div>
