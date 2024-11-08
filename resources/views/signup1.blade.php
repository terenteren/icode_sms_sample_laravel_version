<x-layout>

<span class="sub_top">
	<span class="back" onClick="history.go(-1)"><img src="{{ asset('img/icon/left_arrow.svg') }}" alt="뒤로가기"></span>
	<span class="page_name">회원가입</span>
</span>

<span class="container_wrap sub_container_wrap">
	<span class="container sub_container sub_container1">
		<span class="input_wrap">
			<span class="input_title">반가워요! 우리 함께 시작할까요?</span>
			<span class="input_container">
                <span class="input_con">
                    <span class="input_name">먼저 회원가입이 필요해요</span>
                    <span class="input_box error_input_box"><input type="text" placeholder="이메일(아이디) 주소를 입력해주세요"></span>
                    <span class="input_error">*사용중인 이메일입니다. 다른 이메일주소를 입력해주세요.</span>
                </span>
                <span class="input_con">
                    <span class="input_name">이름</span>
                    <span class="input_box error_input_box"><input type="text" placeholder="이름"></span>
                </span>
                <span class="input_con">
                    <span class="input_name">핸드폰번호<span class="input_notice">03:00</span></span>
                    <span class="input_phone">
                        <span class="input_box"><input type="text" id="phone" name="phone_number" placeholder="핸드폰번호를 입력해주세요"></span>
                        <span class="input_phone_btn">인증</span>
                    </span>
                    <span class="input_box"><input type="text" name="verification_code" placeholder="인증번호 6자리"></span>
                </span>
                
			</span>
		</span>
	</span>
</span>

<span class="input_btn_wrap blur">
	<span class="input_btn check_input_btn">인증하기</span>
</span>


<span class="popup send_popup">
	<span class="popup_text">인증번호가 발송되었습니다.</span>
	<span class="popup_btn_wrap full_popup_btn_wrap">
		<span class="popup_btn popup_on close_popup_btn">확인</span>
	</span>
</span>

<span class="popup send_popup_fail">
	<span class="popup_text">인증번호가 잘못 입력되었습니다.</span>
	<span class="popup_btn_wrap full_popup_btn_wrap">
		<span class="popup_btn popup_on close_popup_btn">확인</span>
	</span>
</span>

<span class="popup check_popup1">
	<span class="popup_text">인증이 완료되었습니다.</span>
	<span class="popup_btn_wrap full_popup_btn_wrap">
		<a href="./signup2.php" class="popup_btn popup_on">확인</a> <!-- signup2로 이동 -->
	</span>
</span>

<script>

$(document).ready(function() {
    // 인증번호 호출 버튼 클릭 시
    $('.input_phone_btn').click(function() {
        const phoneNumber = $('input[name="phone_number"]').val();

        $.post('/send-verification-code', {
            phone_number: phoneNumber,
            _token: '{{ csrf_token() }}' // CSRF 토큰 추가
        })
            .done(response => {
                alert(response.message);
            })
            .fail(error => {
                alert(error.responseJSON.message);
            });
    });

    // 인증하기 버튼 클릭 시
    $('.check_input_btn').click(function() {
        const verificationCode = $('input[name="verification_code"]').val();

        $.post('/verify-code', {
            verification_code: verificationCode,
            _token: '{{ csrf_token() }}' // CSRF 토큰 추가
        })
            .done(response => {
                alert(response.message);
                window.location.href = './signup2.php'; // 다음 페이지로 이동
            })
            .fail(error => {
                alert(error.responseJSON.message);
            });
    });
});


</script>

</x-layout>
