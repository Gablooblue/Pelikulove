<div class="table-responsive posts-table">
    <table class="table data-table">
    <thead>
        <tr>
            <th>
                {{ trans('forum::general.author') }}
            </th>
            <th>
                {{ trans_choice('forum::posts.post', 1) }}
            </th>
        </tr>
    </thead>
    <tbody>
        <tr id="post-{{ $post->id }} d-flex">
            <td class="">
                <strong>{!! $post->authorName !!}</strong>
            </td>
            <td>
                {!! Forum::render($post->content) !!}
            </td>
        </tr>
    </tbody>
</table>
</div>
