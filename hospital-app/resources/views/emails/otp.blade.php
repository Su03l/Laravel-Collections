<x-mail::message>
# مرحباً {{ $name }} 👋

نحن سعداء بانضمامك إلينا في **Hospital App**.

لإكمال عملية التحقق، يرجى استخدام الرمز التالي:

<div style="background-color: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 16px; padding: 30px; text-align: center; margin: 30px 0;">
<span style="display: block; font-size: 14px; color: #64748B; margin-bottom: 10px; font-weight: bold;">رمز التحقق الخاص بك</span>
<span style="font-family: 'Courier New', Courier, monospace; font-size: 42px; font-weight: 900; color: #0EA5E9; letter-spacing: 8px; display: block; margin: 0; line-height: 1;">{{ $otp }}</span>
</div>

هذا الرمز صالح لمدة **10 دقائق** فقط.

إذا لم تطلب هذا الرمز، يمكنك تجاهل هذه الرسالة بأمان.

مع تحياتنا،<br>
فريق {{ config('app.name') }}
</x-mail::message>
