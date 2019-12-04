<div class='ls-box'>
    <div>작성자 : {{ $data->user->name }}</div>
    <div>제목 : {{ $data->title }}</div>
    <div class='ls-image' name='{{$data->id}}' value='{{ $data->id }}'>ls-image</div>
    <button class='button-update' name='{{$data->id}}'>수정</button>
    <button class='button-delete' name='{{$data->id}}'>삭제</button>
</div>
<!-- @if(($key+1) % 3 == 0)
    <hr>
@endif -->