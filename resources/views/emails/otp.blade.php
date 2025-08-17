@component('mail::message')
# مرحبًا {{ $userName }}

رمز التحقق الخاص بك هو:

@component('mail::panel')
**{{ $otpCode }}**
@endcomponent

يرجى استخدام هذا الرمز لتأكيد حسابك. ينتهي صلاحيته خلال دقائق.

شكرًا لاستخدامك خدماتنا.

تحياتنا،  
فريق الدعم
@endcomponent
