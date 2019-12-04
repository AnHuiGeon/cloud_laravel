<div class='ls-box'>
    <div>작성자 : {{ $data->user->name }}</div>
    <div>제목 : {{ $data->title }}</div>
    <div class='ls-image' name='{{$data->id}}' value='{{ $data->id }}'>ls-image</div>
    <button class='button-update' name='{{$data->id}}'>수정</button>
    <button class='button-delete' name='{{$data->id}}'>삭제</button>
</div>
@extends('layouts.app')

@section('script')
<script>
    (function($) {
        window.onload = function(){
            fetch('/team/create',{
              method: "GET",
              headers: {"Content-Type": "application/json; charset=utf-8"},
            })
            .then(e => e.json())
            .then(data => {
              var mainUl = document.getElementById('team-ul');
              Array.from(data).forEach((info,index)=>{
                var li = document.createElement('li');
                if(index%2 == 0){
                  li.className = 'timeline-inverted';
                }
                var img_div = document.createElement('div');
                img_div.className = 'timeline-image';
                img_div.id = info.id;
                var img = document.createElement('img');
                img.className = 'rounded-circle img-fluid';
                img.src='sample.jpg';
                var out_div = document.createElement('div');
                out_div.className = 'timeline-panel';
                var in_div = document.createElement('div');
                in_div.className = 'timeline-heading';
                var name = document.createElement('h4');
                name.innerHTML = info.user.name;
                var email = document.createElement('h6');
                email.className = 'subheading';
                email.innerHTML = info.user.email;
                img_div.appendChild(img);
                li.appendChild(img_div);
                in_div.appendChild(name);
                in_div.appendChild(email);
                out_div.appendChild(in_div);
                li.appendChild(out_div);
                mainUl.appendChild(li);
              });
              return
            }).then(_ =>{
            var imgs = $('.timeline-image');
            // timeline-image 라는 클래스이름을 가진 태그들을 배열로 imgs에 대입
            // elementsById 요론 느낌!
            console.log(imgs.length);
            clickStatus = [];
            for(var i = 0; i < imgs.length; i++){
                clickStatus[i] = false;
            }
            Array.from($('.timeline-image')).forEach(function(img, index){
                img.addEventListener('click',function(e){
                    var target = e.currentTarget.parentNode.lastChild
                    if(clickStatus[index] == false){
                        var div = document.createElement('div');
                        div.className = 'timeline-body';
                        var commend = document.createElement('p');
                        commend.className = 'text-muted'; 
                        var birthday = document.createElement('p');
                        birthday.className = 'text-muted';
                        id = e.currentTarget.id;

                        fetch('/team/'+id,{
                          method: "GET"
                        }).then(e => e.json())
                        .then(function(data){
                          console.log(data);
                          birthday.innerHTML = '생일 : '+data[0].birth;
                          commend.innerHTML = '자기소개 : '+data[0].team.commend;
                        });
                        div.appendChild(birthday);
                        div.appendChild(commend);
                        target.appendChild(div);
                        clickStatus[index] = true;
                    }
                    else{
                        target.removeChild(target.lastChild)
                        clickStatus[index] = false;
                    }
                });
            });         
            });
          }
    })(jQuery);
</script>
@endsection

@section('content')
<section class="page-section" id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">조원 소개</h2>
          <h3 class="section-subheading text-muted">oomori 짱짱 123</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <ul class="timeline" id='team-ul'></ul>
        </div>
      </div>
    </div>
</section>
@endsection