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
        var create_tf = false;
        var show_tf = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function(e){
            $.ajax({
                type: 'GET',
                url: '/localSemesters/create',
                headers: {
                    "Content-Type" : "application/json",
                    "X-HTTP-Method-Override" : "POST"
                },
            }).then(data => {
                var ls_container = document.getElementById('ls-container');
                Array.from(data).forEach((value)=>{
                    var ls_box = document.createElement('div');
                    ls_box.className = 'ls-box';
                    ls_box.innerHTML = '<div>작성자 : "'+value.user.name+'"</div>\
                    <div>제목 : "'+value.title+'"</div>\
                    <div class="ls-image" name="'+value.id+'" value="'+value.id+'">ls-image</div>\
                    <button class="button-update" name="'+value.id+'">수정</button>\
                    <button class="button-delete" name="'+value.id+'">삭제</button>';
                    ls_container.appendChild(ls_box);
                });
            })
        });

        $(document).on('click', '#button-write', function(e){
            var ls_modal_container = document.getElementById('ls-modal-container');
            // 작성 버튼을 위한 modal
            var create_div = document.createElement('div');
            create_div.className = 'ls-modal-content';
            create_div.innerHTML = '<form id="ls-form" name="ls-form" >@csrf<label for="ls-modal-title">제목</label>\
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
            ls_modal_container.style.display = 'block';
            console.log(create_div);

            $('#ls-form').on('submit', function(e){
                $.ajax({
                    type: 'POST',
                    url: '/localSemesters',
                    headers : { // Http header
                    "Content-Type" : "application/json",
                    "X-HTTP-Method-Override" : "POST"
                    },
                    success:function(data){
                        alert("coco");
                    }
                })
                alert("haha");
            });
            
            // $('#ls-form').on('submit', function(e){
                $.ajax({
                    data : $(this).serialize(),
                    success :function(data){
                        alert(data);
                    }
                });
            // });
        })

        $(document).on('click', '.button-save', function(e){

        })
        $(document).on('click', '.button-update', function(e){
        })

        $(document).on('click', '.button-delete', function(e){
            var id = $(this).attr('name');
            console.log(id);
            if(confirm("엠창?")){
                $.ajax({
                    type: 'DELETE',
                    url: '/localSemesters/' + id,
                    headers : { // Http header
                    "Content-Type" : "application/json",
                    "X-HTTP-Method-Override" : "POST"
                    },
                }).then(function(){
                    e.target.parentNode.parentNode.removeChild(e.target.parentNode);
                });
            }
        });
        
        $(document).on('click', '.ls-image', function(e){
            var id = $(this).attr('name');
            console.log(e.target.getAttribute('name'));
            var ls_modal_container = document.getElementById('ls-modal-container');
            var show_div = document.createElement('div');
            show_div.className = 'ls-modal-show';
            $.ajax({
                type: 'GET',
                url: '/localSemesters/' + id,
                headers: {
                    "Content-Type" : "application/json",
                    "X-HTTP-Method-Override" : "POST"
                },
            }).then(function(data){
                show_div.innerHTML = '<div>제목 : "'+data[0].title+'"</div>\
                <br>\
                <div>작성자 : "'+data[0].user.name+'"</div>\
                <br>\
                <div>사진 : </div>\
                <br>\
                <div>이야기 : "'+data[0].content+'"</div>\
                <br>';
            })
            ls_modal_container.appendChild(show_div);
            ls_modal_container.style.display = 'block';
        })

        window.onclick = function(event) {
            var ls_modal_container = document.getElementById('ls-modal-container');
            if (event.target == ls_modal_container) {
                ls_modal_container.innerHTML="";
                ls_modal_container.style.display = "none";
            }
        }
    }
    </script>
@stop