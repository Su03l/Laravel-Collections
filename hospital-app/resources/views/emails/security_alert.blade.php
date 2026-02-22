<x-mail::message>
# مرحباً {{ $name }} 👋

نود إخطارك بوجود نشاط أمني جديد على حسابك في **Hospital App**.

@if($type === 'login')
<div style="background-color: #F0F9FF; border-right: 4px solid #0EA5E9; padding: 15px; margin: 20px 0; border-radius: 8px;">
<strong>تم تسجيل دخول جديد إلى حسابك.</strong>
</div>
@elseif($type === 'password_changed')
<div style="background-color: #FEF2F2; border-right: 4px solid #EF4444; padding: 15px; margin: 20px 0; border-radius: 8px;">
<strong>لقد تم تغيير كلمة المرور الخاصة بك بنجاح.</strong>
</div>
@elseif($type === 'profile_updated')
<div style="background-color: #F0FDF4; border-right: 4px solid #10B981; padding: 15px; margin: 20px 0; border-radius: 8px;">
<strong>لقد تم تحديث بيانات ملفك الشخصي.</strong>
</div>
@endif

<x-mail::panel>
### تفاصيل النشاط:
@if(isset($details['time']))
- **الوقت:** {{ $details['time'] }}
@endif
@if(isset($details['ip']))
- **عنوان IP:** {{ $details['ip'] }}
@endif
@if(isset($details['device']))
- **الجهاز:** {{ $details['device'] }}
@endif
</x-mail::panel>

إذا كنت أنت من قام بهذا الإجراء، فيمكنك تجاهل هذا البريد.

أما إذا لم تكن أنت، فيرجى **تأمين حسابك فوراً** عبر تغيير كلمة المرور أو التواصل مع الدعم الفني.

مع تحياتنا،<br>
فريق الأمان في {{ config('app.name') }}
</x-mail::message>
