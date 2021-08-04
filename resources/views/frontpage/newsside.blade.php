<div class="card">
    <div class="card-header">
        <h6>もっとも読まれているニュース</h6>
    </div>
    <div class="card-content">
        <div class="card-body p-0">
            <div class="media-list media-bordered">
                @foreach ($topNews as $index => $topItem)
                    <div class="media topnews-item">
                        @if ($topItem->thumb != '')
                            <a class="media-left" href="{{ route('posts.view', ['id' => $topItem->id]) }}">
                                <img src="{{ $topItem->thumb }}" alt="Generic placeholder image" height="64"
                                    width="64">
                            </a>
                        @endif
                        <div class="media-body">
                            <a class="" href="{{ route('posts.view', ['id' => $topItem->id]) }}">
                                <h4 class="media-heading sidebar-title">{{ $topItem->title }}</h4>
                            </a>
                            <div class="sidebar-content">{!! $topItem->content !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
