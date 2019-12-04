@extends('layouts.app')

@section('content')
<div class='container'>
    <h1>후쿠오카 현지학기제</h1>
    <hr>
    <button id='button-write'>작성</button>

    <div id='ls-modal-container'></div>
    <hr>
    <div id='ls-container'>
    </div>
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
        #ls-modal-container {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .ls-modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */    
        }
        .ls-modal-show {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */    
        }
        #ls-modal-title {
            width: 90%;
        }
        #ls-modal-name {
            width: 90%;
        }
        #ls-modal-content {
            width: 90%;
        }
        #button-save {
        }
    </style>
@stop

@section('script')
    <script>
        window.onload = () => {
        var ls_modal_container = document.getElementById('ls-modal-container');
        // 작성 버튼을 위한 modal
        var create_div = document.createElement('div');
        create_div.className = 'ls-modal-content';
        create_div.innerHTML = '<form action="{{ route('localSemesters.store') }}" id="ls-form" name="ls-form" method="post"><label for="ls-modal-title">제목</label>\
        <input type="text" id="ls-modal-title" name="title" placeholder="title" />\
        <br>\
        <label for="ls-modal-name">이름</label>\
        <input type="text" id="ls-modal-name" name="name" placeholder="name" />\
        <br>\
        <label for="ls-modal-content">내용</label>\
        <textarea name="content" id="ls-modal-content" placeholder="content" rows="8" ></textarea>\
        <br>\
        <input type="submit" value="save" id="button-save"/></form>';
        ls_modal_container.appendChild(create_div);

        // 작성 버튼 클릭 시 이벤트!
        document.getElementById('button-write').addEventListener('click', () => {
            ls_modal_container.appendChild(create_div);
            var ls_modal_content = ls_modal_container.querySelector('.ls-modal-content');
            ls_modal_container.style.display = 'block';
            try{
                ls_modal_container.removeChild(show_div);
            } catch(e){
                // console.log('이미 child는 제거됨')
            }
            window.onclick = function(event) {
            if (event.target == ls_modal_container) {
                ls_modal_container.style.display = "none";
            }
            var input_title = document.getElementById('ls-modal-title');
            var input_name = document.getElementById('ls-modal-name');
            var input_content = document.getElementById('ls-modal-content');
            fetch('/localSemesters/', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json; charset=utf-8',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: input_title.value,
                    name: input_name.value,
                    content: input_content.value,
                }),
            })
            .then(e => e.json())
        }
        })

        // FETCH : 생성 read
        fetch('/localSemesters/create', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(e => e.json())
        .then(data => {
            var ls_container = document.getElementById('ls-container');
            Array.from(data).forEach((value, key) => {
                var ls_box = document.createElement('div');
                ls_box.className = 'ls-box';
                ls_box.innerHTML = '<div>작성자 : "'+value.user.name+'"</div>\
                <div>제목 : "'+value.title+'"</div>\
                <div class="ls-image" name="'+value.id+'" value="'+value.id+'">ls-image</div>\
                <button class="button-update" name="'+value.id+'">수정</button>\
                <button class="button-delete" name="'+value.id+'">삭제</button>';
                ls_container.appendChild(ls_box);
            });
            return
        })
        .then(() => {
            document.querySelectorAll('.ls-box').forEach((box)=>{
                box.querySelector('.ls-image').addEventListener('click', (e) => {
                    console.log(e.target.getAttribute('name'));
                    // show_div.value= 이름:  e.target
                    var ls_modal_container = document.getElementById('ls-modal-container');
                    ls_modal_container.style.display = 'block';
                    try{
                        ls_modal_container.removeChild(create_div);
                    } catch(e){
                        // console.log('이미 child는 제거됨');
                    }
                    // image를 띄우는 modal
                    var show_div = document.createElement('div');
                    show_div.className = 'ls-modal-show';
                    id = e.target.getAttribute('name');
                    fetch('/localSemesters/' + id, {
                        method: 'GET'
                    })
                    .then(e => e.json())
                    .then((data) => {
                        show_div.innerHTML = '<div>제목 : "'+data[0].title+'"</div>\
                        <br>\
                        <div>작성자 : "'+data[0].user.name+'"</div>\
                        <br>\
                        <div>사진 : </div>\
                        <br>\
                        <div>이야기 : "'+data[0].content+'"</div>\
                        <br>';
                    })
                    .then(() => {
                        ls_modal_container.appendChild(show_div);
                        window.onclick = function(event) {
                            if (event.target == ls_modal_container) {
                                ls_modal_container.style.display = "none";
                                try{
                                    ls_modal_container.removeChild(show_div);
                                } catch(e){
                                    console.log('이미 child는 제거됨')
                                }
                            }
                        }
                    })
                })
                box.querySelector('.button-delete').addEventListener('click', (e) => {
                var id = e.target.getAttribute('name');
                console.log(id);
                if(confirm('글을 삭제합니다.')){
                    fetch('/localSemesters/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(() => {
                        e.target.parentNode.parentNode.removeChild(e.target.parentNode);
                    })
                }
            })
            })
        })

        /* // image를 띄우는 modal
        var show_div = document.createElement('div');
        show_div.className = 'ls-modal-show';
        show_div.innerHTML = '<div>제목 : </div>\
        <br>\
        <div>번호 : </div>\
        <br>\
        <div>작성자</div>\
        <br>\
        <div>사진</div>\
        <br>\
        <div>이야기</div>\
        <br>';
        ls_modal_container.appendChild(show_div); */
        

        /* // '저장'버튼을 클릭 시 이벤트!
        document.getElementById('button-save').addEventListener('click', () => {
            document.getElementById('ls-modal-title').value='';
            document.getElementById('ls-modal-name').value='';
            document.getElementById('ls-modal-content').value='';
            ls_modal_container.removeChild(create_div);
            ls_modal_container.style.display = 'none';
        }) */

        /* // 모달의 밖(검은부분)을 누를 시 모달을 닫는다!
        window.onclick = function(event) {
            if (event.target == ls_modal_container) {
                ls_modal_container.style.display = "none";
            }
        } */

        /* // 사진 박스를 누를 때 이벤트 발생!
        document.querySelectorAll('.ls-box').forEach((box)=>{
            box.querySelector('.ls-image').addEventListener('click', (e) => {
                console.log(e.target.getAttribute('name'));
                // show_div.value= 이름:  e.target
                ls_modal_container.appendChild(show_div);
                ls_modal_container.style.display = 'block';
                try{
                    ls_modal_container.removeChild(create_div);
                } catch(e){
                    // console.log('이미 child는 제거됨');
                }
            })
        }) */

    }
    </script>
@stop