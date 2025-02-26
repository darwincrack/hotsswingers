@php
	$defaultValue = @$default ? $default : old('gender', 'male');
	$name = @$name ? $name : 'gender';
@endphp
{{Form::select(
$name,
array('male'=>@trans('messages.Male'), 'female'=>@trans('messages.Female'), 'transgender'=>@trans('messages.Transgender'), 'couple'=>@trans('messages.couple')),
$defaultValue,
 array('class'=>'form-control input-md')
 )}}