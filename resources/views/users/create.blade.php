@extends('layouts.app')

@section('script')
<script>
        
    window.onload = function(){

        var date = new Date();
        var year = date.getFullYear();
        var selectYear = document.getElementById("year");
        var selectMonth = document.getElementById("month"); 
        var selectDay = document.getElementById("day");
        

        for(var i=year-100;i<=year;i++){
                selectYear.add(new Option(i+"년",i));  
        }

        for(var i=1;i<=12;i++){
                selectMonth.add(new Option(i+"월",i));
        }
    
        for(var i=1;i<=31;i++){
                selectDay.add(new Option(i+"일",i));
        }
        
    }
</script>
@endsection

@section('style')
<style>
.birth {
    float: left;
    width: 32%;
    margin-bottom: 30px;
}

#year{
    margin-right: 2%;     
}

#month{
    margin-right: 2%;        
}   
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <h2 class="">{{ __('Register') }}</h2>
                <h3 class="">Please edit your membership information.</h3>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group text-center">
                    <span class="fa-stack fa-7x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                    </span>
                    <img class="rounded-circle" id="holder" src="" alt="" >
                </div>
                <div class="form-group text-center">
                    <div class="btn btn-primary" >사진등록<input type="file" style="display: none;"></div>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="이메일 *" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호 *" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="비밀번호 확인 *" required>
                </div>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="이름 *" required>
                </div>
                <div class="form-group birth-group">
                    <select id="year" name="year" class="form-control birth" required>
                        <option value="">년(4자)*</option>
                    </select>
                    <select id="month" name="month" class="form-control birth" required>
                        <option value="">월*</option>
                    </select>
                    <select id="day" name="day" class="form-control birth" required>
                        <option value="">일*</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="gender" name="gender" class="form-control" required>
                        <option value="">성별*</option>
                        <option value="woman">여</option>
                        <option value="men">남</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="hint" name="hint" class="form-control" required>
                        <option value="">힌트 선택*</option>
                        <option>내가 존경하는 인물은?</option>
                        <option>내가 졸업한 초등학교는?</option>
                        <option>나의 어릴 적 별명은?</option>
                        <option>가장 좋아하는 야구팀은?</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" id="answer" name="answer" class="form-control" placeholder="힌트 정답 *" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block text-uppercase" type="submit">가 입 하 기</button>
                    {{-- <button class="btn btn-primary btn-block text-uppercase" type="submit">수 정 완 료</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection