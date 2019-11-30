@extends('layouts.app')

@section('content')
<div class='container'>
    <h1>후쿠오카 현지학기제</h1>
    <hr>
    <button id='button-write'>작성</button>
    <hr>
    <div id='ls-container'>
        @forelse($datas as $key=>$data)
            <div class='ls-box'>
                <div>{{ $data->user->name }}의 {{ $data->id }}번째 이야기</div>
                <div>{{ $data->title }}</div>
                <div class='ls-image' name='{{$data->id}}' value='{{ $data->id }}'>ls-image</div>
            </div>
            @if(($key+1) % 3 == 0)
                <hr>
            @endif
        @empty
            <p>글이 없습니다.</p>
        @endforelse
    </div>

    @if($datas->count())
        <div class="text-center">
            {{-- XSS 보호 기능 끄기 : htmlspecialchars --}}
            {!! $datas->render() !!}
        </div>
    @endif
</div>
@stop

@section('style')
    <style>
        #ls-container {
            width: 100%;
        }
        .ls-box {
            display: inline-block;
            border: solid black 1px;
            width: 31%;
            text-align: center;
            margin: 1%;
        }
        .ls-image {
            border: solid black 1px;
            width: 100%;
            height: 20vh;
            color: green;
        }
        .create-div {
            border: solid black 1px;
            width: 50px;
            height: 50px;
        }
    </style>
@stop

@section('script')
    <script>
        window.onload = () => {
        document.getElementById('button-write').addEventListener('click', () => {
            var button = document.getElementById('button-write');
            var div = document.createElement('div');
            div.className = 'create-div';
            div.innerHTML = '<input type="text" name="title" value="title" />\
            <input type="text" name="name" value="name" />\
            <input type="text" name="content" value="content" />';
            button = document.appendChild(div);
            button.getElemen.setAttribute('class', 'create-div');
        })
        
        /* 주훈센세의 코드...
        // var boxs = document.querySelectorAll('.ls-box');
        // boxs.forEach((box) => {
        //     box.addEventListener('click',(e)=>{
        //         console.log(e.target);
        //     });
        // }) */

        document.querySelectorAll('.ls-box').forEach((box)=>{
            // box.addEventListener('click', (e) => {
            //     console.log(e.currentTarget.querySelector('.ls-image'));
            // })
            box.querySelector('.ls-image').addEventListener('click', (e) => {
                console.log(e.target.getAttribute('name'));
            })
        })
    }
    </script>
@stop